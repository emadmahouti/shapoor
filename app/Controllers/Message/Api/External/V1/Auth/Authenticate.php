<?php

namespace App\Controllers\Message\Api\External\V1\Auth;


use App\Models\User;
use App\Models\UserAuth;
use App\Utils\JWTHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class Authenticate extends Controller
{
    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }

    protected function login()
    {
        $data = getJSONInput();

        if (!isset($data['user']))
            return $this->echoHttp([
                'status' => 'user must not be null'
            ], 404);

        $phone = $data['user'];

        try {
            $user = User::where(['phone_number' => $phone])->orWhere(['name' => $phone])->firstOrFail();

            if (!$user->active)
                return $this->echoHttp(['status' => 'access denied'], 403);

            $verify_date = Carbon::createFromFormat('Y-m-d H:i:s', $user->last_verify_code_date);
            $dif = Carbon::now()->diffInMinutes($verify_date);

            if ($dif > 2)
                $user->last_verify_code = rand(1000, 9999);

        } catch (ModelNotFoundException $e) {
            $user = new User();
            $user->phone_number = $phone;
            $user->last_verify_code = rand(1000, 9999);
        }

        $user->last_verify_code_date = Carbon::now()->format('y:m:d H:i');
        $user->save();

        unset($user->last_verify_code_date);
        unset($user->last_verify_code);

        return $this->echoNormal([
            'user' => $user
        ]);
    }

    protected function auth()
    {
        $data = getJSONInput();
        $token = $data['token'];

        try {
            $userAuth = UserAuth::where('jwt_token', $token)->firstOrFail();
            $user = $userAuth->user;

            if (!$user->active || !$userAuth->active)
                return $this->echoHttp(['status' => 'access denied'], 403);

            $userAuth->last_login = Carbon::now()->format('Y-m-d H:i');
            $userAuth->save();

            return $this->echoNormal([
                'jwt_token' => $userAuth->jwt_token,
                'user' => [
                    'phone_number' => $user->phone_number,
                    'name' => $user->name
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->echoHttp(['status' => 'user not found'], 404);
        }
    }

    protected function verify()
    {

        $data = getJSONInput();

        $phone = $data['user'];
        $code = $data['code'];

        if (is_null($phone) || is_null($code))
            return $this->echoHttp(['status' => 'not valid input'], 401);

        $user = User::where('phone_number', $phone)->orWhere('name', $phone)->first();

        if (!is_null($user)) {
            if ($user->last_verify_code == $code) {

                $verify_date = Carbon::createFromFormat('Y-m-d H:i:s', $user->last_verify_code_date);
                $dif = Carbon::now()->diffInMinutes($verify_date);

                if ($dif > 2)
                    return $this->echoHttp(['status' => 'اعتبار کد به پایان رسیده است'], 404);

                $userAuth = new UserAuth();

                $payload = [
                    'user_id' => $user->id,
                    'phone' => $user->phone,
                    'last_login' => Carbon::now()->timestamp
                ];

                $jwt = JWTHelper::encode($payload);

                $userAuth->jwt_token = $jwt;
                $userAuth->last_login = Carbon::now()->format('Y-m-d H:i');
                $userAuth->user_id = $user->id;

                $userAuth->save();

                return $this->echoNormal(['jwt_token' => $jwt]);
            } else {
                return $this->echoHttp(['status' => 'کد اعتبار سنجی نادرست است'], 404);
            }
        }

        return $this->echoNormal([]);
    }
}
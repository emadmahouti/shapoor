<?php

namespace App\Controllers\Message\Api\Internal\V1\Message;


use App\Models\UserAuth;
use App\Models\UserTrust;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class MessageController extends Controller
{
    private $user;

    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);

        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $jwt = extractAuthorizationToken($user);

        if ($jwt != null) {

            try {
                $userAuth = UserAuth::where('jwt_token', $jwt)->firstOrFail();

                if ($userAuth->active) {
                    $user = $userAuth->user;
                    if ($user->active) {
                        $this->user = $user;

                        return true;
                    }
                }

            } catch (ModelNotFoundException $e) {
                return $this->echoHttp([
                    'status' => $e->getMessage()
                ], 401);
            } catch (\Exception $e) {
                return $this->echoNormal([
                    'status' => $e->getMessage()
                ]);
            }
        } else {
            return $this->echoHttp([
                'status' => 'not allowed'
            ], 401);
        }

        return $this->echoNormal([
            'status' => "Not Found"
        ]);
    }

    protected function message()
    {
//        $trustUsers = UserTrust::with('user.message')
//            ->where('trust_user_id', 1)
//            ->get();

        $userId = $this->getRequest()->query->get("user");

        $trustUsers = UserTrust::with('user.limitMessages')->where([
            ['user_id', $userId],
            ['trust_user_id', 1],
            ['active', 1]
        ])->get();

        $data['data'] = [];
        foreach ($trustUsers as $trustUser) {
            if ($trustUser->active) {
                if ($trustUser->trust_user_id = 1) {
                    $user = $trustUser->user;

					$cloneUser['id'] = $user->id;
					$cloneUser['lastSeen'] = $user->last_seen;
					
                    $data['user'] = $cloneUser;
                    $data['data'] = $user->limitMessages;
                }
            }
        }

        $data['status'] = 'OK';

        return $this->echoNormal($data);
    }
}
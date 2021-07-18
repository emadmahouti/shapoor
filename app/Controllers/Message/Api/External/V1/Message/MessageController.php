<?php

namespace App\Controllers\Message\Api\External\V1\Message;


use App\Models\Message;
use App\Models\UserAuth;
use App\Models\UserTrust;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;
use Carbon\Carbon;

class MessageController extends Controller
{
    private $user;

    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);

        $authorize = $this->getRequest()->headers->get('Authorization');

        $jwt = extractAuthorizationToken($authorize);

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
            return $this->echoNormal([
                'status' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return $this->echoNormal([
                'status' => $e->getMessage()
            ]);
        }

        return $this->echoNormal([
            'status' => 'error'
        ]);
    }

    protected function messages()
    {
        $trustUsers = UserTrust::with('user.message')->where('trust_user_id', $this->user->id)->get();
        $message['data'] = [];

        foreach ($trustUsers as $trustUser) {
            if ($trustUser->active) {
                $user = $trustUser->user;
                $user->message;
                $message['data'][] = $user;
            }
        }

        $message['status'] = 'OK';

        return $this->echoNormal($message);
    }

    protected
    function insert()
    {
        $data = getJSONInput();

        if (is_null($data['text']))
            return $this->echoNormal(['status' => 'message is invalid']);

        if (is_null($data['phone_number']))
            return $this->echoNormal(['status' => 'phone is invalid']);

        $message = new Message();
        $message->user_id = $this->user->id ?: 0;
        $message->text = $data['text'];
        $message->phone_number = $data['phone_number'];
		
		$this->user->last_seen = Carbon::now()->timestamp;

		$this->user->save();
        $saved = $message->save();

        return $this->echoNormal(
            [
                'id' => $message->id,
                'status' => 'OK',
            ]
        );
    }
}
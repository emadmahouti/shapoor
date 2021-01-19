<?php
namespace App\Controllers\Message;


use App\Models\UserAuth;
use App\Models\UserTrust;
use Soda\Core\Http\Controller;

class Dashboard extends Controller
{

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

            } catch (\Exception $e) {
            };
        }

        redirect('/');

        return false;
    }


    protected function index()
    {
        $trustUsers = UserTrust::with('user')->where('trust_user_id', 1)->get();

        $data['data'] = [];
        foreach ($trustUsers as $trustUser) {
            if ($trustUser->active) {
                $user = $trustUser->user;
                $user->messages;

                $data['data'][] = $user;
            }
        }

        $data['status'] = 'OK';

        return $this->render('message.dashboard', $data);
    }
}
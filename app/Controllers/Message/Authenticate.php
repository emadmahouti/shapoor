<?php

namespace App\Controllers\Message;

use App\Models\UserAuth;
use Soda\Core\Http\Controller;

class Authenticate extends Controller
{

    var $redirect = null;

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

                        $this->redirect = "../dashboard";
                    }
                }

            } catch (\Exception $e) {
            };
        }

        return true;
    }

    protected function logout()
    {
        session_unset();
        session_destroy();

        redirect('../');
    }

    protected function login()
    {
		if($this->redirect != null)
			redirect($this->redirect);
			
        return $this->render('message.auth');
    }
}
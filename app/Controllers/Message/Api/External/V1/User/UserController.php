<?php
namespace App\Controllers\Message\Api\External\V1\User;


use App\Models\UserAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class UserController extends Controller
{

    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);

        $jwt = $this->getRequest()->query->get('Authorization');

        try {
            $userAuth = UserAuth::where('jwt_token', $jwt)->firstOrFail();
            if ($userAuth->active) {
                $user = $userAuth->user;
                if ($user->active) {
                    $this->user = $user;

                    return true;
                }
            }

        } catch (ModelNotFoundException $exception) {
        }

        return $this->echoNormal('end');
    }

    protected function trustUser() {

    }
}
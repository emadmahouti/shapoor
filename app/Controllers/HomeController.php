<?php

namespace App\Controllers;

use Soda\Core\Http\Controller;

class HomeController extends Controller
{
    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }

    function index() {
        redirect('auth/login');
    }

}
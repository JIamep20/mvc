<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.10.2016
 * Time: 0:05
 */

namespace App\Controllers;


use Framework\Exception;
use Framework\DB;

class AuthController extends MyController
{
    /**
     * Shows login form on '/login'(get) route
     */
    public function show_login_form()
    {
        if($this->is_authorized()) {
            redirect();
        }

        return render('auth/login');
    }

    /**
     * Handles '/login'(POST) authorization route
     * @param $params
     * @param $request
     * @throws Exception
     */
    public function login($params, $request)
    {
        $data = DB::query("select * from users where `login` = '$request->login';");
        
        if($data->num_rows == 1) {
            $row = mysqli_fetch_assoc($data);
            if(md5($request->password) == $row['password'])
            {
                $_SESSION['login'] = $request->login;
                redirect('/');
            }
            $_SESSION['info'] = 'Login or password are incorrect.';
            redirect('/login');
        } else {
            $_SESSION['info'] = 'Login or password are incorrect.';
            redirect('/login');
        }
        
    }

    /**
     * Handles log out
     */
    public function logout()
    {
        session_unset();
        redirect();
    }

    /**
     * Shows registration form on '/login'(get) route
     */
    public function show_register_form()
    {
        if($this->is_authorized()) {
            redirect();
        }

        return render('auth/register');
    }

    /**
     * Handles '/register'(POST) authorization route
     * @param $params
     * @param $request
     * @throws Exception
     */
    public function register($params, $request)
    {
        if(!length($request->login) || !length($request->password) || !length($request->first_name) || !length($request->last_name)) {
            $_SESSION['info'] = 'All fields are required';
            redirect('/register');
        }

        if(!DB::query("insert into users(`first_name`, `last_name`, `login`, `password`) values('$request->first_name', '$request->last_name', '$request->login', '" . md5($request->password) . "');")) {
            throw new Exception(DB::getError(), 500);
        }

        redirect('/login');
    }
}
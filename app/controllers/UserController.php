<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Config;
use app\lib\Input;
use app\lib\Redirect;
use app\lib\Validate;
use app\lib\Hash;
use app\lib\Token;
use app\models\User;

class UserController extends Controller
{

    public function indexAction()
    {

        $user = new User();

        if ($user->isLoggedIn()) {
            Redirect::to('user/');
        }

        $vars = [
            'title' => 'Welcome',
            'token' => Token::generate()
        ];

        $this->view->render($vars['title'], $vars);
    }

    public function signupAction()
    {
        $user = new User();

        if ($user->isLoggedIn()) {
            Redirect::to('user/');
        }

        if (!Input::exists('post')) {
            Redirect::to('user/signup');
        }

        if (Config::get('tokens/validate_token')) {

            if (!Token::check(Input::get('signup_token_field'))) {
                Redirect::to('/');
            }
        }

        $validate  = new Validate();
        $validation = $validate->check($_POST, array(
            'fullname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'email' => array(
                'required' => true,
                'unique' => 'users',
                'email' => true
            ),
            'password' => array(
                'required' => true,
                'min' => 5,
                'max' => 20
            )
        ));

        if ($validation->passed()) {
            // Valid inputs, register!

            $salt = Hash::salt(32);
            $password = Hash::make(Input::get('password'), $salt);

            $fields = array(
                'fullname' => Input::get('fullname'),
                'email' => Input::get('email'),
                'salt' => $salt,
                'password' => $password
            );

            $user->create($fields);

            $user->find(Input::get('email'));

            $user->login(Input::get('email'), Input::get('password'));

            Redirect::to('/user');
        } else {
            // Validation error
            $vars['post'] = $_POST;
            $vars['errors'] = $validation->errors();
        }


        $vars['title'] = 'Welcome';
        $vars['token'] = Token::generate();

        $this->view->render($vars['title'], $vars);
    }

    public function loginAction()
    {

        $user = new User();

        if ($user->isLoggedIn()) {
            Redirect::to('user/');
        }

        if (!Input::exists()) {
            Redirect::to('user/login');
        }

        if (Config::get('tokens/validate_token')) {

            if (!Token::check(Input::get('login_token_field'))) {
                Redirect::to('/');
            }
        }

        $validate  = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array(
                'required' => true,
                'email' => true
            ),
            'password' => array(
                'required' => true,
            )
        ));

        if ($validation->passed()) {
            if ($user->login(Input::get('email'), Input::get('password'))) {
                // Login successfull!
                Redirect::to('user/');
            } else {
                // Login failed!
                $vars['errors'] = ['password' => 'Email or password incorrect!'];
                $vars['post'] = $_POST;
            }
        } else {    // Validation not passed!
            $vars['post'] = $_POST;
            $vars['errors'] = $validation->errors();
        }

        $vars['title'] = 'Welcome';
        $vars['token'] = Token::generate();

        $this->view->render($vars['title'], $vars);
    }

    public function updateAction()
    {

        $user = new User();

        if (!$user->isLoggedIn()) {
            Redirect::to('/');
        }

        if (Input::exists('post')) {

            if (Config::get('tokens/validate_token')) {

                if (!Token::check(Input::get('update_token_field'))) {
                    Redirect::to('/');
                }
            }

            $validate  = new Validate();
            $fieldToValidate = [];

            if (Input::get('fullname') !== $user->data()->fullname) {
                $fieldToValidate['fullname'] = array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                );
            }

            if (Input::get('email') !== $user->data()->email) {
                $fieldToValidate['email'] = array(
                    'required' => true,
                    'unique' => 'users',
                    'email' => true
                );
            }

            $validation = $validate->check($_POST, $fieldToValidate);

            if ($validation->passed()) {

                $fields = array(
                    'fullname' => Input::get('fullname'),
                    'email' => Input::get('email'),
                );

                $user->updateUser($user->data()->id, $fields);

                $vars['user'] = $user->data();

                // Add attributes to database!
                $user->saveValidFormAttributes($user, $_POST);
            } else {
                // Validation failed!

                // Add attributes to database!
                $user->saveValidFormAttributes($user, $_POST);

                $vars['user'] = $user->data();
                $vars['errors'] = $validation->errors();
                $vars['post'] = $_POST;
            }
        }


        $vars['title'] = 'Welcome';
        $vars['user'] = $user->data();
        $vars['token'] = Token::generate();
        $vars['attributes'] = $user->getAttributesJSON();

        $this->view->render($vars['title'], $vars);
    }

    public function logoutAction()
    {
        $user = new User();
        $user->logout();
        Redirect::to('/');
    }

    public function deleteAction()
    {
        $user = new User();

        if ($user->isLoggedIn()) {
            $user->deleteUser($user->data()->id);
            Redirect::to('/');
        }

        Redirect::to('/');
    }
}

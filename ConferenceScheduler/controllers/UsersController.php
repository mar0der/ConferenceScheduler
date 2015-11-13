<?php

namespace My\ShoppingCart\Controllers;

use My\Mvc\BaseController;
use My\Mvc\View;
use My\ShoppingCart\models\ProductsModel;
use My\ShoppingCart\Models\UserModel;
use My\ShoppingCart\Models\ViewModels\User\MyProducts;
use My\ShoppingCart\Models\ViewModels\User\ProfileUser;
use My\ShoppingCart\Models\ViewModels\User\RegisterUser;

class UsersController extends BaseController
{
    /**
     * [Route("register")]
     */
    public function register(\My\ShoppingCart\Models\BindingModels\User\RegisterUser $model = null)
    {
        if ($this->session->userId != null) {
            $this->redirect('/profile');
        }
        View::registerForm(\My\ShoppingCart\Forms\RegisterForm::create($model->username, $model->email));
        $userViewModel = new RegisterUser();
        if ($model) {
            if ($model->modelState == true) {
                View::registerForm(\My\ShoppingCart\Forms\RegisterForm::create());
                $userModel = new UserModel();
                $userViewModel->errors = $userModel->register($model);

                if (!count($userViewModel->errors)) {
                    $userViewModel->success = true;
                }
            } else {
                $userViewModel->errors = $model->errors;
            }
        }

        $view = View::getInstance();
        View::title('Register');
        $view->appendToLayout('header', 'header');
        $view->appendToLayout('body', 'user.register');
        $view->appendToLayout('footer', 'footer');
        $view->display('layouts.default', $userViewModel);
    }

    /**
     * [Route("login")]
     */
    public function login(\My\ShoppingCart\Models\BindingModels\User\LoginUser $model = null)
    {
        if ($this->session->userId != null) {
            $this->redirect('/profile');
        }



        $viewModel = new \My\ShoppingCart\Models\ViewModels\User\LoginUser();
        if ($model) {
            if ($model->modelState) {
                $username = $model->username;
                $password = $model->password;
                $userIp = $_SERVER['REMOTE_ADDR'];

                $userModel = new UserModel();
                $result = $userModel->login($username, $password, $userIp);

                if($result == 'banned'){
                    $this->redirect('/login');
                    die;
                }

                if (!$result) {
                    $viewModel->errors[] = 'Invalid password.';
                } else {
                    $this->session->userId = $result['id'];
                    $this->session->user = $result;
                    $this->redirect('/profile');
                }
            } else {
                $viewModel->errors = $model->errors;
            }
        }

        $view = View::getInstance();
        View::title('Login');
        View::loginForm(\My\ShoppingCart\Forms\LoginForm::create($model->username));
        $view->appendToLayout('header', 'header');
        $view->appendToLayout('body', 'user.login');
        $view->appendToLayout('footer', 'footer');
        $view->display('layouts.default', $viewModel);
    }

    /**
     * [Route("profile")]
     */
    public function profile()
    {
        if ($this->session->userId == null) {
            $this->redirect('/login');
        }

        $myId = $this->session->userId;
        $userId = $this->input->get(0, "int");
        if(isset($userId) && $userId != 0 &&  $userId != $myId && $this->isAdmin()){
            $userProfileId = $userId;
        }else{
            $userProfileId = $myId;
        }

        $userModel = new UserModel();
        $userInfo = $userModel->getUserInfo($userProfileId);
        $viewModel = new ProfileUser();
        $viewModel->username = $userInfo['username'];
        $viewModel->money = $userInfo['money'];
        $viewModel->email = $userInfo['email'];
        $viewModel->role = $userInfo['role'];
        $viewModel->id = $userInfo['id'];

        $view = View::getInstance();
        View::title('Profile');
        $view->appendToLayout('header', 'header');
        $view->appendToLayout('body', 'user.profile');
        $view->appendToLayout('footer', 'footer');
        $view->display('layouts.default', $viewModel);
    }

    public function myProducts()
    {
        if(!$this->session->userId){
            $this->redirect('/');
            exit;
        }

        $productsModel = new ProductsModel();
        $myProducts = $productsModel->getUserProducts($this->session->userId);

        $productView = new MyProducts();
        $productView->products = $myProducts;

        $view = View::getInstance();
        View::title('My Products');
        $view->appendToLayout('header', 'header');
        $view->appendToLayout('body', 'user.myProducts');
        $view->appendToLayout('footer', 'footer');
        $view->display('layouts.default', $productView);
    }

    /**
     * [Route("logout")]
     */
    public function logout()
    {
        $this->session->destroySession();
        $this->redirect('/login');
    }
}
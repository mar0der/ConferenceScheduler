<?php

namespace My\ShoppingCart\Controllers\Admin;


use My\Mvc\BaseController;
use My\ShoppingCart\Models\UserModel;

class UsersController extends BaseController
{
    public function ban()
    {
        if(!$this->isAdmin()){
            $this->redirect('/profile');
        }

        $userId = $this->input->get(0, "int");
        $usersModel = new UserModel();
        $usersModel->banUser($userId, $this->session->user['id']);
        $this->redirect('/profile');
    }
}
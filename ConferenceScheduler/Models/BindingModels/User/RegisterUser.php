<?php

namespace My\ShoppingCart\Models\BindingModels\User;


class RegisterUser extends \My\Mvc\BaseBindingModel
{
    /**
     * [minLength(2)]
     */
    public $username;
    /**
     * [minLength(4)]
     * [matches({passwordAgain})]
     */
    public $password;
    /**
     * [email]
     */
    public $email;
    public $passwordAgain;
}
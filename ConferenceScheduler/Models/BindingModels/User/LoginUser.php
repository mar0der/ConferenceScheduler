<?php

namespace My\ShoppingCart\Models\BindingModels\User;

class LoginUser extends \My\Mvc\BaseBindingModel
{
    /**
     * [required]
     * [minLength(2)]
     */
    public $username;
    /**
     * [required]
     */
    public $password;
}
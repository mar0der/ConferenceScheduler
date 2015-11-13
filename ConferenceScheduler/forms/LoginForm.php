<?php
namespace My\ShoppingCart\Forms;

use My\Mvc\ViewHelpers\Form;
use My\Mvc\ViewHelpers\Input;

class LoginForm
{
    public static function create($username = '')
    {
        $form = new Form();
        $form->addElement(
            (new Input('text', 'username'))
                ->setAttribute('placeholder', 'Username')
                ->setAttribute('value', $username))
            ->addElement(
                (new Input('password', 'password'))
                    ->setAttribute('placeholder', 'Password'))
            ->addElement(
                (new Input('submit', 'submit'))
                    ->setAttribute('value', 'Login'));

        return $form->render();
    }
}
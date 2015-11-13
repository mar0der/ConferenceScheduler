<?php
namespace My\ShoppingCart\Forms;

use My\Mvc\ViewHelpers\Form;
use My\Mvc\ViewHelpers\Input;

class RegisterForm
{
    public static function create($username = '', $email = '')
    {
        $form = new Form();
        $form->addElement(
            (new Input('text', 'username'))
                ->setAttribute('placeholder', 'Username')
                ->setAttribute('value', $username))
            ->addElement(
                (new Input('text', 'email'))
                    ->setAttribute('placeholder', 'Email')
                    ->setAttribute('value', $email))
            ->addElement(
                (new Input('password', 'password'))
                    ->setAttribute('placeholder', 'Password'))
            ->addElement(
                (new Input('password', 'passwordAgain'))
                    ->setAttribute('placeholder', 'Password again'))
            ->addElement(
                (new Input('submit', 'submit'))
                    ->setAttribute('value', 'Register'));

        return $form->render();
    }
}
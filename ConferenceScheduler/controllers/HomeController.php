<?php

namespace My\ShoppingCart\Controllers;

class HomeController extends \My\Mvc\BaseController
{
    /**
     * [Route("nqkyvHome")]
     */
    public function Index()
    {

        $viewModel =  new \My\ShoppingCart\Models\ViewModels\HomeViewModel();
        $viewModel->setBody('Body') ;

        $view = \My\Mvc\View::getInstance();
        $view->appendToLayout('header', 'header');
        $view->appendToLayout('body', 'index');
        $view->appendToLayout('footer', 'footer');
        $view->display('layouts.default', $viewModel);

    }
}
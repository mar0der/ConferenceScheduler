<?php

namespace My\ShoppingCart\Controllers\Admin;
use My\Mvc\BaseController;

/**
 * [RoutePrefix("admina/")]
 */
class HomeController extends BaseController
{
    /**
     * [Route("neshtosi")]
     */
    public function Index(){
        if(!$this->isAdmin()) {
            $this->redirect('/profile');
        }
    }
}
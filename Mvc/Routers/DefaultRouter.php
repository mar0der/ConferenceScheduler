<?php

namespace My\Mvc\Routers;

class DefaultRouter implements \My\Mvc\Routers\IRouter
{
    private $_controller = null;
    private $_method = null;
    private $_params = array();

    public function getURI()
    {
        return $_GET['uri'];
    }

    public function getPost()
    {
        return $_POST;
    }


}
<?php

namespace My\Mvc;


class BaseController
{
    /**
     * @var  \My\Mvc\App
     */
    public $app;
    /**
     * @var \My\Mvc\View
     */
    public $view;
    /**
     * @var \My\Mvc\Config
     */
    public $config;
    /**
     * @var \My\Mvc\InputData
     */
    public $input;
    /**
     * @var \My\Mvc\Session\ISession
     */
    public $session;

    public function __construct()
    {
        $this->app = \My\Mvc\App::getInstance();
        $this->view = \My\Mvc\View::getInstance();
        $this->config = \My\Mvc\Config::getInstance();
        $this->input = \My\Mvc\InputData::getInstance();
        $this->session = $this->app->getSession();
        View::logged((bool)$this->session->userId);
        View::role($this->session->user['role']);
    }

    public function jsonResponse()
    {
    }

    public function redirect($url) {
        header('Location: '  . $url);
    }

    public function isAdmin()
    {
        if($this->session->user['role'] == 3) {
            return true;
        }
        return false;
    }

    public function isEditor()
    {
        if($this->session->user['role'] == 2) {
            return true;
        }
        return false;
    }
}
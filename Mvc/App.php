<?php

namespace My\Mvc;

include_once 'Loader.php';

class App
{
    private static $_instance;
    private $_config = null;
    private $_frontController;
    private $router = null;
    private $_dbConnections;
    private $_session;

    private function __construct()
    {
        set_exception_handler(array($this, '_exceptionHandler'));
        \My\Mvc\Loader::registerNamespace('My\Mvc', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        \My\Mvc\Loader::registerAutoLoad();
        $this->_config = \My\Mvc\Config::getInstance();
    }

    public function run()
    {
        if ($this->_config->getConfigFolder() == null) {
            $this->_config->setConfigFolder("../config");
        }

        $this->_frontController = \My\Mvc\FrontController::getInstance();
        if ($this->router instanceof \My\Mvc\Routers\IRouter) {
            $this->_frontController->setRouter($this->router);
        } elseif ($this->router == 'JsonRPCRouter') {
            // TODO fix when RPC is done
            $this->_frontController->setRouter(new \My\Mvc\Routers\DefaultRouter());
        } elseif ($this->router == 'CLIRouter') {
            $this->_frontController->setRouter(new \My\Mvc\Routers\DefaultRouter());
        } else {
            $this->_frontController->setRouter(new \My\Mvc\Routers\DefaultRouter());
        }

        $_sessionConfig = $this->_config->app['session'];
        if ($_sessionConfig['autostart']) {
            if ($_sessionConfig['type'] == 'native') {
                $_s = new \My\Mvc\Session\NativeSession(
                    $_sessionConfig['name'],
                    $_sessionConfig['lifetime'],
                    $_sessionConfig['path'],
                    $_sessionConfig['domain'],
                    $_sessionConfig['secure']);
            } elseif ($_sessionConfig['type'] == 'database') {
                $_s = new \My\Mvc\Session\DBSession(
                    $_sessionConfig['dbConnection'],
                    $_sessionConfig['name'],
                    $_sessionConfig['dbTable'],
                    $_sessionConfig['lifetime'],
                    $_sessionConfig['path'],
                    $_sessionConfig['domain'],
                    $_sessionConfig['secure']
                );
            } else {
                throw new \Exception('No valid session.', 500);
            }

            $this->setSession($_s);
        }

        $this->_frontController->dispatch();
    }

    /**
     * @return \My\Mvc\App
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new \My\Mvc\App();
        }

        return self::$_instance;
    }

    public function setConfigFolder($path)
    {
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder()
    {
        return $this->_config->getConfigFolder();
    }

    /**
     * @return Config|null
     */
    public function getConfig()
    {
        return $this->_config;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function setSession(\My\Mvc\Session\ISession $session)
    {
        $this->_session = $session;
    }

    public function getSession()
    {
        return $this->_session;
    }

    public function getDBConnection($connection = 'default')
    {
        if (!$connection) {
            throw new \Exception('No connection identifier provided.', 500);
        }
        if ($this->_dbConnections[$connection]) {
            return $this->_dbConnections[$connection];
        }

        $databaseConfig = $this->getConfig()->database;
        if (!$databaseConfig[$connection]) {
            throw new \Exception('No valid connection identifier provided.', 500);
        }

        $dbh = new \PDO(
            $databaseConfig[$connection]['dsn'],
            $databaseConfig[$connection]['username'],
            $databaseConfig[$connection]['password'],
            $databaseConfig[$connection]['pdo_options']);
        $this->_dbConnections[$connection] = $dbh;

        return $dbh;
    }

    public function displayError($errorCode)
    {
        try {
            $view = \My\Mvc\View::getInstance();
            View::title('Error ' . $errorCode);
            $view->appendToLayout('header', 'header');
            $view->appendToLayout('body', 'errors.' . $errorCode);
            $view->appendToLayout('footer', 'footer');
            $view->display('layouts.default');
        } catch(\Exception $ex) {
            $error = \My\Mvc\Common::headerStatus($errorCode);
            echo '<h1>' . $error . '</h1>';
            exit;
        }
    }

    public function _exceptionHandler(\Exception $ex)
    {
        if ($this->_config && $this->_config->app['displayExceptions'] === true) {
            echo '<pre>' . print_r($ex, true) . '</pre>';
        } else {
            $this->displayError($ex->getCode());
        }
    }

    public function __destruct()
    {
        if ($this->_session != null) {
            $this->_session->saveSession();
        }
    }

}
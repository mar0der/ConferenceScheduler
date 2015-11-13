<?php

namespace My\Mvc\Routers;

interface IRouter
{
    public function getURI();

    public function getPost();
}
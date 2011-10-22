<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initPlaceholders()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $view->doctype('HTML5');

        $view->headMeta()->setCharset('UTF-8');

        // Set the initial title and separator:
        $view->headTitle("xkcd translation")
             ->setSeparator(' :: ');

        // Set the initial stylesheet:
        $view->headLink()->prependStylesheet($view->baseUrl() . '/css/style.css');

        // Set the initial js:
        $view->headScript()->appendFile($view->baseUrl() . '/js/modernizr-2.0.6.min.js')
                           ->appendFile($view->baseUrl() . '/js/libs/jquery-1.6.2.js')
                           ->appendFile($view->baseUrl() . '/js/plugins.js')
                           ->appendFile($view->baseUrl() . '/js/script.js');
    }

    protected function _initRoutes()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        $comics = new Zend_Controller_Router_Route(
            ':id/',
            array(
                'action'      => 'index',
                'controller'  => 'index',
                'module'      => 'comics'
            ),
            array('id' => '\d+')
        );
        $router->addRoute('comics', $comics);
    }

}


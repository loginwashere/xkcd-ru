<?php

class Parser_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $manager = new Parser_Model_Comics;
        $this->view->result = $manager->parseAll();
    }


}


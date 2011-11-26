<?php

class Comics_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('index', 'json')
                    ->initContext();        
    }

    public function indexAction()
    {
        $id = $this->_getParam('id', null, 'int');
        $model = new Comics_Model_Comics();
        $this->view->paginator = $model->getComics($id);
    }
}
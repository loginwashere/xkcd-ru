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
        
        $paginator = $model->getComics($id);
        $this->view->comics = $paginator->getCurrentItems()->current();
        $this->view->pagination = $this->view->paginationControl(
            $paginator,
            'Sliding',
            'pagination.phtml'
        );
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->json(
                array(
                    'comics' => $this->view->comics,
                    'pagination' => $this->view->pagination
                )
            );
        }
    }
}
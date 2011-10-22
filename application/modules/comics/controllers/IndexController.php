<?php

class Comics_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = $this->_getParam('id', null, 'int');
        if (!$id) {
            //throw new Zend_Controller_Action_Exeption('Page not found');
            $id = 1;
        }
        $model = new Comics_Model_DbTable_Comics;

        $adapter = new Zend_Paginator_Adapter_DbSelect($model->select()->from('comics'));
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(1);
        $paginator->setCurrentPageNumber($id);

        $this->view->paginator = $paginator;
        /*

        $this->view->comics = $model->find($id)->current();
        if (! $this->view->comics) {
            throw new Zend_Controller_Action_Exeption('Comics not found');
        }*/
    }


}


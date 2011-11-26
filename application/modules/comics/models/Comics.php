<?php

class Comics_Model_Comics
{
    const DEFAULT_COMICS = 1;
    const COMICS_PER_PAGE = 1;
    
    public function getComics($id = self::DEFAULT_COMICS)
    {
        $model = new Comics_Model_DbTable_Comics;
        $select = $model->select()
                ->from('comics')
                ->limitPage($id, self::COMICS_PER_PAGE);
        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($id)
                ->setItemCountPerPage(1);
        return $paginator;
    }
}
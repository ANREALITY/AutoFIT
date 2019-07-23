<?php
namespace Base\Paginator;

use Zend\Paginator\Paginator as ZendPaginator;

class Paginator extends ZendPaginator
{
    
    public function setCurrentItems($currentItems)
    {
        $this->currentItems = $currentItems;
        return $this;
    }

}

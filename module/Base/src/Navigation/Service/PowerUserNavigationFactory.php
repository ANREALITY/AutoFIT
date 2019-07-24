<?php
namespace Base\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class PowerUserNavigationFactory extends DefaultNavigationFactory
{

    protected function getName()
    {
        return 'power-user';
    }

}

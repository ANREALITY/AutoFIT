<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class ProtocolSetForProtocolServerTargetFieldset extends AbstractProtocolSetForProtocolServerFieldset
{

    protected function getProtocols()
    {
        $protocols = parent::getProtocols();
        if (array_key_exists('HTTPs', $protocols)) {
            unset($protocols['HTTPs']);
        }
        return $protocols;
    }

}

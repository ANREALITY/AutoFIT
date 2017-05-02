<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class ProtocolSetForProtocolServerTargetFieldset extends AbstractProtocolSetForProtocolServerFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('protocol_set', ['label' => _('protocol')]);
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'radio',
                'name' => 'protocols',
                'options' => [
                    'label' => _('protocols'),
                    'label_attributes' => [
                        'class' => 'col-md-1 protocol-field'
                    ],
                    'value_options' => $this->getValueOptions()
                ],
                'attributes' => [
                    'required' => 'required'
                ]
            ]);
    }

    protected function getProtocols()
    {
        $protocols = parent::getProtocols();
        if (array_key_exists('WebDAV', $protocols)) {
            unset($protocols['WebDAV']);
        }
        return $protocols;
    }

}

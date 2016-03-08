<?php
namespace FileTransferRequest\Form\Fieldset;

class EndpointCdTandemSourceFieldset extends EndpointCdTandemFieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        // Hydrator and Prototype are set in the factory.
        // $this->setHydrator(new ClassMethods(false));
        // $this->setObject(new FileTransferRequest());

        $this->setLabel(_('Source') . ' ' . _('AS400'));
    }
}

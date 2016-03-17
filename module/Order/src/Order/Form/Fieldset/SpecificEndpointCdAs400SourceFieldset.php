<?php
namespace Order\Form\Fieldset;

class SpecificEndpointCdAs400SourceFieldset extends AbstractSpecificEndpointCdAs400Fieldset
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Source - AS400'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'Order\Form\Fieldset\BasicEndpointCdSource',
                'name' => 'basic_endpoint',
                'options' => []
            ]);
    }
}

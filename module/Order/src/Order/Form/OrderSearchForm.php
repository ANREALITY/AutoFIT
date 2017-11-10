<?php
namespace Order\Form;

use Zend\Form\Form;

class OrderSearchForm extends Form
{

    protected $errorMessages = [];

    public function init()
    {
        $this->add(
            [
                'name' => 'filter',
                'type' => 'Order\Form\Fieldset\Filter',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'sort',
                'type' => 'Order\Form\Fieldset\Sort',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => _('show'),
                    'class' => 'btn btn-default'
                ]
            ]);
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function getMessages($elementName = null)
    {
        if ($elementName) {
            $messages = parent::getMessages($elementName);
        } else {
            $messages = array_merge(parent::getMessages($elementName), $this->getErrorMessages());
        }
        return $messages;
    }

    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
        return $this;
    }

}

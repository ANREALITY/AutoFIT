<?php
namespace AuditLogging\Form;

use Zend\Form\Form;

class AuditLogForm extends Form
{

    protected $errorMessages = [];

    public function init()
    {
        $this->add(
            [
                'name' => 'filter',
                'type' => 'AuditLogging\Form\Fieldset\Filter',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'sort',
                'type' => 'AuditLogging\Form\Fieldset\Sort',
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

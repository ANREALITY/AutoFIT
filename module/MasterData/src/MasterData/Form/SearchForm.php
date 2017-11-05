<?php
namespace MasterData\Form;

use Zend\Form\Form;

class SearchForm extends Form
{

    protected $errorMessages = [];

    public function init()
    {
        $this->add(
            [
                'name' => 'filter',
                'type' => 'MasterData\Form\Fieldset\Filter',
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

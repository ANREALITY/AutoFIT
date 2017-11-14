<?php
namespace Order\Form;

use Zend\Form\Form;

class OrderSearchForm extends Form
{

    /** @var string */
    const SEARCH_TYPE_ALL = 'all_orders';
    /** @var string */
    const SEARCH_TYPE_OWN = 'own_orders';

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

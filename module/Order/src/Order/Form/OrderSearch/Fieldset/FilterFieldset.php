<?php
namespace Order\Form\OrderSearch\Fieldset;

use Order\Form\OrderSearch\OrderSearchForm;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FilterFieldset extends Fieldset implements InputFilterProviderInterface
{

    /** @var string */
    protected $username;
    /** @var string */
    protected $searchType;

    public function __construct($name = null, $options = [], $username, $searchType = OrderSearchForm::SEARCH_TYPE_ALL)
    {
        parent::__construct('user', $options);

        $this->username = $username;
        $this->searchType = $searchType;
    }

    public function init()
    {

        $this->add(
            [
                'name' => 'username',
                'type' => 'text',
                'options' => [
                    'label' => _('username'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control autocomplete-username'
                ]
            ]);
        if ($this->searchType === OrderSearchForm::SEARCH_TYPE_OWN) {
            $this->getElements()['username']->setAttribute('value', $this->username);
            $this->getElements()['username']->setAttribute('readonly', 'readonly');
        }

        $this->add(
            [
                'name' => 'change_number',
                'type' => 'text',
                'options' => [
                    'label' => _('change number'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control autocomplete-change-number'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'application_technical_short_name',
                'options' => [
                    'label' => _('application according to the SI'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-application-number order-search-autocomplete-application'
                ]
            ]);

        $this->add(
            [
                'name' => 'environment',
                'type' => 'Order\Form\OrderSearch\Fieldset\Environment',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return $inputFilterSpecification;
    }

}

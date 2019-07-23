<?php
namespace Order\Form\OrderSearch\Fieldset;

use Base\DataObject\LogicalConnection;
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

        $this->add(
            [
                'name' => 'server',
                'type' => 'Order\Form\OrderSearch\Fieldset\ServerCommon',
                'options' => []
            ]);

        $this->add(
            [
                'type' => 'MultiCheckbox',
                'name' => 'connection_type',
                'options' => [
                    'label' => _('connection type'),
                    'label_attributes' => [
                        'class' => 'col-md-6'
                    ],
                    'value_options' => [
                        LogicalConnection::TYPE_CD => LogicalConnection::TYPE_CD,
                        LogicalConnection::TYPE_FTGW => LogicalConnection::TYPE_FTGW,
                    ],
                ],
                'attributes' => [
                    'value' => [
                        LogicalConnection::TYPE_CD,
                        LogicalConnection::TYPE_FTGW,
                    ]
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return $inputFilterSpecification;
    }

}

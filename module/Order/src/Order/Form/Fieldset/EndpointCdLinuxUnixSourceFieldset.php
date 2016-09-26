<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\EndpointCdLinuxUnix;

class EndpointCdLinuxUnixSourceFieldset extends AbstractEndpointCdLinuxUnixFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Source - LinuxUnix'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'radio',
                'name' => 'transmission_type',
                'options' => [
                    'label' => _('transmission type'),
                    'value_options' => [
                        [
                            'value' => EndpointCdLinuxUnix::TRANSMISSION_TYPE_TXT,
                            'label' => EndpointCdLinuxUnix::TRANSMISSION_TYPE_TXT,
                            'selected' => true
                        ],
                        [
                            'value' => EndpointCdLinuxUnix::TRANSMISSION_TYPE_BIN,
                            'label' => EndpointCdLinuxUnix::TRANSMISSION_TYPE_BIN
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12 '
                    ]
                ],
                'attributes' => [
                    'class' => 'field-transmission-type'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'transmission_interval',
                'options' => [
                    'label' => _('transmission interval'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-transmission-interval',
                    'value' => '0,15,30,45 * * * *'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'fetch_interval',
                'options' => [
                    'label' => _('fetch interval'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-fetch-interval',
                    'value' => '0 */2 * * *'
                ]
            ]);

        $this->add(
            [
                'name' => 'include_parameter_set',
                'type' => 'Order\Form\Fieldset\IncludeParameterSet',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'transmission_interval' => [
                'required' => false,
                'filters' => [
                    [
                        'name' => 'Zend\Filter\StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Zend\Validator\Regex',
                        'options' => [
                            'pattern' => '/' . '^((0*([0-9]|[1-5][0-9])|\*)(-0*([0-9]|[1-5][0-9]))?(\/\d+)?,)*' .
                                 '(0*([0-9]|[1-5][0-9])|\*)(-0*([0-9]|[1-5][0-9]))?(\/\d+)?\s' .
                                 '((0*([0-9]|1[0-9]|2[0-3])|\*)(-0*([0-9]|1[0-9]|2[0-3]))?(\/\d+)?,)*' .
                                 '(0*([0-9]|1[0-9]|2[0-3])|\*)(-0*([0-9]|1[0-9]|2[0-3]))?(\/\d+)?\s' .
                                 '((0*([1-9]|[12][0-9]3[01])|\*)(-0*([1-9]|[12][0-9]3[01]))?(\/\d+)?,)*' .
                                 '(0*([1-9]|[12][0-9]3[01])|\*)(-0*([1-9]|[12][0-9]3[01]))?(\/\d+)?\s' .
                                 '((0*([1-9]|1[0-2])|\*)(-0*([1-9]|1[0-2]))?(\/\d+)?,)*' .
                                 '(0*([1-9]|1[0-2])|\*)(-0*([1-9]|1[0-2]))?(\/\d+)?\s' .
                                 '((0*[0-7]|\*)(-0*[0-7])?(\/\d+)?,)*' . '(0*[0-7]|\*)(-0*[0-7])?(\/\d+)?$' . '/',
                            'message' => _('The input does not match against the crontab pattern')
                        ]
                    ]
                ]
            ],
            'fetch_interval' => [
                'required' => false,
                'filters' => [
                    [
                        'name' => 'Zend\Filter\StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Zend\Validator\Regex',
                        'options' => [
                            'pattern' => '/' . '^((0*([0-9]|[1-5][0-9])|\*)(-0*([0-9]|[1-5][0-9]))?(\/\d+)?,)*' .
                                 '(0*([0-9]|[1-5][0-9])|\*)(-0*([0-9]|[1-5][0-9]))?(\/\d+)?\s' .
                                 '((0*([0-9]|1[0-9]|2[0-3])|\*)(-0*([0-9]|1[0-9]|2[0-3]))?(\/\d+)?,)*' .
                                 '(0*([0-9]|1[0-9]|2[0-3])|\*)(-0*([0-9]|1[0-9]|2[0-3]))?(\/\d+)?\s' .
                                 '((0*([1-9]|[12][0-9]3[01])|\*)(-0*([1-9]|[12][0-9]3[01]))?(\/\d+)?,)*' .
                                 '(0*([1-9]|[12][0-9]3[01])|\*)(-0*([1-9]|[12][0-9]3[01]))?(\/\d+)?\s' .
                                 '((0*([1-9]|1[0-2])|\*)(-0*([1-9]|1[0-2]))?(\/\d+)?,)*' .
                                 '(0*([1-9]|1[0-2])|\*)(-0*([1-9]|1[0-2]))?(\/\d+)?\s' .
                                 '((0*[0-7]|\*)(-0*[0-7])?(\/\d+)?,)*' . '(0*[0-7]|\*)(-0*[0-7])?(\/\d+)?$' . '/',
                            'message' => _('The input does not match against the crontab pattern')
                        ]
                    ]
                ]
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_SOURCE;
    }

}

<?php
namespace DbSystel\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as ZendFormElementErrors;
use Zend\Form\ElementInterface;

class FormElementErrors extends ZendFormElementErrors
{

    protected $messageCloseString = '</span></div>';

    protected $messageOpenFormat = '<div class="error-message-container"%s><span>';

    protected $messageSeparatorString = '</span><span>';

}
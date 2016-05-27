<?php
namespace DbSystel\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as ZendFormElementErrors;
use Zend\Form\ElementInterface;

class FormElementErrors extends ZendFormElementErrors
{

    protected $messageCloseString     = '</li></ul>';
    protected $messageOpenFormat      = '<ul%s><li class="alert alert-danger">';
    protected $messageSeparatorString = '</li><li class="alert alert-danger">';

    public function render(ElementInterface $element, array $attributes = [])
    {
        $messages = $element->getMessages();
        if (empty($messages)) {
            return '';
        }
        if (!is_array($messages) && !$messages instanceof Traversable) {
            throw new Exception\DomainException(sprintf(
                '%s expects that $element->getMessages() will return an array or Traversable; received "%s"',
                __METHOD__,
                (is_object($messages) ? get_class($messages) : gettype($messages))
                ));
        }
    
        // Prepare attributes for opening tag
        $attributes = array_merge($this->attributes, $attributes);
        $attributes = $this->createAttributesString($attributes);
        if (!empty($attributes)) {
            $attributes = ' ' . $attributes;
        }
    
        // Flatten message array
        $escapeHtml      = $this->getEscapeHtmlHelper();
        $messagesToPrint = [];
    
        $this->prepareMessagesToPrint($messages, $messagesToPrint, $element, $escapeHtml);
    
        if (empty($messagesToPrint)) {
            return '';
        }

        // Generate markup
        $markup  = sprintf($this->getMessageOpenFormat(), $attributes);
        $markup .= implode($this->getMessageSeparatorString(), $messagesToPrint);
        $markup .= $this->getMessageCloseString();

        return $markup;
    }
    
    protected function prepareMessagesToPrint($messages, &$messagesToPrint, $element, $escapeHtml) {
        foreach ($messages as $nameOrType => $elementOrError) {
            if (is_string($elementOrError)) {
                $elementLabel = $element->getLabel()
                    ? '<b>' . $this->view->translate($element->getLabel()) . '</b>' . ': '
                    : null
                ;
                $message = $escapeHtml($elementOrError);
                $messagesToPrint[] = $elementLabel ? $elementLabel . $message : $message;
    
            } elseif (is_array($elementOrError)) {
                $newElement = $element->get($nameOrType);
                $this->prepareMessagesToPrint(
                    $elementOrError, $messagesToPrint, $newElement, $escapeHtml
                );
            }
        }
    }

}
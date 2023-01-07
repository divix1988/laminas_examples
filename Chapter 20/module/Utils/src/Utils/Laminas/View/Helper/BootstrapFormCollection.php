<?php

namespace Utils\Laminas\View\Helper;

use Laminas\Form\ElementInterface;
use Laminas\Form\Element\Collection as CollectionElement;
use Laminas\Form\FieldsetInterface;
use Laminas\Form\LabelAwareInterface;

class BootstrapFormCollection extends \Laminas\Form\View\Helper\FormCollection
{
    protected $defaultElementHelper = 'bootstrapFormRow';

    public function __invoke(ElementInterface $element = null, $labelPosition = null, $wrap = false)
    {
        if (!$element) {
            return $this;
        }
        $this->setShouldWrap($wrap);
        
        return $this->render($element, $labelPosition);
    }

    public function render(ElementInterface $element, ?string $labelPosition = null): string
    {
	$renderer = $this->getView();

	if (!method_exists($renderer, 'plugin')) {
            //Hold off rendering, if the plugin method does not exists
            return '';
	}
	$markup = '';
	$templateMarkup = '';
	//$this->setDefaultElementHelper('bootstrapFormRow');
	$elementHelper = $this->getElementHelper();
	$fieldsetHelper = $this->getFieldsetHelper();

	if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
	}
	$this->shouldWrap = false;
	
	foreach ($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $fieldsetHelper($elementOrFieldset, $this->shouldWrap());
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $elementHelper($elementOrFieldset, $labelPosition);
            }
        }
        
        // each collection of elements is palced according to the specified style
	if ($this->shouldWrap) {
            $attributes = $element->getAttributes();
            unset($attributes['name']);
            $attributesString = count($attributes) ? ' ' . $this->createAttributesString($attributes) : '';
            $label = $element->getLabel();
            $legend = '';

            if (!empty($label)) {
                if (null !== ($translator = $this->getTranslator())) {
                    $label = $translator->translate(
                        $label,
                        $this->getTranslatorTextDomain()
                    );
                }

                if (! $element instanceof LabelAwareInterface || !$element->getLabelOption('disable_html_escape')) {
                    $escapeHtmlHelper = $this->getEscapeHtmlHelper();
                    $label = $escapeHtmlHelper($label);
                }
                $legend = sprintf(
                    $this->labelWrapper,
                    $label
                );
            }

            $markup = sprintf(
                $this->wrapper,
                $markup,
                $legend,
                $templateMarkup,
                $attributesString
            );
	} else {
            $markup .= $templateMarkup;
	}
        
	return $markup;
    }
}

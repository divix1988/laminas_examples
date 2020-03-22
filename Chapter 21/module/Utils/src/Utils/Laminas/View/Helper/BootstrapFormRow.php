<?php

namespace Utils\Laminas\View\Helper;

use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Radio;
use Laminas\Form\Element\MonthSelect;
use Laminas\Form\Element\Captcha;
use Laminas\Form\Element\Button;
use Laminas\Form\ElementInterface;
use Laminas\Form\LabelAwareInterface;

class BootstrapFormRow extends \Laminas\Form\View\Helper\FormRow
{
    public function render(ElementInterface $element, $labelPosition = null)
    {
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $labelHelper = $this->getLabelHelper();
        $elementHelper = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();
        $label = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();
        $extraClass = '';
        $extraMainLabelClassLabel = '';
        $extraMultiClassInput = '';
        $nestedDivClass = '';

        if (is_null($labelPosition)) {
            $labelPosition = $this->labelPosition;
        }
        if (isset($label) && '' !== $label) {
            // label translation
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }

        $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');

        // does that element contains errors?
        if (count($element->getMessages()) > 0 && !empty($inputErrorClass)) {
            $extraClass .= $inputErrorClass;
        }

        if ($this->partial) {
            $vars = [
                'element' => $element,
                'label' => $label,
                'labelAttributes' => $this->labelAttributes,
                'labelPosition' => $labelPosition,
                'renderErrors' => $this->renderErrors,
            ];
            return $this->view->render($this->partial, $vars);
        }

        if ($this->renderErrors) {
            $elementErrorsHelper->setMessageOpenFormat('<div %s>');
            $elementErrorsHelper->setMessageSeparatorString('<br />');
            $elementErrorsHelper->setMessageCloseString('</div>');
            $elementErrors = $elementErrorsHelper->render($element, ['class' => 'help-block']);
        }

        if ($label) {
            $element->setAttribute('placeholder', $label);
        }

        if ($element instanceof Submit) {
            $element->setAttribute('class', 'btn btn-secondary');
        } elseif ($element instanceof Checkbox || $element instanceof MultiCheckbox) {
            $classString = 'form-check-input';
            
            if ($labelPosition == BootstrapForm::MODE_INLINE) {
                $classString .= ' mr-sm-2';
                $element->setLabelAttributes(['class' => $classString]);
            }
            $element->setAttribute('class', $classString);
        } else {
            $classString = 'form-control';
            if ($labelPosition == BootstrapForm::MODE_INLINE) {
                $classString .= ' mb-2 mr-sm-2';
            }
            $element->setAttribute('class', $classString);
            
        }

        $elementString = $elementHelper->render($element, $labelPosition);
        // hidden elements does not need <label> tag
        $type = $element->getAttribute('type');

        if (isset($label) && '' !== $label && $type !== 'hidden') {
            $labelAttributes = ['class' => 'control-label'];
            
            if ($element instanceof LabelAwareInterface) {
                if ($labelPosition == BootstrapForm::MODE_HORIZONTAL) {
                    $labelAttributes['class'] .= ' col-sm-2 col-form-label';
                    $extraMainLabelClassLabel = 'col-sm-2 col-form-label';
                    $extraMultiClassInput = 'col-sm-10';
                    $extraClass .= ' row';
                    $nestedDivClass .= ' form-check';
                } else if ($labelPosition == BootstrapForm::MODE_INLINE) {
                    $labelAttributes['class'] .= ' sr-only';
                    $extraMainLabelClassLabel .= ' mr-sm-2 mb-2';
                }
                array_merge($labelAttributes, $element->getLabelAttributes());
            }
            $markup = '<div class="form-group '.$extraClass.'">';

            if (! $element instanceof LabelAwareInterface || ! $element->getLabelOption('disable_html_escape')) {
                $label = $escapeHtmlHelper($label);
            }

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }

            // Elements Multicheckbox must be handled separatly,
            // as HTML standard does not allow for the nested labels.
            // An approriate replacement here is a fieldset tag
            if ($type === 'multi_checkbox'
                || $type === 'radio'
                || $element instanceof MonthSelect
                || $element instanceof Captcha
            ) {
                $classMapping = [
                    'radio' => 'form-check mb-2',
                    'multi_checkbox' => 'form-check mb-2'
                ];

                $markup .= sprintf(
                    '<label class="control-label %s">%s</label><div class="%s"><div class="%s %s">%s</div></div>',
                    $extraMainLabelClassLabel,
                    $label,
                    $nestedDivClass,
                    $classMapping[$type],
                    $extraMultiClassInput,
                    $elementString
                );
                
            } else {
                // If the element has id attribute, it will display a separate label and element
                if (
                    $element->hasAttribute('id') &&
                    ($element instanceof LabelAwareInterface && !$element->getLabelOption('always_wrap'))
                ) {
                    $labelOpen = '';
                    $labelClose = '';
                    $label = $labelHelper->openTag($element) . $label . $labelHelper->closeTag();
                } else {
                    $labelOpen = $labelHelper->openTag($labelAttributes);
                    $labelClose = $labelHelper->closeTag();
                }

                if (
                    $label !== '' && (!$element->hasAttribute('id')) ||
                    ($element instanceof LabelAwareInterface && $element->getLabelOption('always_wrap'))
                ) {
                    $label = '<span>' . $label . '</span>';
                }

                //Button Element is a special case, where label is always displayed inside
                if ($element instanceof Button) {
                    $labelOpen = $labelClose = $label = '';
                }
                if ($element instanceof LabelAwareInterface && $element->getLabelOption('label_position')) {
                    $labelPosition = $element->getLabelOption('label_position');
                }

                switch ($labelPosition) {
                    case self::LABEL_PREPEND:
                        $markup .= $labelOpen . $label . $labelClose . $elementString;
                        break;
                    case BootstrapForm::MODE_HORIZONTAL:
                        $markup .= $labelOpen . $label . $labelClose . '<div class="col-sm-10">'. $elementString .'</div>';
                        break;
                    case self::LABEL_APPEND:
                    default:
                        $markup .= $labelOpen . $label . $labelClose . $elementString;
                        break;
                }
            }

            if ($this->renderErrors) {
                $markup .= $elementErrors;
            }

            $markup .= '</div>';
	} else {
            if ($labelPosition === BootstrapForm::MODE_HORIZONTAL && $element instanceof Submit) {
                $elementString = '<div class="form-group"><div class="col-sm-10 col-sm-offset-2">'.$elementString.'</div></div>';
            }
            if ($this->renderErrors) {
                $markup = $elementString . $elementErrors;
            } else {	
                $markup = $elementString;
            }
	}
	return $markup;
    }

    public function getInputErrorClass() {
        return 'has-error';
    }
}

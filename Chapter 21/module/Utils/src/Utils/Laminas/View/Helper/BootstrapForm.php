<?php

namespace Utils\Laminas\View\Helper;

use Laminas\Form\FormInterface;
use Laminas\Form\FieldsetInterface;

class BootstrapForm extends \Laminas\View\Helper\AbstractHelper
{
    const MODE_INLINE = 'inline';
    const MODE_HORIZONTAL = 'horizontal';
    const MODE_VERTICAL = 'vertical';
    protected $formHelper;

    public function __invoke(FormInterface $form = null, $mode = self::MODE_VERTICAL)
    {
        //$this->formHelper = $this->getView()->plugin('form');
        $this->formHelper = $this->getView()->form();

        if (!$form) {
            return $this;
        }
        return $this->render($form, $mode);
    }

    public function render(FormInterface $form, ?string $mode = self::MODE_VERTICAL): string
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }
        $formContent = '';
        $existingClasses = $form->getAttribute('class') ?? '';
        
        if (!empty($existingClasses)) {
            //let’s make sure that we don’t have bootstrap form classes
            $existingClasses = str_replace('form-horizontal', '', str_replace('form-inline', '', $existingClasses));
        }

        if ($mode == self::MODE_INLINE) {
            $form->setAttribute('class', $existingClasses.' form-inline');
        } elseif ($mode == self::MODE_HORIZONTAL) {
            $form->setAttribute('class', $existingClasses.' form-horizontal');
        }

        foreach ($form as $element) {
            if ($element instanceof FieldsetInterface) {
                $formContent.= $this->getView()->bootstrapFormCollection($element, $mode);
            } else {
                $formContent.= $this->getView()->bootstrapFormRow($element, $mode);
            }
        }
        return $this->formHelper->openTag($form) . $formContent . $this->formHelper->closeTag();
    }
}

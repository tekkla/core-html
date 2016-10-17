<?php
namespace Core\Html\Form;

use Core\Html\AbstractHtml;

/**
 * AbstractForm.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class AbstractForm extends AbstractHtml
{

    /**
     * Description for the help block
     *
     * @var string
     */
    private $description = '';

    /**
     * Flag for binding element to a model field or not
     *
     * @var bool
     */
    private $bound = true;

    /**
     * Width for the element
     *
     * @var string
     */
    private $element_width = '';

    /**
     * Value for creation an hidden field for the original value
     * Good for comparing before and then values
     *
     * @var bool
     */
    private $compare_value;

    /**
     * Signals that we want a label or not
     *
     * @var bool
     */
    private $use_label = true;

    /**
     *
     * @var bool
     */
    private $is_array = false;

    /**
     * Size of control
     *
     * @var string
     */
    private $control_size;

    /**
     * Public html object of a form label
     *
     * @var Label
     */
    public $label;

    /**
     * Flags this element to use no label
     *
     * @return AbstractForm
     */
    public function noLabel(): AbstractForm
    {
        unset($this->label);
        $this->use_label = false;

        return $this;
    }

    /**
     * Creates a Label html object and injects it into public property $label of this element
     *
     * @param string $label_text
     *            The text to show as label
     *
     * @return Label
     */
    public function setLabel($label_text)
    {
        $this->label = $this->factory->create('Form\Label');
        $this->label->setInner($label_text);

        return $this->label;
    }

    /**
     * Returns the inner value of label or false if label is not set.
     *
     * @return Ambigous <boolean, strin
     */
    public function getLabel()
    {
        if (isset($this->label)) {
            return $this->label->getInner();
        }
    }

    /**
     * Returns the state of label using.
     *
     * @return bool
     */
    public function hasLabel(): bool
    {
        return isset($this->label);
    }

    /**
     * Add autofocus attribute
     *
     * @return AbstractForm
     */
    public function setAutofocus(): AbstractForm
    {
        $this->addAttribute('autofocus');

        return $this;
    }

    /**
     * Declare this element as unbound, so the FormDesigner does not need to
     * try to fill it with data from the Model.
     *
     * @return AbstractForm
     */
    public function setUnbound(): AbstractForm
    {
        $this->bound = false;

        return $this;
    }

    /**
     * Returns the current bound state
     *
     * @return bool
     */
    public function isBound(): bool
    {
        return $this->bound;
    }

    /**
     * Returns the type attribute but only if a setType() method exists in the childclass and the type attribute isset.
     * This method is used to determine the type of input form elements.
     *
     * @return string|null
     */
    public function getType()
    {
        return method_exists($this, 'setType') ? $this->getAttribute('type') : null;
    }

    /**
     * Set a description which will be used as a help block
     *
     * @param sting $text
     *
     * @return AbstractForm
     */
    public function setDescription(string $text): AbstractForm
    {
        $this->description = $text;

        return $this;
    }

    /**
     * Returns set state of description
     *
     * @return bool
     */
    public function hasDescription(): bool
    {
        return ! empty($this->description);
    }

    /**
     * Returns the set description string
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Handles the creation state of an hidden element for comparision.
     * If $compare parameter not set, the method returns the current state.
     *
     * @param boolean $state
     *
     * @return bool
     */
    public function hasCompare(): bool
    {
        return isset($this->compare_value);
    }

    /**
     * Sets compare field value
     *
     * @param mixed $compare_value
     *
     * @return AbstractForm
     */
    public function setCompare($compare_value): AbstractForm
    {
        $this->compare_value = $compare_value;

        return $this;
    }

    /**
     * Returns compare field value
     *
     * @return mixed
     */
    public function getCompare()
    {
        return $this->compare_value;
    }

    /**
     * Assign an bootstrap element width
     *
     * @param string $element_width
     *            BS grid sizes like "sm-3" or "lg-5". Needed "col-" will be added by the method.
     *
     * @throws FormException
     *
     * @return AbstractForm
     */
    public function setElementWidth(string $element_width = 'sm-3'): AbstractForm
    {
        $sizes = [
            'xs',
            'sm',
            'md',
            'lg'
        ];
        $allowed_widths = [];

        foreach ($sizes as $size) {
            for ($i = 1; $i < 13; $i ++) {
                $allowed_widths[] = $size . '-' . $i;
            }
        }

        if (! in_array($element_width, $allowed_widths)) {
            Throw new FormException(sprintf('Element width "%s" is not valid. Select from: %s', $element_width, implode(', ', $sizes)));
        }

        $this->element_width = 'col-' . $element_width;

        return $this;
    }

    /**
     * Returns a set element width or boolean false if not set.
     *
     * @return string|boolean
     */
    public function getElementWidth()
    {
        return $this->element_width;
    }

    /**
     * Checks for a set element width
     */
    public function hasElementWidth()
    {
        return ! empty($this->element_width);
    }

    /**
     * Sets an input mask for the elements
     *
     * @param string $mask
     *
     * @return AbstractForm
     */
    public function setMask(string $mask):AbstractForm
    {
        $this->addData('form-mask', $mask);

        return $this;
    }

    /**
     * Disabled attribute setter and checker
     *
     * Accepts parameter "null", "0" and "1".
     * "null" means to check for a set disabled attribute
     * "0" means to remove disabled attribute
     * "1" means to set disabled attribute
     *
     * @param int $state
     *
     * @return AbstractForm
     */
    public function isDisabled($state = null):AbstractForm
    {
        $attrib = 'disabled';

        if (! isset($state)) {
            return $this->checkAttribute($attrib);
        }

        if ($state == 0) {
            $this->removeAttribute($attrib);
        }
        else {
            $this->addAttribute($attrib);
        }

        return $this;
    }

    /**
     *
     * @param mixed $state
     *
     * @return AbstractForm
     */
    public function isArray($state = null):AbstractForm
    {
        if (empty($state)) {
            return $this->is_array;
        }

        $this->is_array = (bool) $state;

        return $this;
    }

    /**
     * Sets the visual size of control
     *
     * @param string $size
     *
     * @throws FormException
     */
    public function setControlSize(string $size)
    {
        $allowed_sizes = [
            'lg',
            'md',
            'sm',
            'xs'
        ];

        if (!in_array($size, $allowed_sizes)) {
            Throw new FormException(sprintf('Size "%s" is no valid controlsize. Allowed sizes are %s.', $size, implode(', ', $allowed_sizes)));
        }

        $this->control_size = $size;
    }

    /**
     * Returns the visual size of control
     * @return string
     */
    public function getControlSize(): string {
        return $this->control_size ?? '';
    }
}

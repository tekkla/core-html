<?php
namespace Core\Html\Form;

use Core\Html\AbstractHtml;
use Core\Html\HtmlException;

/**
 * AbstractForm.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2021
 * @license MIT
 * 
 * @todo Move the bootstrap and datepicker dependencies into a seperate control!
 */
class AbstractForm extends AbstractHtml
{

    /**
     * Description for the help block
     *
     * @var string
     */
    private string $description;

    /**
     * Flag for binding element to a model field or not
     *
     * @var bool
     */
    private bool $bound = true;

    /**
     * Width for the element
     *
     * @var string
     */
    private string $element_width;

    /**
     * Value for creation an hidden field for the original value
     * Good for comparing before and then values
     *
     * @var bool
     */
    private bool $compare_value;

    /**
     * Signals that we want a label or not
     *
     * @var bool
     */
    // private $use_label = true;

    /**
     * Size of control
     *
     * @var string
     */
    private string $control_size;

    /**
     * Public html object of a form label
     *
     * @var Label
     */
    public Label $label;

    /**
     * Flags this element to use no label
     */
    public function noLabel()
    {
        unset($this->label);
    }

    /**
     * Creates a Label html object and injects it into public property $label of this element
     *
     * @param string $label_text
     *            The text to show as label
     * @throws HtmlException
     */
    public function setLabel(string $label_text)
    {
        $this->label = $this->factory->create('Form\Label');
        $this->label->setInner($label_text);
    }

    /**
     * Returns the inner value of label or false if label is not set.
     *
     * @return string
     */
    public function getLabel(): string
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
     * Adds autofocus attribute
     */
    public function setAutofocus()
    {
        $this->addAttribute('autofocus');
    }

    /**
     * Declare this element as unbound, so the FormDesigner does not need to try to fill it with data from the Model.
     */
    public function setUnbound()
    {
        $this->bound = false;
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
     * Returns the type attribute but only if a setType() method exists in the child class and the type attribute isset.
     * This method is used to determine the type of input form elements.
     *
     * @return string|null
     * @throws HtmlException
     */
    public function getType(): ?string
    {
        return method_exists($this, 'setType') ? $this->getAttribute('type') : null;
    }

    /**
     * Set a description which will be used as a help block
     *
     * @param string $text
     */
    public function setDescription(string $text)
    {
        $this->description = $text;
    }

    /**
     * Returns set state of description
     *
     * @return bool
     */
    public function hasDescription(): bool
    {
        return isset($this->description);
    }

    /**
     * Returns the set description string
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    /**
     * Handles the creation state of a hidden element for comparison
     *
     * If $compare parameter not set, the method returns the current state.
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
     */
    public function setCompare($compare_value)
    {
        $this->compare_value = $compare_value;
    }

    /**
     * Returns compare field value and throws FormException if no value is set
     *
     * @throws FormException
     *
     * @return mixed
     */
    public function getCompare(): mixed
    {
        if (!isset($this->compare_value)) {
            Throw new FormException('No compare value set.');
        }

        return $this->compare_value;
    }

    /**
     * Assign a bootstrap element width
     *
     * @param string $element_width
     *            BS grid sizes like "sm-3" or "lg-5". Needed "col-" will be added by the method.
     *
     * @throws FormException
     */
    public function setElementWidth(string $element_width = 'sm-3')
    {
        $sizes = [
            'xs',
            'sm',
            'md',
            'lg'
        ];

        $allowed_widths = [];

        foreach ($sizes as $size) {
            for ($i = 1; $i < 13; $i++) {
                $allowed_widths[] = $size . '-' . $i;
            }
        }

        if (!in_array($element_width, $allowed_widths)) {
            Throw new FormException(sprintf('Element width "%s" is not valid. Select from: %s', $element_width, implode(', ', $sizes)));
        }

        $this->element_width = 'col-' . $element_width;
    }

    /**
     * Returns a set element width or empty string if not set
     *
     * @return string
     */
    public function getElementWidth(): string
    {
        return $this->element_width ?? '';
    }

    /**
     * Checks for a set element width
     */
    public function hasElementWidth(): bool
    {
        return isset($this->element_width);
    }

    /**
     * Sets an input mask for the elements
     *
     * @param string $mask
     */
    public function setMask(string $mask)
    {
        $this->addData('form-mask', $mask);
    }

    /**
     * Checks if form control is disabled
     *
     * @return boolean
     */
    public function isDisabled(): bool
    {
        return $this->checkAttribute('disabled');
    }

    /**
     * Sets form control to be disabled by setting 'disabled' attribute
     */
    public function setDisabled()
    {
        $this->addAttribute('disabled');
    }

    /**
     * Sets form control to be enabled by removing 'disabled' attribute
     */
    public function setEnabled()
    {
        $this->removeAttribute('disabled');
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
     *
     * @return string
     */
    public function getControlSize(): string
    {
        return $this->control_size ?? '';
    }
}

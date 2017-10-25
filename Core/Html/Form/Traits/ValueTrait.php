<?php
namespace Core\Html\Form\Traits;

use Core\Html\Form\Select;
use Core\Html\Form\Textarea;

/**
 * ValueTrait.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015-2017
 * @license MIT
 */
trait ValueTrait
{

    /**
     * Sets value attribute for Select, Input an Textarea.
     *
     * @param string|array $value
     */
    public function setValue($value)
    {
        switch (true) {
            case ($this instanceof Select):
                if (! is_array($value)) {
                    $value = (array) $value;
                }
                
                $this->value = $value;
                break;
            case ($this instanceof Textarea):
                $this->inner = $value;
                break;
            default:
                $this->attribute['value'] = $value;
                break;
        }
        
        return $this;
    }

    /**
     * Returns the current value of Select, Input or Textarea
     *
     * On Selects the value is an array of values .
     * On Inputs the value is the content of the value attribute.
     * On Textareas the value is the content of inner html.
     *
     * @return array|string|boolean
     */
    public function getValue()
    {
        switch (true) {
            case ($this instanceof Select):
                return $this->value;
            case ($this instanceof Textarea):
                return $this->inner;
            case (isset($this->attribute['value'])):
                return $this->attribute['value'];
            default:
                return false;
        }
    }

    /**
     * Unset the value
     */
    public function unsetValue()
    {
        switch (true) {
            case ($this instanceof Select):
                $this->value = [];
                break;
            case ($this instanceof Textarea):
                $this->inner = '';
                break;
            default:
                $this->removeAttribute('value');
                break;
        }
    }
}

<?php
namespace Core\Html\Form\Traits;

use Core\Html\Form\AbstractForm;

/**
 * IsMultipleTrait.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015-2017
 * @license MIT
 */
trait IsMultipleTrait
{

    /**
     * Sets the multiple attribute.
     *
     * @return AbstractForm
     */
    public function isMultiple(): AbstractForm
    {
        $this->attribute['multiple'] = false;
        
        return $this;
    }

    /**
     * Removes possible set multiple attribute.
     *
     * @return AbstractForm
     */
    public function notMultiple(): AbstractForm
    {
        $this->removeAttribute('multiple');
        
        return $this;
    }

    /**
     * Returns current multiple atribute state.
     *
     * @return bool
     */
    public function getMultiple(): bool
    {
        return $this->checkAttribute('multiple');
    }
}

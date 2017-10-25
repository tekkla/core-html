<?php
namespace Core\Html\Form\Traits;

use Core\Html\Form\AbstractForm;

/**
 * IsCheckedTrait.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015-2017
 * @license MIT
 */
trait IsCheckedTrait
{

    /**
     * Sets checked attribute.
     *
     * @return AbstractForm
     */
    public function isChecked(): AbstractForm
    {
        $this->attribute['checked'] = false;
        
        return $this;
    }

    /**
     * Removes a possible set checked attribute.
     *
     * @return AbstractForm
     */
    public function notChecked(): AbstractForm
    {
        $this->removeAttribute('checked');
        
        return $this;
    }

    /**
     * Returns current checked attribute state
     *
     * @return bool
     */
    public function getChecked(): bool
    {
        return $this->checkAttribute('checked');
    }
}


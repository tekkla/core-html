<?php
namespace Core\Html\Form\Traits;

use Core\Html\Form\Input;

/**
 * PlaceholderTrait.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015-2017
 * @license MIT
 */
trait PlaceholderTrait
{

    /**
     * Sets cointent a placholder text
     *
     * @param string $placeholder
     *            The placeholder text
     *            
     * @return Input
     */
    public function setPlaceholder(string $placeholder): Input
    {
        $this->attribute['placeholder'] = $placeholder;
        
        return $this;
    }

    /**
     * Returns the current placeholder string
     *
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->attribute['placeholder'] ?? '';
    }
}

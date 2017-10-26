<?php
namespace Core\Html\Form\Traits;

use Core\Html\Form\Interfaces\PlaceholderInterface;

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
     * Sets cointent a placeholder text
     *
     * @param string $placeholder
     *            The placeholder text
     *            
     * @return PlaceholderInterface
     */
    public function setPlaceholder(string $placeholder): PlaceholderInterface
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

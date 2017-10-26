<?php
namespace Core\Html\Form\Traits;

use Core\Html\HtmlException;
use Core\Html\Form\Input;

/**
 * MaxlengthTrait.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
trait MaxlengthTrait
{

    /**
     * Sets maxlength attribute
     *
     * @param int $maxlength
     *
     * @throws HtmlException
     *
     * @return \Core\Html\Form\Input
     */
    public function setMaxlength(int $maxlength): Input
    {
        if (!$maxlength) {
            Throw new HtmlException('A html form textareas maxlength attribute needs to be of type integer.');
        }
        
        $this->attribute['maxlength'] = $maxlength;
        
        return $this;
    }

    /**
     * Returns maxlength attribute value
     *
     * @return int
     */
    public function getMaxlength(): int
    {
        return (int) $this->attribute['maxlength'];
    }
}

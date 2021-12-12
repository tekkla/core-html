<?php
namespace Core\Html\Form;

/**
 * Label Form Element
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @package TekFW
 * @subpackage Html\Form
 * @license MIT
 * @copyright 2014-2021
 */
class Label extends AbstractForm
{

    protected string $element = 'label';

    /**
     * Sets id of control the label belongs to
     *
     * @param string $for
     *            Id of the control the label belongs to
     *
     * @return Label
     */
    public function setFor(string $for): Label
    {
        $this->removeAttribute('for');
        $this->addAttribute('for', $for);

        return $this;
    }
}


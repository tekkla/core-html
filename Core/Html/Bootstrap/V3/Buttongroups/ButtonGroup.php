<?php
namespace Core\Html\Bootstrap\V3\Buttongroups;

use Core\Html\Elements\Div;
use Core\Html\Bootstrap\V3\Button\Button;
use Core\Html\AbstractHtml;

/**
 * ButtonGroup.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class ButtonGroup extends Div
{

    /**
     *
     * @var array
     */
    private $buttons = [];

    protected $css = [
        'btn-group'
    ];

    protected $attributes = [
        'role' => 'group'
    ];

    /**
     * Creates a Bootstrap button element and adds it to the buttonlist
     *
     * @return Button
     */
    public function &createButton($button_class='Bootstrap\Button\Button')
    {
        $button = $this->factory->create($button_class);

        $this->addButton($button);

        return $button;
    }

    /**
     * Add a button element to the button list.
     *
     * @param AbstractHtml $button
     *            Bootstrap button to a to group
     */
    public function addButton(AbstractHtml $button)
    {
        $uniqeid = uniqid('btngrp_btn');

        $this->buttons[$uniqeid] = $button;
    }


    public function build()
    {
        foreach ($this->buttons as $button) {
            $this->inner .= $button->build();
        }

        return parent::build();
    }
}

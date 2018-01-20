<?php
namespace Core\Html\Bootstrap\V3\Buttongroups;

use Core\Html\Elements\Div;

/**
 * ButtonToolbar.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */

class ButtonToolbar extends Div
{

    private $groups = [];

    protected $css = [
        'btn-toolbar'
    ];

    protected $attributes = [
        'role' => 'toolbar'
    ];

    /**
     * Creates a ButtonGroup object, adds it to the groups list and returns a reference to it
     *
     * @return ButtonGroup
     */
    public function &createButtongroup(): ButtonGroup
    {
        return $this->addButtongroup($this->factory->create('Bootstrap\V3\Buttongroups\ButtonGroup'));
    }

    /**
     * Adds a ButtonGroup object to the groups list and returns reference to it.
     *
     * @param ButtonGroup $buttongroup
     *
     * @return ButtonGroup
     */
    public function &addButtongroup(ButtonGroup $buttongroup): ButtonGroup
    {
        $uniqeid = uniqid('btntoolbar_btngrp_');
        $this->groups[$uniqeid] = $buttongroup;
        
        return $this->groups[$uniqeid];
    }

    public function build()
    {
        foreach ($this->groups as $group) {
            $this->inner .= $group->build();
        }
        
        return parent::build();
    }
}

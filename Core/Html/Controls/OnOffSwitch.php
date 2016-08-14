<?php
namespace Core\Html\Controls;

use Core\Html\Form\Select;
use Core\Html\HtmlBuildableInterface;
use Core\Html\Form\AbstractForm;

/**
 * OnOffSwitch.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class OnOffSwitch extends AbstractForm implements HtmlBuildableInterface
{

    /**
     *
     * @var Select
     */
    public $html;

    /**
     *
     * @var array
     */
    private $strings = [
        'on' => 'on',
        'off' => 'off'
    ];

    // array with option objects
    private $switch = [];

    /**
     *
     * @var int
     */
    private $state = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->html = new Select();
    }

    /**
     * Sets the string for the on state switch
     *
     * @param string $on
     */
    public function setOnString(string $on)
    {
        $this->strings['on'] = $on;
    }

    /**
     * Sets the string for the off state switch
     *
     * @param string $off
     */
    public function setOffString(string $off)
    {
        $this->strings['off'] = $off;
    }

    private function createSwitches()
    {
        if (!empty($this->switch)) {
            return;
        }

        // Add off option
        $option = $this->factory->create('Form\Option');

        $option->setValue(0);
        $option->setInner($this->strings['off']);

        $this->switch['off'] = $option;

        // Add on option
        $option = $this->factory->create('Form\Option');

        $option->setValue(1);
        $option->setInner($this->strings['on']);

        $this->switch['on'] = $option;
    }

    /**
     * Switches state to: on
     */
    public function switchOn()
    {
        $this->state = 1;
    }

    /**
     * Switches state to: off
     */
    public function switchOff()
    {
        $this->state = 0;
    }

    /**
     * Set switch to a specific state
     *
     * @param number $state
     *
     * @throws InvalidArgumentException
     *
     * @return OnOffSwitch
     */
    public function switchTo($state)
    {
        $states = [
            0,
            1,
            false,
            true,
            'on',
            'off',
            'yes',
            'no'
        ];

        if (!in_array($state, $states)) {
            Throw new ControlException('Wrong state for on/off switch.');
        }

        switch ($state) {
            case 0:
            case false:
            case 'off':
            case 'no':
                $this->switchOff();
                break;
            case 1:
            case true:
            case 'on':
            case 'yes':
                $this->switchOn();
                break;
        }
    }

    /**
     * Returns current switch state
     */
    public function getState()
    {
        return $this->html->getValue();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Core\Html\Form\Select::build()
     */
    public function build()
    {
        $this->createSwitches();

        /* @var $option \Core\Html\Form\Option */
        foreach ($this->switch as $option) {

            $value = $option->getValue();

            if (!$value) {
                $value = $option->getInner();
            }

            if ($this->state == $value) {
                $option->isSelected();
            }

            $this->html->addOption($option);
        }

        return $this->html->build();
    }

    /**
     * Send all html object related method calls directly to the internal html object
     *
     * @param string $method
     * @param unknown $arguments
     */
    public function __call($method, $arguments)
    {
        return $this->html->{$method}($arguments);
    }
}

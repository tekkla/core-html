<?php
namespace Core\Html\Bootstrap\V3\Button;

use Core\Html\Form\Button as FormButton;
use Core\Html\HtmlBuildableInterface;

/**
 * Button.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Button extends FormButton
{

    /**
     * Name of icon to use
     *
     * @var string
     */
    protected $icon;

    /**
     * Type
     *
     * @var string
     */
    protected $option = 'default';

    /**
     * Size
     *
     * @var string
     */
    protected $size;

    /**
     * Element type
     *
     * @var $string
     */
    protected $element = 'button';

    /**
     * Basic css classes
     *
     * @var array
     */
    protected $css = [
        'btn'
    ];

    /**
     * Sets a buildable icon
     *
     * @param HtmlBuildableInterface $icon
     *
     * @return Button
     */
    public function useIcon(HtmlBuildableInterface $icon): Button
    {
        $this->icon = $icon;
        
        return $this;
    }

    /**
     * Sets button option to: default
     *
     * @return Button
     */
    public function isDefault(): Button
    {
        $this->option = 'default';
        
        return $this;
    }

    /**
     * Sets button option to: primary
     *
     * @return Button
     */
    public function isPrimary(): Button
    {
        $this->option = 'primary';
        
        return $this;
    }

    /**
     * Sets button option to: danger
     *
     * @return Button
     */
    public function isDanger(): Button
    {
        $this->option = 'danger';
        
        return $this;
    }

    /**
     * Sets button option to: info
     *
     * @return Button
     */
    public function isInfo(): Button
    {
        $this->option = 'info';
        
        return $this;
    }

    /**
     * Sets button option to: warning
     *
     * @return Button
     */
    public function isWarning(): Button
    {
        $this->option = 'warning';
        
        return $this;
    }

    /**
     * Sets button option to: success
     *
     * @return Button
     */
    public function isSuccess(): Button
    {
        $this->option = 'success';
        
        return $this;
    }

    /**
     * Sets button option to: link
     *
     * @return Button
     */
    public function isLink(): Button
    {
        $this->option = 'link';
        
        return $this;
    }

    /**
     * Sets button size to: xs
     *
     * @return Button
     */
    public function sizeXs(): Button
    {
        $this->size = 'xs';
        
        return $this;
    }

    /**
     * Set button size to: sm
     *
     * @return Button
     */
    public function sizeSm(): Button
    {
        $this->size = 'sm';
        
        return $this;
    }

    /**
     * Set button size to: md
     *
     * @return Button
     */
    public function sizeMd(): Button
    {
        $this->size = 'md';
        
        return $this;
    }

    /**
     * Set button size to: lg
     *
     * @return Button
     */
    public function sizeLg(): Button
    {
        $this->size = 'lg';
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Html\Form\Button::build()
     */
    public function build()
    {
        // Has this button an icon to add?
        if (isset($this->icon)) {
            $this->inner = $this->icon->build() . ' ' . $this->inner;
        }
        
        // Add button type css
        $this->css[] = 'btn-' . $this->option;
        
        // Do we have to add cs for a specific button size?
        if (isset($this->size)) {
            $this->css[] = 'btn-' . $this->size;
        }
        
        return parent::build();
    }
}


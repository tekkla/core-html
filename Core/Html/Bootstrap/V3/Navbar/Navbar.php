<?php
namespace Core\Html\Bootstrap\V3\Navbar;

use Core\Html\Elements\Nav;
use Core\Html\HtmlException;

/**
 * Navbar.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
class Navbar extends Nav
{

    /**
     *
     * @var boolean
     */
    protected $fixed = false;

    /**
     *
     * @var bool
     */
    protected $fluid = false;

    /**
     *
     * @var bool
     */
    protected $collapsible = true;

    /**
     *
     * @var array
     */
    private $elements = [];

    protected $css = [
        'navbar',
        'navbar-default'
    ];

    /**
     *
     * @var array
     */
    private $element_types = [
        'brand',
        'link',
        'dropdown',
        'form',
        'text'
    ];

    /**
     * Sets or gets fixed to top flag
     *
     * @param string $position
     *            Optional position of navbar which also controls the fixed displaymode. (Default: 'top')
     */
    public function setFixed(string $position = 'top')
    {
        $positions = [
            'top',
            'bottom'
        ];
        
        if (! in_array($position, $positions)) {
            Throw new HtmlException(sprintf('They type "%s" is not a valid navbar elementtype. Allowed are %s.', $position, implode(', ', $positions)));
        }
        
        $this->fixed = $position;
    }

    /**
     * Sets or gets fluid container flag
     *
     * @param bool $fluid
     */
    public function isFluid(string $fluid = null): bool
    {
        if (isset($fluid)) {
            $this->fluid = $fluid;
        }
        
        return $this->fluid;
    }

    /**
     * Sets or gets collapsible flag
     *
     * @param bool $collapsible
     *
     * @return \Core\Html\Bootstrap\V3\Navbar\Navbar|boolean
     */
    public function isCollapsible(bool $collapsible = null): bool
    {
        if (isset($collapsible)) {
            $this->collapsible = $collapsible;
        }
        
        return $this->collapsible;
    }

    /**
     * Adds a navbarelement to the elements stack.
     * Requesting a no allowed elementtype will cause a HtmlException.
     *
     * @param AbstractNavbarElement $element
     *
     * @throws HtmlException
     */
    public function addNavbarElement(AbstractNavbarElement $element)
    {
        if (! in_array($element->getType(), $this->element_types)) {
            Throw new HtmlException(sprintf('They type "%s" is not a valid navbar elementtype. Allowed are %s.', $element->getType(), implode(', ', $this->element_types)));
        }
        
        $this->elements[] = $element;
    }

    /**
     * Creates a navbarelement, adds it to the elements stack and returns a reference on it.
     * Requesting a no allowed elementtype will cause a HtmlException.
     *
     * @param string $type
     *
     * @throws HtmlException
     *
     * @return AbstractNavbarElement
     */
    public function &createNavbarElement($type): AbstractNavbarElement
    {
        if (! in_array($type, $this->element_types)) {
            Throw new HtmlException(sprintf('They type "%s" is not a valid navbar elementtype. Allowed are %s.', $type, implode(', ', $this->element_types)));
        }
        
        return $this->elements[] = $this->factory->create('Bootstrap\V3\Navbar\\' . $type . 'Element');
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Html\AbstractHtml::build()
     */
    public function build()
    {
        if ($this->fixed_to_top) {
            $this->css[] = 'navbar-static-top';
        }
        
        if ($this->container) {
            $this->inner .= '<div class="container">';
        }
        
        $this->inner .= '
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".main-menu-collapse">
                <span class="sr-onlyToggle navigation"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>';
        
        if ($this->brand) {
            $this->inner .= '<a href="' . $this->home_url . '" class="navbar-brand">' . $this->brand . '</a>';
        }
        
        $this->inner .= 's
        </div>
        <nav class="collapse navbar-collapse main-menu-collapse" role="navigation">
            <ul class="nav navbar-nav">';
        
        $this->inner .= $this->buildMenuItems($this->items);
        
        $this->inner .= '
            </ul>
        </nav>';
        
        if ($this->container) {
            $this->inner .= '</div>';
        }
        
        return parent::build();
    }

    /**
     * Builds nav bar elements
     *
     * @param array $items
     *
     * @return string
     */
    private function buildMenuItems(array $items): string
    {
        $html = '';
        
        foreach ($items as $item) {
            
            if ($this->multilevel && $item->hasChilds()) {
                $html .= '
                <li class="navbar-parent">
                    <a href="' . $item->getUrl() . '">' . $item->getText() . '</a>
                    <ul>';
                
                $html .= $this->buildMenuItems($item->getChilds());
                
                $html .= '
                    </ul>
                </li>';
            } else {
                
                $url = $item->getUrl();
                
                if ($url) {
                    $html .= '<li><a href="' . $url . '">' . $item->getText() . '</a></li>';
                } else {
                    $html .= '<li><a href="#" onClick="return false">' . $item->getText() . '</a></li>';
                }
            }
        }
        
        return $html;
    }
}

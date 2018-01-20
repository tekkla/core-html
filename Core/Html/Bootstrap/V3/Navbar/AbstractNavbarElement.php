<?php
namespace Core\Html\Bootstrap\V3\Navbar;

use Core\Html\HtmlException;

/**
 * Abstract NavbarElement
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015-2017
 * @license MIT
 */
abstract class AbstractNavbarElement
{

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $side;

    /**
     *
     * @var bool
     */
    private $active = false;

    /**
     * Sets or gets active state of element
     *
     * @param bool $active
     *
     * @return AbstractNavbarElement|boolean
     */
    final public function isActive(bool $active = null)
    {
        if (isset($active)) {
            $this->active = (bool) $active;
            return $this;
        } else {
            return $this->active;
        }
    }

    /**
     * Returns type of element.
     */
    final public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets element alignment to "left" or "right".
     *
     * @param string $align
     *            Allowed alignments: 'left', 'right
     *            
     * @throws HtmlException
     *
     * @return AbstractNavbarElement
     */
    final public function setAlign($align): AbstractNavbarElement
    {
        $sides = [
            'left',
            'right'
        ];
        
        if (! in_array($align, $sides)) {
            Throw new HtmlException(sprintf('Your "%s" is not a valid navbar element position. Allowed are %s.', $align, implode(', ', $sides)));
        }
        
        $this->side = $align;
        
        return $this;
    }

    /**
     * Sets element alignment to "left".
     *
     * @return AbstractNavbarElement
     */
    final public function alignLeft(): AbstractNavbarElement
    {
        $this->side = 'left';
        
        return $this;
    }

    /**
     * Sets element alignment to "right".
     *
     * @return AbstractNavbarElement
     */
    final public function alignRight(): AbstractNavbarElement
    {
        $this->side = 'right';
        
        return $this;
    }

    /**
     * Build method
     */
    abstract function build();
}


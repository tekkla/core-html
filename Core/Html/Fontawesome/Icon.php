<?php
namespace Core\Html\Fontawesome;

use Core\Html\AbstractHtml;

/**
 * Icon.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Icon extends AbstractHtml
{

    /**
     * Icon name
     *
     * @var string
     */
    private $icon;

    /**
     * Size of icon
     *
     * @var string
     */
    private $size;

    /**
     * Icon this icon will stack on
     *
     * @var Icon
     */
    private $on;

    /**
     * Float direction
     *
     * @var string left | right
     */
    private $pull;

    /**
     * Draw a border around icon?
     *
     * @var boolean
     */
    private $border = false;

    /**
     * Set icon as muted?
     *
     * @var boolean
     */
    private $muted = false;

    /**
     * Degree to rotate the icon
     *
     * @var int
     */
    private $rotation;

    /**
     * Icon flip orientation
     *
     * @var string
     */
    private $flip;

    /**
     * Spinning flag
     *
     * @var boolean
     */
    private $spin = false;

    /**
     * Htmlelement
     *
     * @var string
     */
    protected $element = 'i';

    /**
     * Basic css classes
     *
     * @var array
     */
    protected $css = [
        'fa'
    ];

    /**
     * Iconname of icon to use
     *
     * @param string $icon
     *
     * @return Icon
     */
    public function setIcon(string $icon): Icon
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Sets the size of our icon.
     * Sizes are 'large', '2x', '3x' and '4x'. All other sizes will throw an error
     *
     * @param string $size
     *
     * @throws IconException
     *
     * @return Icon
     */
    public function setSize(string $size): Icon
    {
        // sizes which are allowed
        $sizes = [
            'lg',
            '2x',
            '3x',
            '4x'
        ];

        if (!in_array($size, $sizes)) {
            Throw new IconException('Wrong size set.');
        }

        $this->size = $size;

        return $this;
    }

    /**
     * Flags icon to have a fixed with
     *
     * @return Icon
     */
    public function useFixedWidth(): Icon
    {
        $this->css[] = 'fa-fixed-width';

        return $this;
    }

    /**
     * Activates icon border
     *
     * @return Icon
     */
    public function useBorder(): Icon
    {
        $this->border = true;

        return $this;
    }

    /**
     * Set icon as muted
     *
     * @return Icon
     */
    public function isMuted(): Icon
    {
        $this->muted = true;

        return $this;
    }

    /**
     * Floats icon left
     *
     * @return Icon
     */
    public function pullLeft(): Icon
    {
        $this->pull = 'left';

        return $this;
    }

    /**
     * Floats icon right
     *
     * @return Icon
     */
    public function pullRight(): Icon
    {
        $this->pull = 'right';

        return $this;
    }

    /**
     * Set icon rotation degree
     *
     * Select from 0, 90, 180 or 270. Value of 0 cancels rotaton.
     *
     * @param int $rotation
     *
     * @throws IconException
     *
     * @return Icon
     */
    public function setRotation(int $rotation): Icon
    {
        $rotas = [
            0,
            90,
            180,
            270
        ];

        if (!in_array($rotation, $rotas)) {
            Throw new IconException('Wrong rotation degree set.');
        }

        if ($rotation == 0) {
            unset($this->rotation);
        }
        else {
            $this->rotation = $rotation;
        }

        return $this;
    }

    /**
     * Flips icon horzontal
     *
     * @return Icon
     */
    public function flipHorizontal(): Icon
    {
        $this->flip = 'horizontal';
        unset($this->rotation);

        return $this;
    }

    /**
     * Flips icon vertically
     *
     * @return Icon
     */
    public function flipVertical(): Icon
    {
        $this->flip = 'vertical';
        unset($this->rotation);

        return $this;
    }

    /**
     * Activates icon spinning
     *
     * @return Icon
     */
    public function isSpin(): Icon
    {
        $this->spin = true;

        return $this;
    }

    /**
     * Set an icon name to stack our icon on
     *
     * Note: The parameter needs to be a fontawesome icon name without the leading "icon-"
     *
     * @param string $icon
     *
     * @return Icon
     */
    public function stackOn(string $icon): Icon
    {
        $this->on = $icon;

        return $this;
    }

    /**
     * Define icon a non stacked one
     *
     * @return Icon
     */
    public function noStack(): Icon
    {
        unset($this->on);

        return $this;
    }

    /**
     * Icon creation
     *
     * @see \Core\Html::build()
     */
    public function build()
    {
        // first step is to set the icon name itself
        $this->css[] = 'fa-' . $this->icon;

        if (isset($this->on)) {
            $stack = $this->factory->create('Elements\Span');
            $stack->addCss('fa fa-stack');
            $this->addCss('fa-stack-1x');

            // Create the on icon
            $on = $this->factory->create('Fontawesome\Icon');
            $on->useIcon($this->on);
            $on->addCss([
                'fa-stack-2x',
                'icon_bg'
            ]);
            $icon_1 = $on->build();
        }

        // size set for icon?
        if (isset($this->size)) {

            if (isset($stack)) {
                $stack->addCss('fa-' . $this->size);
            }
            else {
                $this->addCss('fa-' . $this->size);
            }
        }

        // any floating wanted?
        if (isset($this->pull)) {

            if (isset($stack)) {
                $stack->addCss('fa-pull-' . $this->pull);
            }
            else {
                $this->addCss('fa-pull-' . $this->pull);
            }
        }

        // draw border?
        if ($this->border && !isset($stack)) {
            $this->css[] = 'fa-border';
        }

        // is muted?
        if ($this->muted) {

            if (isset($stack)) {
                $stack->addCss('fa-muted');
            }
            else {
                $this->css[] = 'fa-muted';
            }
        }

        // flip icon?
        if (isset($this->flip)) {

            if (isset($stack)) {
                $stack->addCss('fa-flip-' . $this->flip);
            }
            else {
                $this->css[] = 'fa-flip-' . $this->flip;
            }
        }

        // rotate icon?
        if (isset($this->rotation)) {
            if (isset($stack)) {
                $stack->addCss('fa-rotate-' . $this->rotation);
            }
            else {
                $this->css[] = 'fa-rotate-' . $this->rotation;
            }
        }

        // spin icon?
        if ($this->spin) {
            if (isset($stack)) {
                $stack->addCss('fa-spin');
            }
            else {
                $this->css[] = 'fa-spin';
            }
        }

        $icon_2 = parent::build();

        if (isset($stack)) {
            $stack->setInner($icon_1 . PHP_EOL . $icon_2);
            $html = $stack->build();
        }
        else {
            $html = $icon_2;
        }

        return $html;
    }
}


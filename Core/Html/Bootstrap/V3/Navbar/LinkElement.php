<?php
namespace Core\Html\Bootstrap\V3\Navbar;

/**
 * Link element for Bootstrap Navbar
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015-2017
 * @license MIT
 */
class LinkElement extends AbstractNavbarElement
{

    /**
     *
     * @var string
     */
    protected $type = 'link';

    /**
     *
     * @var string
     */
    private $url;

    /**
     *
     * @var string
     */
    private $text;

    /**
     *
     * @var boolean
     */
    private $current = false;

    /**
     *
     * @var boolean
     */
    private $ajax = false;

    /**
     * Sets linkelements href url
     *
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * Set links inner text.
     *
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * Sets use currentx flag when parameter $ajax is set.
     *
     * Otherwise will returns use current flag status.
     *
     * @param boolean $current
     *
     * @return bool
     */
    public function useCurrent($current = null): bool
    {
        if (isset($current)) {
            $this->current = (bool) $current;
            return $this;
        } else {
            return $this->current;
        }
    }

    /**
     * Sets or gets ajax flag
     *
     * @param bool $ajax
     *
     * @return bool
     */
    public function isAjax(bool $ajax = null): bool
    {
        if (isset($ajax)) {
            $this->ajax = (bool) $ajax;
            return $this;
        } else {
            return $this->ajax;
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Html\Bootstrap\V3\Navbar\AbstractNavbarElement::build()
     */
    public function build()
    {
        $html = '<a href="' . $this->url . '"';
        
        if ($this->ajax) {
            $html .= ' data-ajax';
        }
        
        $html .= '>' . $this->text;
        
        if ($this->current) {
            $html .= ' <span class="sr-only">(current)</span>';
        }
        
        $html .= '</a>';
        
        return $html;
    }
}


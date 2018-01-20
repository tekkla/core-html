<?php
namespace Core\Html\Bootstrap\V3\Navbar;

use Core\Html\Elements\Img;
use Core\Html\Elements\A;

/**
 * Brand element for Bootstrap Navbar
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015-2017
 * @license MIT
 */
class BrandElement extends AbstractNavbarElement
{

    /**
     *
     * @var string
     */
    protected $type = 'brand';

    /**
     *
     * @var string
     */
    private $content = '';

    /**
     *
     * @var A
     */
    private $link = false;

    /**
     * Creates a brand imageobject and returns reference
     *
     * @param string $src
     * @param string $alt
     *            Optional
     *            
     * @return \Core\Html\Elements\Img
     */
    public function createImage(string $src, string $alt = ''): Img
    {
        /* @var $img \Core\Html\Elements\Img */
        $img = $this->factory->create('Elements\Img');
        $img->setSrc($src);
        
        if (! empty($alt)) {
            $img->setAlt($alt);
        }
        
        return $this->content = $img;
    }

    /**
     * Sets brand imageobject
     *
     * @param Img $img
     *
     * @return \Core\Html\Bootstrap\Navbar\BrandElement
     */
    public function setImage(Img $img): BrandElement
    {
        $this->content = $img;
        
        return $this;
    }

    /**
     * Sets brandtext.
     *
     * @param string $text
     *
     * @return \Core\Html\Bootstrap\Navbar\BrandElement
     */
    public function setText(string $text): BrandElement
    {
        $this->content = $text;
        
        return $this;
    }

    /**
     * Creates a link element to be wrapped around brand image
     *
     * @param string $url
     *
     * @return \Core\Html\Elements\A
     */
    public function createLink(string $url = ''): A
    {
        /* @var $a \Core\Html\Elements\A */
        $a = $this->factory->create('Elements\A');
        
        if (! empty($url)) {
            $a->setHref($url);
        }
        
        return $this->link = $a;
    }

    /**
     * Sets a link element to be wrapped around brand image
     *
     * @param A $a
     *
     * @return BrandElement
     */
    public function setLink(A $a): BrandElement
    {
        $this->link = $a;
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Html\Bootstrap\Navbar\AbstractNavbarElement::build()
     */
    public function build()
    {
        // Create brand
        $html = $this->content instanceof Img ? $this->page->build() : $this->content;
        
        // Brand wrapped by a link
        if ($this->link instanceof A) {
            
            $this->link->addCss('navbar-brand');
            $this->link->setInner($html);
            
            $html = $this->link->build();
        }
        
        return $html;
    }
}

<?php
namespace Core\Html\Elements;

use Core\Html\AbstractHtml;

/**
 * Img.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Img extends AbstractHtml
{

    protected $element = 'img';

    /**
     * Set src attribute
     *
     * @param string $src
     *
     * @return Img
     */
    public function setSrc(string $src)
    {
        $this->attribute['src'] = $src;

        return $this;
    }

    /**
     * Sets alt attribute.
     *
     * @param string $alt
     *
     * @return Img
     */
    public function setAlt(string $alt)
    {
        $this->attribute['alt'] = $alt;

        return $this;
    }

    /**
     * Sets title attribute.
     *
     * @param string $title
     *
     * @return Img
     */
    public function setTitle(string $title)
    {
        $this->attribute['title'] = $title;

        return $this;
    }

    /**
     * Set width attribute
     *
     * @param int $width
     */
    public function setWidth(int $width)
    {
        $this->attribute['width'] = $width;

        return $this;
    }

    /**
     * Sets height attribute
     *
     * @param int $height
     *
     * @return Img
     */
    public function setHeight(int $height)
    {
        $this->attribute['height'] = $height;

        return $this;
    }

    /**
     * Sets ismap attribute
     *
     * @param string $flag
     *
     * @return Img
     */
    public function setIsMap()
    {
        $this->attribute['ismap'] = false;

        return $this;
    }

    /**
     * Sets the name of map to use
     *
     * @param string $usemap
     *
     * @return Img
     */
    public function useMap(string $usemap)
    {
        $this->attribute['usemap'] = usemap;

        return $this;
    }
}

<?php
namespace Core\Html\Elements;

use Core\Html\AbstractHtml;

/**
 * Link.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Link extends AbstractHtml
{

    protected $element = 'link';

    /**
     * Sets rel attribute
     *
     * @param string $rel
     *
     * @return Link
     */
    public function setRel(string $rel)
    {
        $this->attribute['rel'] = $rel;

        return $this;
    }

    /**
     * Sets type attribute
     *
     * @param string $type
     *
     * @return Link
     */
    public function setType(string $type)
    {
        $this->attribute['type'] = $type;

        return $this;
    }

    /**
     * Sets href attribute
     *
     * @param string $href
     *
     * @return Link
     */
    public function setHref(string $href)
    {
        $this->attribute['href'] = $href;

        return $this;
    }
}

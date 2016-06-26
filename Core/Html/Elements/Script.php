<?php
namespace Core\Html\Elements;

use Core\Html\AbstractHtml;

/**
 * Script.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Script extends AbstractHtml
{

    protected $element = 'script';

    /**
     * Sets type attribute
     *
     * @param string $type
     *
     * @return Script
     */
    public function setType(string $type)
    {
        $this->attribute['type'] = $type;

        return $this;
    }

    /**
     * Sets src attribute
     *
     * @param string $src
     *
     * @return Script
     */
    public function setSrc(string $src)
    {
        $this->attribute['src'] = $src;

        return $this;
    }

    /**
     * Sets charset attribute
     *
     * @param string $charset
     *
     * @return Script
     */
    public function setCharset(string $charset)
    {
        $this->attribute['charset'] = $charset;

        return $this;
    }

    /**
     * Sets for attribute
     *
     * @param string $for
     *
     * @return Script
     */
    public function setFor(string $for)
    {
        $this->attribute['for'] = $for;

        return $this;
    }

    /**
     * Sets defer attribute
     *
     * @return Script
     */
    public function setDefer()
    {
        $this->addAttribute('defer');

        return $this;
    }

    /**
     * Sets async attribute
     *
     * @return Script
     */
    public function setAsync()
    {
        $this->addAttribute('async');

        return $this;
    }
}

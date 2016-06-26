<?php
namespace Core\Html\Elements;

use Core\Html\AbstractHtml;

/**
 * A.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015
 * @license MIT
 */
class A extends AbstractHtml
{

    protected $element = 'a';

    /**
     * Sets an alternate text for the link
     *
     * Required if the href attribute is present.
     *
     * @param string $alt
     *
     * @return A
     */
    public function setAlt(string $alt)
    {
        $this->attribute['alt'] = $alt;

        return $this;
    }

    /**
     * Sets the href attribute
     *
     * @param string $href
     *
     * @return A
     */
    public function setHref(string $url)
    {
        $this->attribute['href'] = $url;

        return $this;
    }

    /**
     * Sets the language of the target URL
     *
     * @param string $hreflang
     *
     * @return A
     */
    public function setHrefLang(string $hreflang)
    {
        $this->attribute['hreflang'] = $hreflang;

        return $this;
    }

    /**
     * Sets the target attribute
     *
     * @param string $target
     *
     * @return A
     */
    public function setTarget(string $target)
    {
        $this->attribute['target'] = $target;

        return $this;
    }

    /**
     * Sets he relationship between the current document and the target URL
     *
     * @param string $rel
     *
     * @throws InvalidArgumentException
     *
     * @return A
     */
    public function setRel(string $rel)
    {
        $rels = [
            'alternate',
            'author',
            'bookmark',
            'help',
            'license',
            'next',
            'nofollow',
            'noreferrer',
            'prefetch',
            'prev',
            'search',
            'tag'
        ];

        if (! in_array($rel, $rels)) {
            Throw new ElementException('Not valid rel attribute');
        }

        $this->attribute['rel'] = $rel;

        return $this;
    }

    /**
     * Sets that the target will be downloaded when a user clicks on the link
     *
     * @return A
     */
    public function isDownload()
    {
        $this->attribute['download'] = false;

        return $this;
    }

    /**
     * Sets what media/device the target URL is optimized for
     *
     * @param string $media
     *
     * @return A
     */
    public function setMedia(string $media)
    {
        $this->attribute['media'] = $media;

        return $this;
    }

    /**
     * Sets the MIME type of the target URL
     *
     * @param string $type
     *
     * @return A
     */
    public function setType(string $type)
    {
        $this->attribute['type'] = $type;

        return $this;
    }

    /**
     * Build method with href and set alt check
     *
     * @see \Core\Abstracts\AbstractHtml::build()
     */
    public function build()
    {
        if (isset($this->attribute['href']) && (! isset($this->attribute['alt']))) {
            $this->attribute['alt'] = $this->attribute['href'];
        }

        return parent::build();
    }
}

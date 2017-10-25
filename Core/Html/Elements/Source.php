<?php
namespace Core\Html\Elements;

use Core\Html\AbstractHtml;

/**
 * Source.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
class Source extends AbstractHtml
{

    protected $element = 'source';

    /**
     * Sets the type of media resource
     *
     * @param string $media
     *
     * @return Source
     */
    public function setMedia(string $media)
    {
        $this->attribute['media'] = $media;

        return $this;
    }

    /**
     * Sets the URL of the media file
     *
     * @param string $source
     *
     * @return Source
     */
    public function setSource(string $source)
    {
        $this->attribute['source'] = $source;

        return $this;
    }

    /**
     * Sets the MIME type of the media resource
     *
     * @param string $type
     *
     * @return Source
     */
    public function setType(string $type)
    {
        $this->attribute['type'] = $type;

        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Html\AbstractHtml::build()
     *
     * @throws ElementException
     */
    public function build()
    {
        if (empty($this->attribute['source'])) {
            Throw new ElementException('No mediasource set.');
        }

        if (empty($this->attribute['type'])) {
            Throw new ElementException('No media type set.');
        }

        return parent::build();
    }
}

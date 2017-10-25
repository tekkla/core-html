<?php
namespace Core\Html\Elements;

use Core\Html\AbstractHtml;

/**
 * Audio.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
class Audio extends AbstractHtml
{

    protected $element = 'audio';

    /**
     * Sources stack
     *
     * @var array
     */
    private $sources = [];

    /**
     * Default no support text
     *
     * @var string
     */
    private $no_support_text = 'Html is not supported';

    /**
     * Set the text to be shown when the browser does not support the audio element.
     *
     * @param string $text
     *
     * @return Audio
     */
    public function setNoSupportText(string $text)
    {
        $this->no_support_text = $text;

        return $this;
    }

    /**
     * Defines that audio controls should be displayed
     *
     * @return Audio
     */
    public function useControls()
    {
        $this->attribute['controls'] = false;

        return $this;
    }

    /**
     * Defines that the audio starts playing as soon as it is ready
     *
     * @return Audio
     */
    public function useAutoplay()
    {
        $this->attribute['autoplay'] = false;

        return $this;
    }

    /**
     * Defines that the audio will start over again, every time it is finished
     *
     * @return Audio
     */
    public function isLoop()
    {
        $this->attribute['loop'] = false;

        return $this;
    }

    /**
     * Defines that the audio output should be muted by default
     *
     * @return Audio
     */
    public function isMuted()
    {
        $this->attribute['muted'] = false;

        return $this;
    }

    /**
     * Sets if and how the audio should be loaded when the page loads
     *
     * @param string $preload
     *
     * @throws ElementException
     *
     * @return Audio
     */
    public function setPreload(string $preload = 'none')
    {
        $preloads = [
            'auto',
            'metadata',
            'none'
        ];

        if (! in_array($preload, $preloads)) {
            Throw new ElementException('Prelaod type not supported', 1000);
        }

        $this->attribute['preload'] = $preload;

        return $this;
    }

    /**
     * Sets the URL of the audio file
     *
     * @param string $url
     *
     * @return Audio
     */
    public function setSrc(string $url)
    {
        $this->attribute['src'] = $url;

        return $this;
    }

    /**
     * Adds a source element to this audio element
     *
     * @param Source $source
     *
     * @return Audio
     */
    public function addSourceElement(Source $source)
    {
        $this->sources[] = $source;

        return $this;
    }

    public function build()
    {
        // Build source elements and add them to inner html
        foreach ($this->sources as $source) {
            $this->inner .= $source->build() . PHP_EOL;
        }

        if (empty($this->no_support_text)) {
            $this->no_support_text = 'Html is not supported';
        }

        $this->inner .= $this->no_support_text;

        return parent::build();
    }
}

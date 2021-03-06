<?php
namespace Core\Html\Bootstrap\Alert;

use Core\Html\AbstractHtml;
use Core\Html\Elements\Div;
use Core\Html\Bootstrap\BootstrapContextInterface;
use Core\Html\HtmlBuildableInterface;
use Core\Html\HtmlException;

/**
 * Alert.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Alert implements HtmlBuildableInterface, BootstrapContextInterface
{

    /**
     *
     * @var boolean
     */
    private $dismissable = true;

    /**
     *
     * @var string
     */
    private $context = 'primary';

    /**
     *
     * @var string
     */
    private $content = '';

    /**
     *
     * @var \Core\Html\AbstractHtml
     */
    public $html;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->html = new Div();
    }

    /**
     * Sets dismissable state
     *
     * @param bool $dismissable
     */
    public function setDismissable(bool $dismissable)
    {
        $this->dismissable = $dismissable;
    }

    /**
     * Returns dismissable state
     *
     * @return boolean
     */
    public function getDismissable()
    {
        return $this->dismissable;
    }

    /**
     * Sets a different Html element to use for the alert
     *
     * @param AbstractHtml $element
     */
    public function setHtmlElement(AbstractHtml $element)
    {
        $this->html = $element;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Html\Bootstrap\BootstrapContextInterface::setContext()
     */
    public function setContext($context)
    {
        $allowed = [
            self::SUCCESS,
            self::PRIMARY,
            self::INFO,
            self::WARNING,
            self::DANGER
        ];

        if (! in_array($context, $allowed)) {
            Throw new HtmlException('Given "%s" is no valid Bootstrap::Alert type. Allowed types are: %s', $context, implode(', ', $allowed));
        }

        $this->context = $context;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Html\Bootstrap\BootstrapContextInterface::getContext()
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Sets the alerts content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Returns set alert content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Core\Html\HtmlBuildableInterface::build()
     */
    public function build()
    {
        if (! $this->html instanceof AbstractHtml) {
            Throw new HtmlException('Bootstrap Alert object need a html object that is an instance of HtmlAbstact');
        }

        $this->html->addCss([
            'alert',
            'alert-' . $this->context
        ]);

        if ($this->dismissable) {
            $this->html->addCss('alert-dismissable');
            $this->html->setInner('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>');
        }

        $this->html->addInner($this->content);
        $this->html->setRole('alert');

        return $this->html->build();
    }
}

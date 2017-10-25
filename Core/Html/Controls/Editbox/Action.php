<?php
namespace Core\Html\Controls\Editbox;

use Core\Html\HtmlBuildableInterface;

/**
 * Action.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
class Action
{

    const SAVE = 'save';

    const CANCEL = 'cancel';

    const CONTEXT = 'context';

    /**
     *
     * @var string
     */
    private $text = 'no text set';

    /**
     *
     * @var string
     */
    private $href = 'no href set';

    /**
     *
     * @var boolean
     */
    private $ajax = false;

    /**
     *
     * @var string
     */
    private $confirm = '';

    /**
     *
     * @var string
     */
    private $type = 'context';

    /**
     *
     * @var string
     */
    private $icon = '';

    /**
     * Returns set action text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets action text
     *
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * Returns set action href
     *
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * Sets action href
     *
     * @param string $href
     */
    public function setHref(string $href)
    {
        $this->href = $href;
    }

    /**
     * Returns actios ajax flag
     *
     * @return bool
     */
    public function getAjax(): bool
    {
        return $this->ajax;
    }

    /**
     * Set action ajax flag
     *
     * @param bool $ajax
     */
    public function setAjax(bool $ajax)
    {
        $this->ajax = $ajax;
    }

    /**
     * Returns set confirm text
     *
     * @return string
     */
    public function getConfirm(): string
    {
        return $this->confirm;
    }

    /**
     * Sets confirm text
     *
     * @param string $confirm
     */
    public function setConfirm(string $confirm)
    {
        $this->confirm = $confirm;
    }

    /**
     * Returns set action type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets action type
     *
     * Allowed types are: 'save', 'delete', 'cancel', 'context'
     *
     * @param string $type
     */
    public function setType(string $type)
    {
        $allowed = [
            'save',
            'delete',
            'cancel',
            'context'
        ];
        
        if (! in_array($type, $allowed)) {
            Throw new EditboxException(sprintf('Type "%s" is not a allowed editbox actiontype', $type));
        }
        
        $this->type = $type;
    }

    /**
     * Returns set icon instance
     *
     * @return HtmlBuildableInterface
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets an icon instance
     * 
     * @param HtmlBuildableInterface $icon
     */
    public function setIcon(HtmlBuildableInterface $icon)
    {
        $this->icon = $icon;
    }
}

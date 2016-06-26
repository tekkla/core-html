<?php
namespace Core\Html\Controls;

use Core\Html\Fontawesome\Icon;
use Core\Html\Elements\A;

/**
 * UiButton.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class UiButton extends A
{

    /**
     * Buttontype
     *
     * @var string
     */
    protected $type = 'text';

    /**
     *
     * @var bool
     */
    protected $modal = false;

    /**
     * Accessmode
     *
     * @var string
     */
    protected $mode = 'full';

    /**
     * Link title
     *
     * @var string
     */
    protected $title = '';

    /**
     * img object
     *
     * @var Icon
     */
    protected $icon = false;

    /**
     * button text
     *
     * @var string
     */
    protected $text = '';

    /**
     * Sets buttonmode to: ajax
     *
     * @return UiButton
     */
    public function useAjax()
    {
        $this->mode = 'ajax';

        return $this;
    }

    /**
     * Sets buttonmode to: full
     *
     * @return UiButton
     */
    public function useFull()
    {
        $this->mode = 'full';

        return $this;
    }

    /**
     * Sets the buttonmode
     *
     * @param string $mode
     *
     * @throws InvalidArgumentException
     *
     * @return UiButton
     */
    public function setMode($mode)
    {
        $modelist = [
            'ajax',
            'full'
        ];

        if (!in_array($mode, $modelist)) {
            Throw new ControlException('Wrong mode for UiButton.', 1000);
        }

        $this->mode = $mode;

        return $this;
    }

    /**
     * Returns the set mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * S(non-PHPdoc)
     *
     * @see \Core\Html\Elements\A::setType()
     */
    public function setType(string $type): UiButton
    {
        $typelist = [
            'link',
            'icon',
            'button',
            'imgbutton'
        ];

        if (!in_array($type, $typelist)) {
            Throw new ControlException('Wrong type for UiButton.', 1000);
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Set an icon from fontawesome icon.
     * Use only the name without the leading "fa-"
     *
     * @param string $icon
     *
     * @return \Core\Html\controls\UiButton
     */
    public function setIcon($icon)
    {
        $this->icon = $this->factory->create('Fontawesome\Icon');
        $this->icon->setIcon($icon);

        return $this;
    }

    /**
     * Set a linktext.
     * If a linktext and an image is set, the linktext will be ignored!!!
     *
     * @param $val string
     *            Inner HTML of link
     *
     * @return \Core\Html\controls\UiButton
     */
    function setText($val)
    {
        $this->text = $val;

        return $this;
    }

    /**
     * Set the links as post.
     * You need to set the formname paramtere, so the ajax script can fetch the
     * data of the form.
     *
     * @param $form_name string
     *
     * @return \Core\Html\Controls\UiButton
     */
    public function setForm($form_name)
    {
        $this->data['form'] = $form_name;

        return $this;
    }

    /**
     * Add a confirmevent to the link.
     * IF confirm returns false, the link won't be executed
     *
     * @param string $msg
     *
     * @return \Core\Html\Controls\UiButton
     */
    public function setConfirm($msg)
    {
        $this->data['confirm'] = $msg;

        return $this;
    }

    /**
     * Sets target of button to be displayed in modal window
     *
     * @param string $modal
     *            Name of modal window frame
     *
     * @return \Core\Html\Controls\UiButton
     */
    public function setModal($modal = '#modal')
    {
        $this->data['modal'] = $modal;

        return $this;
    }

    /**
     * Sets named route and optionale params to the url object of button
     *
     * @param string $url
     *
     * @return \Core\Html\Controls\UiButton
     */
    public function setUrl($url)
    {
        $this->setHref($url);

        return $this;
    }

    /**
     * Builds and returns button html code
     *
     * @param string $wrapper
     *
     * @throws Error
     *
     * @return string
     */
    public function build()
    {
        if ($this->mode == 'ajax') {
            $this->data['ajax'] = 'link';
        }

        // Set text and set icon means we have a button of type imagebutton
        if ($this->text && $this->icon) {
            $this->type = 'imgbutton';
        }

        // icon/image
        if ($this->type == 'icon') {
            $this->css['icon'] = 'icon';
            $this->icon->noStack();
            $this->inner = $this->icon->build();
        }

        // textbutton
        if ($this->type == 'button') {
            $this->inner = '<span class="button-text">' . $this->text . '</span>';
        }

        // simple link
        if ($this->type == 'link') {
            $this->css['link'] = 'link';
            $this->inner = '<span class="link-text">' . $this->text . '</span>';
        }

        // imgbutton
        if ($this->type == 'imgbutton') {
            $this->icon->noStack();
            $this->inner = $this->icon->build() . ' ' . $this->text;
        }

        // Do we need to set the default button css code for a non link?
        if ($this->type != 'link') {

            $this->css['btn'] = 'btn';

            $check = [
                'btn-primary',
                'btn-success',
                'btn-warning',
                'btn-info',
                'btn-default'
            ];

            if ($this->checkCss($check) == false) {
                $this->addCss('btn-default');
            }
        }

        return parent::build();
    }
}

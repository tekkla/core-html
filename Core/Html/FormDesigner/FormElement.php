<?php
namespace Core\Html\FormDesigner;

use Core\Html\Form\AbstractForm;
use Core\Html\AbstractHtml;
use Core\Html\FormDesigner\Controls\ControlsCollectionInterface;

/**
 * FormElement.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
class FormElement
{

    /**
     * Elements type
     *
     * @var string
     */
    private $type = 'control';

    /**
     * Elements content
     *
     * @var string|AbstractForm|AbstractHtml
     */
    private $content = '';

     /**
     * Sets the element.
     *
     * @param string|AbstractForm|AbstractHtml $element
     *
     * @return mixed<\Core\Html\AbstractForm, \Core\Html\AbstractHtml, \Core\Html\FormDesigner\FormGroup>
     */
    public function &setContent($content)
    {
        // Set element type by analyzing the element
        switch (true) {

            case ($content instanceof FormGroup):
                $this->type = 'group';
                break;

            case ($content instanceof ControlsCollectionInterface):
                $this->type = 'collection';
                break;

            case ($content instanceof AbstractForm):
                $this->type = 'control';
                break;

            case ($content instanceof AbstractHtml):
                $this->type = 'factory';
                break;

            default:
                $this->type = 'html';
        }

        $this->content = $content;

        return $content;
    }

    /**
     * Returns the set element.
     *
     * @return mixed <string, \Core\Html\AbstractForm, \Core\Html\AbstractHtml>
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns elements type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}

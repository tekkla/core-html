<?php
namespace Core\Html\Form;

use Core\Html\Form\Traits\ValueTrait;
use Core\Html\Form\Traits\MaxlengthTrait;
use Core\Html\Form\Traits\PlaceholderTrait;
use Core\Html\Form\Interfaces\PlaceholderInterface;

/**
 * Textarea.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Textarea extends AbstractForm implements PlaceholderInterface
{

    use ValueTrait;
    use MaxlengthTrait;
    use PlaceholderTrait;

    protected $element = 'textarea';

    protected $data = [
        'control' => 'textarea'
    ];

    /**
     * Sets cols attribute
     *
     * @param int $cols
     *
     * @throws FormException
     *
     * @return Textarea
     */
    public function setCols(int $cols): Textarea
    {
        if (empty((int) $cols)) {
            Throw new FormException('A html form textareas cols attribute need to be of type integer');
        }

        $this->attribute['cols'] = $cols;

        return $this;
    }

    /**
     * Sets rows attribute.
     *
     * @param int $rows
     *
     * @throws FormException
     *
     * @return Textarea
     */
    public function setRows(int $rows): Textarea
    {
        if (empty((int) $rows)) {
            Throw new FormException('A html form textareas rows attribute needs to be of type integer');
        }

        $this->attribute['rows'] = $rows;

        return $this;
    }

    /**
     * Sets a value as inner value of the textarea
     *
     * @param string $value
     *
     * @return Textarea
     */
    public function setValue($value): Textarea
    {
        $this->inner = $value;

        return $this;
    }

    public function build()
    {
        return parent::build();
    }
}

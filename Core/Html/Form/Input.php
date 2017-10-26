<?php
namespace Core\Html\Form;

use Core\Html\Form\Traits\ValueTrait;
use Core\Html\Form\Traits\MaxlengthTrait;
use Core\Html\Form\Traits\PlaceholderTrait;
use Core\Html\Form\Traits\IsCheckedTrait;
use Core\Html\Form\Traits\IsMultipleTrait;
use Core\Html\Form\Interfaces\PlaceholderInterface;

/**
 * Input.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
class Input extends AbstractForm implements PlaceholderInterface
{
    use ValueTrait;
    use MaxlengthTrait;
    use PlaceholderTrait;
    use IsCheckedTrait;
    use IsMultipleTrait;

    // element specific value for
    // type: text|hidden|button|submit
    // default: text
    protected $type = 'text';

    /**
     *
     * @var string
     */
    protected $element = 'input';

    /**
     *
     * @var array
     */
    protected $data = [
        'control' => 'input'
    ];

    /**
     * Sets input type
     *
     * @param string $type
     *
     * @throws FormException
     *
     * @return Input
     */
    public function setType(string $type): Input
    {
        $types = [
            'button',
            'checkbox',
            'color',
            'date',
            'datetime',
            'datetime-local',
            'email',
            'file',
            'hidden',
            'image',
            'month',
            'number',
            'password',
            'radio',
            'range',
            'reset',
            'search',
            'submit',
            'tel',
            'text',
            'time',
            'url',
            'week '
        ];
        
        if (! in_array($type, $types)) {
            Throw new FormException('Your type "' . $type . '" is no valid input control type. Allowed are ' . implode(', ', $types));
        }
        
        $this->type = $type;
        $this->attribute['type'] = $type;
        $this->data['control'] = $type == 'hidden' ? 'hidden' : 'input';
        
        return $this;
    }

    /**
     * Returns the input type attribute
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets size attribute.
     *
     * @param int $size
     *
     * @throws FormException
     *
     * @return Input
     */
    public function setSize(int $size): Input
    {
        if (empty((int) $size)) {
            Throw new FormException('A html form inputs size needs to be an integer.');
        }
        
        $this->attribute['size'] = $size;
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Core\Html\AbstractHtml::build()
     */
    public function build()
    {
        $this->attribute['type'] = $this->type;
        
        return parent::build();
    }
}

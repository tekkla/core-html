<?php
namespace Core\Html\Form;

use Core\Html\Form\Traits\ValueTrait;

/**
 * Button.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
class Button extends AbstractForm
{
    
    use ValueTrait;

    /**
     * Button type 'submit'
     *
     * @var string
     */
    const TYPE_SUBMIT = 'submit';

    /**
     * Button type 'button'
     *
     * @var string
     */
    const TYPE_BUTTON = 'button';

    /**
     * Button type 'reset'
     *
     * @var string
     */
    const TYPE_RESET = 'reset';

    /**
     * Type of button
     *
     * @var string
     */
    protected string $type = 'button';

    /**
     * Element type
     *
     * @var string
     */
    protected string $element = 'button';

    /**
     * Basic data attributes
     *
     * @var array
     */
    protected array $data = [
        'control' => 'button'
    ];

    /**
     * Sets element type to: button (default).
     *
     * @return Button
     */
    public function isButton()
    {
        $this->type = 'button';

        return $this;
    }

    /**
     * Sets element type to: submit.
     *
     * @return Button
     */
    public function isSubmit()
    {
        $this->type = 'submit';

        return $this;
    }

    /**
     * Sets element type to: reset.
     *
     * @return Button
     */
    public function isReset()
    {
        $this->type = 'reset';

        return $this;
    }

    /**
     * Sets element type.
     *
     * @param string $type
     *            Type of element (submit, reset or button)
     *            
     * @throws FormException
     *
     * @return Button
     */
    public function setType(string $type): Button
    {
        $types = [
            'submit',
            'reset',
            'button'
        ];
        
        if (! in_array($type, $types)) {
            Throw new FormException('Wrong button type set.');
        }
        
        $this->type = $type;
        
        return $this;
    }

    /**
     * Set the id of the form this button belongs to.
     *
     * @param string $form_id
     *
     * @return Button
     */
    public function setFormId(string $form_id): Button
    {
        $this->attribute['form'] = $form_id;
        
        return $this;
    }

    /**
     * Sets the url where to send form data on submit (only on buttontype "submit").
     *
     * @param string $url
     *            Url string or object used as form action
     *            
     * @return Button
     */
    public function setFormAction(string $url): Button
    {
        $this->attribute['formaction'] = $url;
        
        return $this;
    }

    /**
     * Set the method of form the button belongs to.
     * Use 'post' or 'get'.
     * Form elements are using post by default.
     *
     * @param string $method
     *            Value for the method attribute of from
     *            
     * @throws FormException
     *
     * @return Button
     */
    public function setFormMethod(string $method): Button
    {
        $methods = [
            'post',
            'get'
        ];
        
        // Safety first. Only allow 'post' or 'get' here.
        if (! in_array($method, $methods)) {
            Throw new FormException('Wrong method set.');
        }
        
        $this->attribute['formmethod'] = $method;
        
        return $this;
    }

    /**
     * Set the form method attribute.
     * Use 'post' or 'get'.
     * Form elements are using post by default.
     *
     * @param string $method
     *            Value for the method attribute of from
     *            
     * @throws FormException
     *
     * @return Button
     */
    public function setFormEnctype(string $enctype)
    {
        $enctypes = [
            'application/x-www-form-urlencoded',
            'multipart/form-data',
            'text/plain'
        ];
        
        // Safety first. Only allow 'post' or 'get' here.
        if (! in_array($enctype, $enctypes)) {
            Throw new FormException('Wrong method set.');
        }
        
        $this->attribute['formenctype'] = $enctype;
        
        return $this;
    }

    /**
     * Set target of form the button belongs to
     *
     * @param string $target
     *
     * @return Button
     */
    public function setFormTarget(string $target): Button
    {
        $this->attribute['formtarget'] = $target;
        
        return $this;
    }

    /**
     * Deactivates form validation of form the button belongs to by setting "novalidate" attribute
     *
     * @return Button
     */
    public function setFormNoValidate(): Button
    {
        $this->attribute['formnovalidate'] = false;
        
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

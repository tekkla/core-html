<?php
namespace Core\Html\Form;

use Core\Html\AbstractHtml;

/**
 * Form.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2021
 * @license MIT
 */
class Form extends AbstractHtml
{

    protected string $element = 'form';
    protected array $attribute = [
        'role' => 'form',
        'method' => 'post',
        'enctype' => 'multipart/form-data'
    ];

    /**
     * Sets the action url
     *
     * @param string $action
     *
     * @return Form
     */
    public function setAction(string $action): Form
    {
        $this->attribute['action'] = $action;

        return $this;
    }

    /**
     * Returns action attributes values
     *
     * @return string
     */
    public function getAction(): string
    {
        if (isset($this->attribute['action'])) {
            return $this->attribute['action'];
        }

        return '';
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
     * @return Form
     */
    public function setMethod(string $method): Form
    {
        $methods = [
            'post',
            'get'
        ];

        // Safety first. Only allow 'post' or 'get' here.
        if (!in_array(strtolower($method), $methods)) {
            Throw new FormException('Wrong html form method attribute set.');
        }

        $this->attribute['method'] = $method;

        return $this;
    }

    /**
     * Set the form method attribute.
     * Use 'post' or 'get'.
     * Form elements are using post by default.
     *
     * @param string $enctype
     *            Value for the method attribute of from
     *
     * @throws FormException
     *
     * @return Form
     */
    public function setEnctype(string $enctype): Form
    {
        $enctypes = [
            'application/x-www-form-urlencoded',
            'multipart/form-data',
            'text/plain'
        ];

        // Safety first. Only allow 'post' or 'get' here.
        if (!in_array(strtolower($enctype), $enctypes)) {
            Throw new FormException('Wrong html form enctype attribute set.', 1000);
        }

        $this->attribute['enctype'] = $enctype;

        return $this;
    }

    /**
     * Set form accept charset attribute
     *
     * @param string $accept_charset
     *
     * @return Form
     */
    public function setAcceptCharset(string $accept_charset): Form
    {
        $this->attribute['accept_charset'] = $accept_charset;

        return $this;
    }

    /**
     * Set form target attribute
     *
     * @param string $target
     *
     * @return Form
     */
    public function setTarget(string $target): Form
    {
        $this->attribute['target'] = $target;

        return $this;
    }

    /**
     * Set autoomplete attribute with state 'on' or 'off'
     *
     * @param string $state
     *
     * @throws FormException
     *
     * @return Form
     */
    public function setAutocomplete(string $state = 'on'): Form
    {
        $states = [
            'on',
            'off'
        ];

        if (!in_array(strtolower($state), $states))
            Throw new FormException('Wrong html form autocomplete attribute state.', 1000);

        $this->attribute['autocomplete'] = $state;

        return $this;
    }

    /**
     * Deactivates form validation by setting "novalidate" attribute
     *
     * @return Form
     */
    public function noValidate(): Form
    {
        $this->attribute['novalidate'] = false;

        return $this;
    }
}

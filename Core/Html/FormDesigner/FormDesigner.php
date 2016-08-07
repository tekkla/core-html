<?php
namespace Core\Html\FormDesigner;

use Core\Data\Container\Container;
use Core\Html\Form\Form;
use Core\Html\Form\Checkbox;
use Core\Html\Form\Select;
use Core\Html\Form\Button;
use Core\Html\Form\AbstractForm;
use Core\Html\HtmlBuildableInterface;
use Core\Html\HtmlFactory;

/**
 * FormDesigner.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
final class FormDesigner implements HtmlBuildableInterface
{

    /**
     *
     * @var array
     */
    private static $used_ids = [];

    /**
     * Forms group storage
     *
     * @var array
     */
    private $groups = [];

    /**
     * The mode the data will be send to server
     *
     * @var string Options: full | ajax / Default: full
     */
    private $send_mode = 'submit';

    /**
     * Displaymode of the form h = horizontal v = vertical (default) i = inline
     *
     * @see http://getbootstrap.com/css/#forms
     * @var string
     */
    private $display_mode = 'v';

    /**
     * Labels grid width when using horizontal displaymode
     *
     * @var number
     */
    private $label_width = 3;

    /**
     * The gridtype used in the form Select from:
     * col-xs, col-sm (default), col-md and col-lg
     *
     * @see http://getbootstrap.com/css/#grid-options
     * @var string
     */
    private $grid_size = 'sm';

    /**
     *
     * @var array
     */
    private $data = [];

    /**
     *
     * @var array
     */
    private $errors = [];

    /**
     *
     * @var array
     */
    private $token = [];

    /**
     *
     * @var string
     */
    private $namespace = 'core';

    /**
     *
     * @var bool
     */
    private $fadeout = true;

    /**
     *
     * @var Form
     */
    public $html;

    /**
     *
     * @var HtmlFactory
     */
    public $factory;

    /**
     * Constructor
     *
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        $this->setNamespace($namespace);

        $this->factory = new HtmlFactory();
        $this->html = $this->factory->create('Form\Form');
    }

    /**
     * Sets form token
     *
     * @param string $name
     * @param string $token
     *
     * @throws FormDesignerException
     */
    public function setToken(string $name, string $token)
    {
        $this->setTokenName($name);

        if (empty($token)) {
            Throw new FormDesignerException('Empty form tokens are not allowed.');
        }

        $this->token['token'] = $token;
    }

    /**
     * Returns set token
     *
     * @return string
     */
    public function getToken(): string
    {
        if (empty($this->token)) {
            Throw new FormDesignerException('No form token set.');
        }

        return $this->token['token'];
    }

    /**
     * Sets form token name
     *
     * @param string $name
     *
     * @throws FormDesignerException
     */
    public function setTokenName(string $name)
    {
        if (empty($name)) {
            Throw new FormDesignerException('Empty token name is not allowed.');
        }

        $this->token['name'] = $name;
    }

    /**
     * Returns form token name
     *
     * @return string
     */
    public function getTokenName(): string
    {
        if (empty($this->token)) {
            Throw new FormDesignerException('No form token set.');
        }

        return $this->token['name'];
    }

    /**
     *
     * @see FormDesigner::setData()
     *
     * @param
     *            $data
     */
    public function mapData($data)
    {
        $this->setData($data);
    }

    /**
     * Sets form data
     *
     * @param
     *            $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Returns set form data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     *
     * @param array $errors
     */
    public function mapErrors(array $errors)
    {
        $this->setErrors($errors);
    }

    /**
     * Sets errors
     *
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Returns set errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Core\Html\AbstractHtml::setId()
     */
    public function setId($id)
    {
        if (in_array($id, self::$used_ids)) {
            Throw new FormDesignerException(sprintf('The form id "%s" is already in use. Please set a different/unique form id.', $id));
        }

        self::$used_ids[] = $id;

        $this->html->setId($id);

        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Core\Html\AbstractHtml::setId()
     */
    public function setName($name)
    {
        $this->html->setName($name);

        return $this;
    }

    /**
     * Sets grid size type which is used in horizontal forms
     *
     * @param string $size
     *            Bootstrap Grid size type aka "xs", "sm", "md" or "lg"
     *
     * @throws FormDesignerException
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function setGridSize($grid_size)
    {
        $sizes = [
            'xs',
            'sm',
            'md',
            'lg'
        ];

        if (!in_array($grid_size, $sizes)) {
            Throw new FormDesignerException(sprintf('FormDesigner allowed grid sizes are %s. The size "%s" is not supported.', implode(', ', $sizes), $grid_size));
        }

        $this->grid_size = $grid_size;

        return $this;
    }

    /**
     * With of label when form display mode is horizontal
     *
     * @param int $label_width
     *            Value between 1 and 12 as label width
     *
     * @throws FormDesignerException
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function setLabelWidth($label_width)
    {
        if ($label_width < 1 || $label_width > 12) {
            Throw new FormDesignerException('FormDesigner label width needs to be a value between 1 and 12');
        }

        $this->label_width = $label_width;

        return $this;
    }

    /**
     * Set the sendmode for the form.
     * You can use the html submit or the frameworks ajax system. Default: 'submit'
     *
     * @param string $send_mode
     *            Send mode which can be 'ajax' or 'submit'
     *
     * @throws FormDesignerException
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function setSendMode($send_mode)
    {
        $modes = [
            'ajax',
            'submit'
        ];

        if (!in_array($send_mode, $modes)) {
            Throw new FormDesignerException(sprintf('"%s" is not an allowed form sendmode.', $send_mode), 1000);
        }

        $this->send_mode = $send_mode;

        return $this;
    }

    /**
     * Set prefix tp be used when creating label for a control.
     * Useful for categorized language strings.
     *
     * @param string $label_prefix
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function setLabelPrefix($label_prefix)
    {
        $this->label_prefix = $label_prefix;

        return $this;
    }

    /**
     * Sets fadeout flag
     *
     * @param bool $fadeout
     */
    public function setFadeout(bool $fadeout)
    {
        $this->fadeout = $fadeout;
    }

    /**
     * Returns set fadeout flag
     *
     * @return bool
     */
    public function getFadeout(): bool
    {
        return $this->fadeout;
    }

    /**
     * Sets namespace
     *
     * @param string $namespace
     */
    public function setNamespace(string $namespace)
    {
        if (empty($namespace)) {
            Throw new FormDesignerException('You must provide a namespace that gets used as basename for all controls and elements that will be created via FormDesigner°');
        }

        $this->namespace = $namespace;
    }

    /**
     * Returns set namespace
     *
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * Returns set fadeout time
     *
     * @return int
     */
    public function getFadeoutTime(): int
    {
        return $this->fadeout_time;
    }

    /**
     * Creates a FormGroup
     *
     * @param bool $unshift
     *            Optional flag to add group at beginning of controls array.
     *
     * @return FormGroup
     */
    public function &addGroup($unshift = false)
    {
        $group = $this->factory->create('FormDesigner\FormGroup');

        if ($unshift == true) {
            array_unshift($this->groups, $group);
        }
        else {
            $this->groups[] = $group;
        }

        $group->injectFormDesigner($this);

        return $group;
    }

    /**
     * Sets the forms display mode to horizontal
     *
     * @param string $size
     *            Optional Bootstrap gridsize type aka "xs", "sm", "md" or "lg". Default: 'sm'
     *
     * @param int $label_width
     *            Optional label with between 1 and 12. Default: 3
     *
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function isHorizontal($grid_size = 'sm', $label_with = '3')
    {
        $this->display_mode = 'h';
        $this->setGridSize($grid_size);
        $this->setLabelWidth($label_with);

        return $this;
    }

    /**
     * Sets the forms display mode to vertical
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function isVertical()
    {
        $this->display_mode = 'v';

        return $this;
    }

    /**
     * Sets the forms display mode to inline
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function isInline()
    {
        $this->display_mode = 'i';

        return $this;
    }

    /**
     * Wrapper method for setSendMode('ajax')
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function isAjax()
    {
        $this->send_mode = 'ajax';

        return $this;
    }

    /**
     * Wrapper method for setSendmode('full')
     *
     * @return \Core\Html\FormDesigner\FormDesigner
     */
    public function isSubmit()
    {
        $this->send_mode = 'submit';

        return $this;
    }

    /**
     * Returns forms send mode.
     *
     * @return string
     */
    public function getSendMode()
    {
        return $this->send_mode;
    }

    /**
     * Checks a possible used Container object for global errors "@" and adds a new FormGoup object on top of the groups
     * stack.
     */
    private function handleGlobalContainerErrors()
    {
        // No data of form with our id in session stored?
        if (empty($this->errors['@'])) {
            return;
        }

        // Add a group on top of exiting groups
        $group = $this->addGroup(true);

        $div = $group->addElement('Elements\Div');
        $div->addCss('alert alert-danger alert-dismissable');

        if ($this->fadeout) {
            $div->addCss('fadeout');
        }

        $html = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . implode('<br>', $this->errors['@']);

        $div->setInner($html);
    }

    /**
     * Handles display mode by setting the matching css class.
     *
     * @see http://getbootstrap.com/css/#forms
     */
    private function handleDisplayMode()
    {
        switch ($this->display_mode) {
            case 'h':
                $this->html->addCss('form-horizontal');
                break;
            case 'i':
                $this->html->addCss('form-inline');
                break;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Html\AbstractHtml::build()
     *
     * @throws FormDesignerException
     */
    public function build()
    {
        if (empty($this->groups)) {
            Throw new FormDesignerException('Your form has no groups to show. Add groups and try again.');
        }

        if (!$this->html->getId()) {
            Throw new FormDesignerException('There is no unique form id set. Each FormDesigner form needs it\'s unique id');
        }

        // Handle global container errors
        $this->handleGlobalContainerErrors();

        // Handle display mode
        $this->handleDisplayMode();

        // Control html container
        $html = '';

        // Create hidden field with unique session token
        if (!empty($this->token)) {
            $html .= '<input type="hidden" name="' . $this->token['name'] . '" value="' . $this->token['token'] . '">';
        }

        foreach ($this->groups as $group) {
            $html .= $this->buildGroup($group, [], $this->data, $this->errors);
        }

        $this->html->addInner($html);

        return $this->html->build();
    }

    /**
     * Recursivable method to build the created groups and the controls stroed as FormElement objects within each
     * FormGroup object.
     *
     * @param FormGroup $group
     *
     * @return string
     */
    private function buildGroup(FormGroup $group, array $names = [], $data = [], array $errors = [])
    {
        $html = '';

        // Get groupname
        $group_name = $group->getName();

        // If group has a name, add it to the names array
        if (!empty($group_name)) {
            $names[] = $group_name;
        }

        // Get grouperrors
        $group_errors = !empty($group_name) && !empty($errors[$group_name]) ? $errors[$group_name] : $errors;

        // Get group data
        $group_data = !empty($group_name) && !empty($data[$group_name]) ? $data[$group_name] : $data;

        // Build elements
        $elements = $group->getElements();

        /* @var $element \Core\Html\FormDesigner\FormElement */
        foreach ($elements as $element) {

            $builder = new ControlBuilder();

            $content = $element->getContent();

            switch ($element->getType()) {

                case 'control':

                    // Get control name
                    $name = $content->getName();

                    // Set control id
                    if (empty($content->getId())) {

                        // Create control id elements
                        $id = $this->namespace . '-';

                        if (!empty($names)) {
                            $id .= implode('-', $names);
                        }

                        $id .= '-' . empty($name) ? uniqid('control-') : $name;

                        $content->setId($id);
                    }

                    // Create control name for bound controls...
                    if ($content->isBound()) {

                        if (empty($name)) {
                            Throw new FormDesignerException(sprintf('Bound controls without a name are not allowed. %s', print_r($content, true)));
                        }

                        // Create name parts based on current group names
                        $pieces = array_map(function ($name) {
                            return '[' . $name . ']';
                        }, $names);

                        $pieces[] = '[' . $name . ']';

                        $content->setName($this->namespace . implode('', $pieces));
                    }
                    else {

                        // ...and remove name from the unbound ones!
                        $content->removeName();
                    }

                    // Any errors?
                    if (!empty($group_errors[$name])) {
                        $builder->setErrors($group_errors[$name]);
                    }

                    if (isset($group_data[$name])) {

                        switch (true) {
                            case ($content instanceof Checkbox):
                                if ($content->getValue() == $group_data[$name]) {
                                    $content->isChecked();
                                }
                                break;

                            default:
                                if (empty($content->getValue()) && method_exists($content, 'setValue')) {
                                    $content->setValue($group_data[$name]);
                                }
                                break;
                        }
                    }

                    // Handle buttons
                    if ($content instanceof Button) {

                        // Add needed ajax data attribute
                        if ($this->getSendMode() == 'ajax') {
                            $content->addData('ajax');
                        }

                        // Submit buttons need the id and action of and for the form to submit
                        if ($content->isSubmit()) {
                            $content->setFormId($this->html->getId());
                            $content->setFormAction($this->html->getAttribute('action'));
                            $content->setFormMethod('post');
                        }
                    }

                    $builder->setControl($content);
                    $builder->setDisplayMode($this->display_mode, $this->grid_size, $this->label_width);

                    // Build control
                    $html .= $builder->build();

                    break;

                case 'collection':

                    /* @var $builder \Core\Html\FormDesigner\ControlBuilder */
                    $builder = $this->di->instance(__NAMESPACE__ . '\ControlBuilder');

                    foreach ($content->getControls() as $control) {

                        if ($control instanceof AbstractForm) {
                            $builder->setControl($control);
                            $content->addInner($builder->build());
                        }
                        else {
                            $content->addInner($control->build());
                        }
                    }

                    $content->clearControls();

                    $html .= $content->build();

                    break;

                case 'factory':
                    $html .= $content->build();
                    break;

                case 'html':
                    $html .= $content;
                    break;

                case 'group':
                    $html .= $this->buildGroup($content, $names, $group_data, $group_errors);
                    break;
            }
        }

        return $group->html->addInner($html)->build();
    }
}

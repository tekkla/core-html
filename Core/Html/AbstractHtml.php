<?php
namespace Core\Html;

use Core\Toolbox\Arrays\IsAssoc;

/**
 * AbstractHtml.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
abstract class AbstractHtml implements HtmlBuildableInterface
{

    /**
     * Element type
     *
     * @var string
     */
    protected $element;

    /**
     * Attribute: name
     *
     * @var string
     */
    protected $name = '';

    /**
     * Attribute: id
     *
     * @var string
     */
    protected $id = '';

    /**
     * Attribute: class
     *
     * @var array
     */
    protected $css = [];

    /**
     * Attribute: style
     *
     * @var array
     */
    protected $style = [];

    /**
     * Events
     *
     * @var array
     */
    protected $event = [];

    /**
     * Custom html attributes
     *
     * @var array
     */
    protected $attribute = [];

    /**
     * Data attributes
     *
     * @var array
     */
    protected $data = [];

    /**
     * Aria attributes
     *
     * @var array
     */
    protected $aria = [];

    /**
     * Inner HTML of element
     *
     * @var string
     */
    protected $inner = '';

    /**
     *
     * @var HtmlFactory
     */
    public $factory;

    /**
     * Sets the element type like 'div', 'input', 'p' etc
     *
     * @param string $element
     */
    public function setElement(string $element)
    {
        $this->element = $element;
    }

    /**
     * Returns element type
     *
     * @return string
     */
    public function getElement(): string
    {
        return $this->element;
    }

    /**
     * Sets the element name
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Removes element name
     */
    public function removeName()
    {
        $this->name = '';
    }

    /**
     * Returns name if set.
     * No name set it returns boolean false.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the id of the element
     *
     * @param string $id
     *
     *
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * Returns the id of the element
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Removes id from elements
     */
    public function removeId()
    {
        $this->id = '';
    }

    /**
     * Sets inner value of element like
     *
     * <code>
     * &lt;div&gt;{inner}&lt;/div&gt;
     * </code>
     *
     * @param string $inner
     */
    public function setInner(string $inner)
    {
        $this->inner = $inner;
    }

    /**
     * Adds content to existing inner conntent
     *
     * @param string $content
     */
    public function addInner(string $content)
    {
        $this->inner .= $content;
    }

    /**
     * Returns inner value
     *
     * @return string
     */
    public function getInner(): string
    {
        return $this->inner;
    }

    /**
     * Sets html title attribute
     *
     * Tries to load string from txt storage when argument begins with "txt-".
     *
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->attribute['title'] = $title;
    }

    /**
     * Sets tabindex attribute
     *
     * @param int $tabindex
     */
    public function setTabindex(int $tabindex)
    {
        $this->attribute['tabindex'] = $tabindex;
    }

    /**
     * Add one or more css classes to the html object.
     * Accepts single value, a string of space separated classnames or an array of classnames.
     *
     * @param string|array $css
     */
    public function addCss($css)
    {
        if (!is_array($css)) {

            // Clean css argument from unnecessary spaces
            $css = preg_replace('/[ ]+/', ' ', $css);

            // Do not trust the programmer and convert a possible
            // string of multiple css class notations to array
            $css = explode(' ', $css);
        }

        foreach ($css as $class) {
            $this->css[$class] = $class;
        }
    }

    /**
     * Checks for the existance of a css property in a html object or for a css class / array of css classes in the css
     * property
     *
     * @param string|array $check
     *            Optional parameter can be a single css class as string or a list of classes in an array
     *
     * @return bool
     */
    public function checkCss($check = null): bool
    {
        // Css (could be array) and objects css property set?
        if (isset($check) && $this->css) {

            // convert non array css to array
            if (!is_array($check)) {
                $check = (array) $check;
            }

            // Is css to check already in objects css array?
            $check = array_intersect($check, $this->css) ? true : false;
        }
        else {
            // Without set css param we only check if css is used
            $check = $this->css ? true : false;
        }

        return $check;
    }

    /**
     * Returns set css values
     *
     * Returns boolean false if css is empty.
     *
     * @return array
     */
    public function getCss(): array
    {
        return $this->css;
    }

    /**
     * Adds a single style or an array of styles to the element.
     * Although no parameters are visible the method handles two different
     * types of parameter. Set two params for "key" and "value" or an array
     * with a collection of keys and values.
     */
    public function addStyle()
    {
        $this->addTo('style', func_get_args());
    }

    /**
     * Removes a style from the styles collection
     *
     * @param string $style
     *
     *
     */
    public function removeStyle(string $style)
    {
        unset($this->style[$style]);
    }

    /**
     * Adds a single event or an array of events to the element
     *
     * Although no parameters are visible the method handles two different
     * types of parameter. Set two params for "key" and "value" or an array
     * with a collection of keys and values.
     */
    public function addEvent()
    {
        $this->addTo('event', func_get_args());
    }

    /**
     * Sets role attribute
     *
     * @param string $role
     */
    public function setRole(string $role)
    {
        $this->attribute['role'] = $role;
    }

    /**
     * Returns value of set role attribute
     *
     * @return string
     */
    public function getRole(): string
    {
        return $this->attribute['role'] ?? '';
    }

    /**
     * Adds a single style or an array of styles to the element.
     * Although no parameters are visible the method handles two different
     * types of parameter. Set two params for "key" and "value" or an array
     * with a collection of keys and values.
     * This method takes care of single attributes like "selected" or "disabled".
     */
    public function addAttribute()
    {
        $this->addTo('attribute', func_get_args());
    }

    /**
     * Removes an attribute
     *
     * @param string $attribute
     */
    public function removeAttribute(string $attribute)
    {
        unset($this->attribute[$attribute]);
    }

    /**
     * Returns the requests attributes value.
     *
     * @param string $attribute
     *
     * @throws HtmlException
     *
     * @return string
     */
    public function getAttribute(string $attribute): string
    {
        if (!isset($this->attribute[$attribute])) {
            Throw new HtmlException(sprintf('The requested attribute "%s" does not exits in this html element "%s".', $attribute, get_called_class()));
        }

        return $this->attribute[$attribute];
    }

    /**
     * Check for an set attribute
     *
     * @param string $attribute
     *
     * @return boolean
     */
    public function checkAttribute(string $attribute): bool
    {
        return isset($this->attribute[$attribute]);
    }

    /**
     * Adds a single data attribute or an array of data attributes to the element.
     *
     * Although no parameters are visible the method handles two different
     * types of parameter. Set two params for "key" and "value" or an array
     * with a collection of keys and values.
     */
    public function addData()
    {
        $this->addTo('data', func_get_args());
    }

    /**
     * Returns the value of the requested data attribute
     *
     * Returns empty string when no matching data attribute can be found.
     *
     * @param string $data
     *
     * @return string
     */
    public function getData(string $data): string
    {
        return $this->data[$data] ?? '';
    }

    /**
     * Checks the existance of a data attribute
     *
     * @param string $data
     *
     * @return boolean
     */
    public function checkData(string $data): bool
    {
        return isset($this->data[$data]);
    }

    /**
     * Removes a data attribute
     *
     * @param string $data
     */
    public function removeData(string $data)
    {
        unset($this->data[$data]);
    }

    /**
     * Adds a single aria attribute or an array of aria attributes to the element
     *
     * Although no parameters are visible the method handles two different
     * types of parameter. Set two params for "key" and "value" or an array
     * with a collection of keys and values.
     */
    public function addAria()
    {
        $this->addTo('aria', func_get_args());
    }

    /**
     * Returns the value of the requested aria attribute.
     *
     * Returns empty string when no matching attribute can be found.
     *
     * @param string $aria
     *
     * @return string
     */
    public function getAria(string $aria): string
    {
        return $this->aria[$aria] ?? '';
    }

    /**
     * Checks the existance of a aria attribute
     *
     * @param string $aria
     *
     * @return bool
     */
    public function checkAria(string $aria): bool
    {
        return isset($this->aria[$aria]);
    }

    /**
     * Removes a aria ttribute
     *
     * @param string $aria
     *
     *
     */
    public function removeAria(string $aria)
    {
        unset($this->aria[$aria]);
    }

    /**
     * Adds single and multiple elements to properties
     *
     * @param string $func
     *            Name of the attribute eg property the arguments ($args)have to be added
     * @param mixed $args
     */
    private function addTo(string $func, $args)
    {
        // Only already existing attributes can get filled with the args
        if (!isset($this->{$func})) {
            Throw new HtmlException(sprintf('Type "%s" is not allowed as html property/attribute', $func));
        }

        // Do we have one argument or two?
        if (count($args) == 1) {

            // One argument and not an array means we have one single value to add
            // This is when you set attributes without values like selected, disabled etc.
            if (!is_array($args[0])) {
                $this->{$func}[$args[0]] = false;
            }
            else {
                // Check the arguments for assoc array and add arguments according to the
                // result of check as key, val or only as val
                $array = new IsAssoc($args[0]);

                if ($array->isAssoc()) {
                    foreach ($args[0] as $key => $val) {
                        $this->{$func}[$key] = $val;
                    }
                }
                else {
                    foreach ($args[0] as $val) {
                        $this->{$func}[$val] = false;
                    }
                }
            }
        }
        else {
            $this->{$func}[$args[0]] = $args[1];
        }
    }

    /**
     * Hidden attribute setter and checker
     *
     * Accepts parameter "null", "0" and "1".
     * "null" eg no parameter means to check for a set hidden attribute
     * "0" means to remove hidden attribute
     * "1" means to set hidden attribute
     *
     * @param int $state
     */
    public function isHidden(int $state = null)
    {
        $attrib = 'hidden';

        if (empty($state)) {
            return $this->checkAttribute($attrib);
        }

        if ($state == 0) {
            $this->removeAttribute($attrib);
        }
        else {
            $this->addAttribute($attrib);
        }
    }

    /**
     * Builds and returns the html code created out of all set attributes and their values
     *
     * @return string
     */
    public function build(): string
    {
        $html_attr = [];

        if (!$this->element) {
            $this->element = strtolower((new \ReflectionClass($this))->getShortName());
        }

        if (!empty($this->id)) {
            $html_attr['id'] = $this->id;
        }

        if (!empty($this->name)) {
            $html_attr['name'] = $this->name;
        }

        if ($this->css) {
            $this->css = array_unique($this->css);
            $html_attr['class'] = implode(' ', $this->css);
        }

        if ($this->style) {

            $styles = [];

            foreach ($this->style as $name => $val) {
                $styles[] = $name . ': ' . $val;
            }

            $html_attr['style'] = implode('; ', $styles);
        }

        if ($this->event) {
            foreach ($this->event as $event => $val) {
                $html_attr[$event] = $val;
            }
        }

        if ($this->data) {
            foreach ($this->data as $attr => $val) {
                $html_attr['data-' . $attr] = $val;
            }
        }

        if ($this->aria) {
            foreach ($this->aria as $attr => $val) {
                $html_attr['aria-' . $attr] = $val;
            }
        }

        if ($this->attribute) {
            foreach ($this->attribute as $attr => $val) {
                $html_attr[$attr] = $val;
            }
        }

        // we have all our attributes => build attribute string
        $tmp_attr = [];

        foreach ($html_attr as $name => $val) {
            $tmp_attr[] = $val === false ? $name : $name . (strpos($name, 'data') === false ? '="' . $val . '"' : '=\'' . $val . '\'');
        }

        $html_attr = implode(' ', $tmp_attr);

        // html attribute string has been created, lets build the element
        switch ($this->element) {

            case 'input':
            case 'meta':
            case 'img':
            case 'link':
                $html = '<' . $this->element . ($html_attr ? ' ' . $html_attr : '') . '>';
                break;

            default:
                $html = '<' . $this->element . ($html_attr ? ' ' . $html_attr : '') . '>' . $this->inner . '</' . $this->element . '>';
                break;
        }

        return $html;
    }
}

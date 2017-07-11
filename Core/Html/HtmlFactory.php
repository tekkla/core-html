<?php
namespace Core\Html;

use Core\Toolbox\Arrays\IsAssoc;

/**
 * HtmlFactory.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class HtmlFactory
{

    /**
     * Creates an html control / element / form element by using DI container instance method
     *
     * Injects an instance of the HtmlFactory so the created html object can use it to create sub elements if needed.
     *
     * @param string $class
     *            Short NS to used class like 'Elements\Div' or 'Form\Input' or 'Bootstrap\Button\Button'.
     * @param array $args
     *            Optional assoc arguments array to be used as $html->$method($value) call.
     *
     * @throws HtmlException
     *
     * @return AbstractHtml
     */
    public function create(string $class, array $args = [])
    {
        $class = __NAMESPACE__ . '\\' . $class;

        $html = new $class();

        $html->factory = $this;

        foreach ($args as $method => $arg) {

            if (! method_exists($html, $method)) {
                Throw new HtmlException('Html object has no "' . $method . '" method.');
            }

            if (is_array($arg)) {

                $array = new IsAssoc($arg);

                if (!$array->isAssoc()) {
                    Throw new HtmlException('Arrayed arguments for html objects created by HtmlFactory have to be associative.');
                }

                foreach ($arg as $attr => $val) {
                    $html->{$method}($attr, $val);
                }
            }
            else {
                $html->{$method}($arg);
            }
        }

        return $html;
    }
}

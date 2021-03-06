<?php
namespace Core\Html\Form;

use Core\Html\Form\Traits\IsMultipleTrait;
use Core\Html\Form\Traits\SizeTrait;
use Core\Html\Form\Traits\ValueTrait;

/**
 * Select.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Select extends AbstractForm
{
    use IsMultipleTrait;
    use SizeTrait;
    use ValueTrait;

    private $options = [];

    protected $element = 'select';

    protected $data = [
        'control' => 'select'
    ];

    protected $value = [];

    /**
     * Creates an Option object and returns it
     *
     * @return Option
     */
    public function &createOption($optgroup = ''): Option
    {
        $option = $this->factory->create('Form\Option');

        $this->addOption($option, $optgroup);

        return $option;
    }

    /**
     * Add an Option object to the options array
     *
     * Use parameters to predefine the objects settings.
     * If inner parameter is not set, the value is the inner
     * content of option and has no value attribute.
     *
     * @param string|int $value
     *            Option value
     * @param
     *            string|int Optional $inner
     *            Option inner content
     * @param bool $selected
     *            Selected flag
     * @param string $optgroup
     *            Related optgroup
     *
     * @return Option
     */
    public function &newOption($value = null, $inner = null, bool $selected = false, string $optgroup = ''): Option
    {
        /* @var $option \Core\Html\Form\Option */
        $option = $this->factory->create('Form\Option');

        if (isset($value)) {
            $option->setValue($value);
        }

        if (isset($inner)) {
            $option->setInner($inner);
        }

        if ($selected == true) {
            $option->isSelected();
        }

        $this->addOption($option, $optgroup);

        return $option;
    }

    /**
     * Add an html option object to the optionlist
     *
     * @param Option $option
     * @param string $optgroup
     *            Related optgroup
     *
     * @return Select
     */
    public function addOption(Option $option, string $optgroup = ''): Select
    {
        if (empty($optgroup)) {
            $this->options[] = $option;
        }
        else {
            $this->options[$optgroup][] = $option;
        }

        return $this;
    }

    /**
     * Counts and returns the number of options
     *
     * @return int
     */
    public function countOptions(): int
    {
        return count($this->options);
    }

    /**
     * Builds otion element
     *
     * @param Option $option
     *
     * @return string
     */
    private function buildOption(Option $option): string
    {

        // Select unselected options when the options value is in selects value array
        if (!$option->getSelected() && in_array($option->getValue(), $this->value)) {
            $option->isSelected();
        }

        return $option->build();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Core\Html\AbstractHtml::build()
     */
    public function build()
    {
        foreach ($this->options as $key => $option) {

            if (is_array($option)) {
                $this->inner .= '<optgroup label="' . $key . '">';

                foreach ($option as $opt) {
                    $this->inner .= $this->buildOption($opt);
                }

                $this->inner .= '</optgroup>';
            }
            else {
                $this->inner .= $this->buildOption($option);
            }
        }

        if ($this->getMultiple()) {
            $this->setName($this->getName() . '[]');
        }

        return parent::build();
    }
}

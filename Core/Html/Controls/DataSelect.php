<?php
namespace Core\Html\Controls;

use Core\Html\Form\Select;

/**
 * DataSelect.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class DataSelect extends Select
{

    /**
     * The data from which the options of the select will be created
     *
     * @var array
     */
    protected $datasource;

    /**
     * How to use the data in the selects option
     *
     * @var string
     */
    protected $datatype;

    /**
     * The value which should causes an option to be selected.
     * Can be a value or an array of values
     *
     * @var mixed
     */
    protected $selected;

    /**
     * Flag to use index of datasource as options value
     *
     * @var bool
     */
    protected $index_is_value = true;

    /**
     * Flags control to use the index of datasource as value for options value content
     *
     * @param bool $index_is_value
     */
    public function setIndexIsValue(bool $index_is_value)
    {
        $this->index_is_value = $index_is_value;
    }

    /**
     * Sets a datasource
     *
     * @param array $datasource
     *            Array with data
     *
     * @return \Core\Html\Controls\DataSelect
     */
    public function setDataSource(array $datasource)
    {
        $this->datasource = $datasource;

        return $this;
    }

    /**
     * Set one or more values to set as selected
     *
     * @param
     *            int|string|array
     *
     * @return \Core\Html\Controls\DataSelect
     */
    public function setSelectedValue($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * Builds and returns html code
     *
     * @see \Core\Html\Form\Select::build()
     */
    public function build()
    {
        foreach ($this->datasource as $index => $val) {

            $option = $this->createOption();

            // inner will always be used
            $option->setInner($val);
            $option->setValue($this->index_is_value ? $index : $val);

            // in dependence of the data type is value to be selected $val or $inner
            if (!empty($this->selected)) {
                // A list of selected?
                if (is_array($this->selected)) {
                    if (array_search(($this->index_is_value ? $index : $val), $this->selected)) {
                        $option->isSelected(1);
                    }
                } // Or a value to look for?
                else {
                    if ($this->selected == ($this->index_is_value ? $index : $val)) {
                        $option->isSelected(1);
                    }
                }
            }
        }

        return parent::build();
    }
}

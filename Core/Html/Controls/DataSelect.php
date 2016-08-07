<?php
namespace Core\Html\Controls;

use Core\Html\Form\Select;
use Core\Toolbox\Arrays\IsAssoc;

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
     * Sets a datasource
     *
     * @praram array $datasource Array with data
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
     * @param int|string|array
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
        $array = new IsAssoc($this->datasource);
        $ds_is_assoc = $array->isAssoc();


        foreach ($this->datasource as $row) {

            $option = $this->createOption();

            // inner will always be used
            $option->setInner($row[1]);

            // if we have an assoc datasource we use the value attribute
            if ($ds_is_assoc) {
                $option->setValue($row[0]);
            }

            // in dependence of the data type is value to be selected $val or $inner
            if (isset($this->selected)) {
                // A list of selected?
                if (is_array($this->selected)) {
                    if (array_search(($ds_is_assoc ? $row[0] : $row[1]), $this->selected)) {
                        $option->isSelected(1);
                    }
                } // Or a value to look for?
                else {
                    if ($this->selected == ($ds_is_assoc ? $row[0] : $row[1])) {
                        $option->isSelected(1);
                    }
                }
            }
        }

        return parent::build();
    }
}

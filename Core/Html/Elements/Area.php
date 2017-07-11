<?php
namespace Core\Html\Elements;

/**
 * Area.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Area extends Link
{

    protected $element = 'area';

    /**
     * Sets the coordinates of the area
     *
     * @param string $cords
     *
     * @return Area
     */
    public function setCoords(string $cords)
    {
        $this->attribute['coords'] = $cords;

        return $this;
    }

    /**
     * Sets the shape of the area
     *
     * @param string $shape
     *            Allowed shapes: 'default', 'rect', 'circle' or 'poly'
     *
     * @throws ElementException
     *
     * @return Area
     */
    public function setShape(string $shape)
    {
        $shapes = array(
            'default',
            'rect',
            'circle',
            'poly'
        );

        if (!in_array($shape, $shapes)) {
            Throw new ElementException('Set shape is not valid.');
        }

        $this->attribute['shape'] = $shape;

        return $this;
    }
}

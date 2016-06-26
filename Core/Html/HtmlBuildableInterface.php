<?php
namespace Core\Html;

/**
 * HtmlBuildableInterface.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
interface HtmlBuildableInterface
{

    /**
     * Builds control and returns the created html code
     */
    public function build();
}

<?php
namespace Core\Html\Controls\Editbox;

use Core\Html\HtmlException;

/**
 * EditboxException.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class EditboxException extends HtmlException
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Error\CoreExceptionInterface::getCleanBuffer()
     *
     */
    public function getCleanBuffer()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Error\CoreExceptionInterface::getErrorLog()
     *
     */
    public function getErrorLog()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Error\CoreExceptionInterface::getSendMail()
     *
     */
    public function getSendMail()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Error\CoreExceptionInterface::getFatal()
     *
     */
    public function getFatal()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Error\CoreExceptionInterface::getToDb()
     *
     */
    public function getToDb()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Error\CoreExceptionInterface::getPublic()
     *
     */
    public function getPublic()
    {}
}

?>
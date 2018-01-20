<?php
namespace Core\Html\Bootstrap\V3;

/**
 * BootstrapContextInterface.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
interface BootstrapContextInterface
{

    const PRIMARY = 'primary';

    const SUCCESS = 'success';

    const INFO = 'info';

    const WARNING = 'warning';

    const DANGER = 'danger';

    /**
     * Sets Bootstrap color context
     *
     * @param string $context
     *            Bootstrap contextual color like primary, success, info, warning or danger
     */
    public function setContext(string $context);

    /**
     * Returns set Bootstrab contextual color
     *
     * @return string
     */
    public function getContext(): string;
}

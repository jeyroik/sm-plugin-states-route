<?php
namespace tratabor\interfaces\systems\states\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStatesRoute;

/**
 * Interface IPluginRouteTo
 *
 * @package tratabor\interfaces\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginRouteTo extends IPlugin
{
    /**
     * @param IStatesRoute $route
     * @param $toStateId
     *
     * @return string
     */
    public function __invoke(IStatesRoute &$route, $toStateId);
}

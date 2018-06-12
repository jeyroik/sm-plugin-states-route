<?php
namespace tratabor\interfaces\systems\states\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStatesRoute;

/**
 * Interface IPluginRouteFrom
 *
 * @package tratabor\interfaces\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginRouteFrom extends IPlugin
{
    /**
     * @param IStatesRoute $route
     * @param $fromStateId
     *
     * @return string
     */
    public function __invoke(IStatesRoute &$route, $fromStateId);
}

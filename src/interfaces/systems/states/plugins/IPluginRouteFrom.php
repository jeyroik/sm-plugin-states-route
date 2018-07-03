<?php
namespace jeyroik\extas\interfaces\systems\states\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\extensions\IStatesRoute;

/**
 * Interface IPluginRouteFrom
 *
 * @package jeyroik\extas\interfaces\systems\states\plugins
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

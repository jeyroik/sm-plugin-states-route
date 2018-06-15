<?php
namespace jeyroik\extas\interfaces\systems\states\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStatesRoute;

/**
 * Interface IPluginRouteTo
 *
 * @package jeyroik\extas\interfaces\systems\states\plugins
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

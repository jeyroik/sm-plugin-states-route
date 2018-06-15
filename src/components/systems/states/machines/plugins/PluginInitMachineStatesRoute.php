<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\states\StatesRoute;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\IStatesRoute;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginInitStateMachine;

/**
 * Class PluginInitMachineStatesRoute
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginInitMachineStatesRoute extends Plugin implements IPluginInitStateMachine
{
    const ROUTE__CONFIG = 'states_route__config';

    /**
     * @param IStateMachine $machine
     *
     * @return void
     */
    public function __invoke(IStateMachine &$machine)
    {
        $machineConfig = $machine->getConfig();
        $routeConfig = $machineConfig[static::ROUTE__CONFIG];

        $machine->registerInterface(IStatesRoute::class, new StatesRoute($routeConfig));
    }
}

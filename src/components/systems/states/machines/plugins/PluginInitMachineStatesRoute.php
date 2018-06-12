<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\components\systems\Plugin;
use tratabor\components\systems\states\StatesRoute;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\IStatesRoute;
use tratabor\interfaces\systems\states\machines\plugins\IPluginInitStateMachine;

/**
 * Class PluginInitMachineStatesRoute
 *
 * @package tratabor\components\systems\states\machines\plugins
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

<?php
namespace tratabor\components\systems\states\plugins;

use tratabor\components\systems\Plugin;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\IStatesRoute;
use tratabor\interfaces\systems\states\machines\plugins\IPluginBeforeStateBuild;


/**
 * Class PluginBeforeStateBuildStatesRoute
 *
 * @package tratabor\components\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeStateBuildStatesRoute extends Plugin implements IPluginBeforeStateBuild
{
    /**
     * @param IStateMachine $machine
     * @param array $stateConfig
     * @param $fromStateId
     * @param $stateId
     *
     * @return array
     */
    public function __invoke(IStateMachine &$machine, $stateConfig, $fromStateId, $stateId)
    {
        if ($machine->isImplementsInterface(IStatesRoute::class)) {
            /**
             * @var $machine IStatesRoute
             */
            $machine->from($fromStateId)->to($stateId);
        }

        return [$stateConfig, $fromStateId, $stateId];
    }
}

<?php
namespace jeyroik\extas\components\systems\states\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\extensions\IStatesRoute;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginStateBuildBefore;


/**
 * Class PluginBeforeStateBuildStatesRoute
 *
 * @package jeyroik\extas\components\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStateBuildBeforeStatesRoute extends Plugin implements IPluginStateBuildBefore
{
    public $preDefinedStage = IStateMachine::STAGE__STATE_BUILD_BEFORE;

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
            $machine->from($fromStateId);
            $machine->to($stateId);
        }

        return [$stateConfig, $fromStateId, $stateId];
    }
}

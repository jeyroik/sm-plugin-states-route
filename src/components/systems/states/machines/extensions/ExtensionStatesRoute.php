<?php
namespace jeyroik\extas\components\systems\states\machines\extensions;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\components\systems\extensions\TExtendable;
use jeyroik\extas\interfaces\systems\states\machines\extensions\IStatesRoute;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Class StatesRoute
 *
 * @package jeyroik\extas\components\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
class ExtensionStatesRoute extends Extension implements IStatesRoute
{
    use TExtendable;

    /**
     * @var array
     */
    protected $config = [];
    protected $route = [];
    protected $currentFrom = '';
    protected $currentTo = '';

    public $subject = IStateMachine::SUBJECT;
    public $methods = [
        'from' => IStatesRoute::class,
        'to' => IStatesRoute::class,
        'getRoute' => IStatesRoute::class,
        'setRoute' => IStatesRoute::class,
        'getCurrentFrom' => IStatesRoute::class,
        'getCurrentTo' => IStatesRoute::class
    ];

    /**
     * @param $stateId
     * @param $machine
     *
     * @return IStatesRoute
     */
    public function from($stateId, IStateMachine $machine = null): IStatesRoute
    {
        $this->extractFromMachine($machine);

        if (!isset($this->route[$stateId])) {
            $this->route[$stateId] = [];
        }

        foreach ($this->getPluginsByStage(static::STAGE__FROM) as $plugin) {
            $stateId = $plugin($this, $stateId);
        }

        $this->currentFrom = $stateId;
        $this->packToMachine($machine);

        return $this;
    }

    /**
     * @param $stateId
     * @param $machine
     *
     * @return IStatesRoute
     */
    public function to($stateId, IStateMachine $machine = null): IStatesRoute
    {
        $this->extractFromMachine($machine);

        foreach ($this->getPluginsByStage(static::STAGE__TO) as $plugin) {
            $stateId = $plugin($this, $stateId);
        }

        $this->route[$this->currentFrom][] = $stateId;
        $this->currentTo = $stateId;

        $this->packToMachine($machine);

        return $this;
    }

    /**
     * @param $machine
     *
     * @return array
     */
    public function getRoute(IStateMachine $machine = null)
    {
        return $this->route;
    }

    /**
     * @param array|IStatesRoute $route
     * @param $machine
     *
     * @return $this
     * @throws \Exception
     */
    public function setRoute($route, IStateMachine $machine = null)
    {
        if (is_array($route)) {
            $this->route = $route;
        } elseif (is_object($route) && ($route instanceof IStatesRoute)) {
            $this->route = $route->getRoute();
        } else {
            throw new \Exception('Unsupported route type "' . gettype($route) . '".');
        }

        $this->packToMachine($machine);

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentFrom(): string
    {
        return $this->currentFrom;
    }

    /**
     * @return string
     */
    public function getCurrentTo()
    {
        return $this->currentTo;
    }

    /**
     * @param IStateMachine $machine
     *
     * @return $this
     */
    protected function extractFromMachine(IStateMachine &$machine)
    {
        if (!isset($machine[IStatesRoute::class])) {
            $machine[IStatesRoute::class] = [
                static::FIELD__ROUTE => [],
                static::FIELD__CURRENT_FROM => '',
                static::FIELD__CURRENT_TO => null
            ];
        }

        $this->route = $machine[IStatesRoute::class][static::FIELD__ROUTE];
        $this->currentFrom = $machine[IStatesRoute::class][static::FIELD__CURRENT_FROM];
        $this->currentTo = $machine[IStatesRoute::class][static::FIELD__CURRENT_TO];

        return $this;
    }

    /**
     * @param IStateMachine $machine
     *
     * @return $this
     */
    protected function packToMachine(IStateMachine &$machine)
    {
        $machine[IStatesRoute::class] = [
            static::FIELD__ROUTE => $this->route,
            static::FIELD__CURRENT_FROM => $this->currentFrom,
            static::FIELD__CURRENT_TO => $this->currentTo
        ];

        return $this;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return IStatesRoute::SUBJECT;
    }
}

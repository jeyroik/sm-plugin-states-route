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

        if (!isset($this[static::FIELD__ROUTE][$stateId])) {
            $this[static::FIELD__ROUTE][$stateId] = [];
        }

        foreach ($this->getPluginsByStage(static::STAGE__FROM) as $plugin) {
            $stateId = $plugin($this, $stateId);
        }

        $this[static::FIELD__CURRENT_FROM] = $stateId;
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

        $this[static::FIELD__ROUTE][$this[static::FIELD__CURRENT_FROM]][] = $stateId;
        $this[static::FIELD__CURRENT_TO] = $stateId;

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
        $this->extractFromMachine($machine);

        return $this[static::FIELD__ROUTE];
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
            $this[static::FIELD__ROUTE] = $route;
        } elseif (is_object($route) && ($route instanceof IStatesRoute)) {
            $this[static::FIELD__ROUTE] = $route[static::FIELD__ROUTE];
        } else {
            throw new \Exception('Unsupported route type "' . gettype($route) . '".');
        }

        $this->packToMachine($machine);

        return $this;
    }

    /**
     * @param $machine
     *
     * @return string
     */
    public function getCurrentFrom(IStateMachine $machine = null): string
    {
        $this->extractFromMachine($machine);

        return $this[static::FIELD__CURRENT_FROM];
    }

    /**
     * @return string
     */
    public function getCurrentTo()
    {
        $this->extractFromMachine($machine);

        return $this[static::FIELD__CURRENT_TO];
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

        $this[static::FIELD__ROUTE] = $machine[IStatesRoute::class][static::FIELD__ROUTE];
        $this[static::FIELD__CURRENT_FROM] = $machine[IStatesRoute::class][static::FIELD__CURRENT_FROM];
        $this[static::FIELD__CURRENT_TO] = $machine[IStatesRoute::class][static::FIELD__CURRENT_TO];

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
            static::FIELD__ROUTE => $this[static::FIELD__ROUTE],
            static::FIELD__CURRENT_FROM => $this[static::FIELD__CURRENT_FROM],
            static::FIELD__CURRENT_TO => $this[static::FIELD__CURRENT_TO]
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

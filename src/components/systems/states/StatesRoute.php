<?php
namespace tratabor\components\systems\states;

use tratabor\components\systems\Extension;
use tratabor\components\systems\extensions\TExtendable;
use tratabor\components\systems\plugins\TPluginAcceptable;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\plugins\IPluginRepository;
use tratabor\interfaces\systems\states\IStatesRoute;

/**
 * Class StatesRoute
 *
 * @package tratabor\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StatesRoute extends Extension implements IStatesRoute
{
    use TPluginAcceptable;
    use TExtendable;

    /**
     * @var array
     */
    protected $config = [];
    protected $route = [];
    protected $currentFrom = '';
    protected $currentTo = '';

    /**
     * StatesRoute constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->setConfig($config);
    }

    /**
     * @param $stateId
     *
     * @return IStatesRoute
     */
    public function from($stateId): IStatesRoute
    {
        if (!isset($this->route[$stateId])) {
            $this->route[$stateId] = [];
        }

        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        foreach ($pluginRepo::getPluginsForStage(static::class, static::STAGE__FROM) as $plugin) {
            $stateId = $plugin($this, $stateId);
        }

        $this->currentFrom = $stateId;

        return $this;
    }

    /**
     * @param $stateId
     *
     * @return IStatesRoute
     */
    public function to($stateId): IStatesRoute
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        foreach ($pluginRepo::getPluginsForStage(static::class, static::STAGE__TO) as $plugin) {
            $stateId = $plugin($this, $stateId);
        }

        $this->route[$this->currentFrom][] = $stateId;
        $this->currentTo = $stateId;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param array|IStatesRoute $route
     *
     * @return $this
     * @throws \Exception
     */
    public function setRoute($route)
    {
        if (is_array($route)) {
            $this->route = $route;
        } elseif (is_object($route) && ($route instanceof IStatesRoute)) {
            $this->route = $route->getRoute();
        } else {
            throw new \Exception('Unsupported route type "' . gettype($route) . '".');
        }

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
     * @param $config
     */
    protected function setConfig($config)
    {
        if ($config) {
            $this->config = $config;
            $this->registerPlugins($config);
        }
    }
}

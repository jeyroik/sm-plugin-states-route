<?php
namespace tratabor\interfaces\systems\states;

use tratabor\interfaces\systems\IExtendable;
use tratabor\interfaces\systems\IExtension;
use tratabor\interfaces\systems\IPluginsAcceptable;

/**
 * Interface IStatesRoute
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStatesRoute extends IExtension, IPluginsAcceptable, IExtendable
{
    const STAGE__FROM = 'from';
    const STAGE__TO = 'to';

    /**
     * @param $stateId
     *
     * @return IStatesRoute
     */
    public function from($stateId): IStatesRoute;

    /**
     * @param $stateId
     *
     * @return IStatesRoute
     */
    public function to($stateId): IStatesRoute;

    /**
     * @return string
     */
    public function getCurrentFrom(): string;

    /**
     * @return mixed
     */
    public function getCurrentTo();

    /**
     * @return array
     */
    public function getRoute();

    /**
     * @param array|IStatesRoute $route
     *
     * @return IStatesRoute
     */
    public function setRoute($route);
}

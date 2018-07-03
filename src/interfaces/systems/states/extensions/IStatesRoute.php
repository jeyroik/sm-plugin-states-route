<?php
namespace jeyroik\extas\interfaces\systems\states\extensions;

use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\IExtension;
use jeyroik\extas\interfaces\systems\IPluginsAcceptable;

/**
 * Interface IStatesRoute
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStatesRoute extends IExtension
{
    const STAGE__FROM = 'route.from';
    const STAGE__TO = 'route.to';

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

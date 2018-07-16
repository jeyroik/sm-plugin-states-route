<?php
namespace jeyroik\extas\interfaces\systems\states\machines\extensions;

use jeyroik\extas\interfaces\systems\IExtension;

/**
 * Interface IStatesRoute
 *
 * @stage.name route.from
 * @stage.description from state name on state transaction
 * @stage.input string $stateId
 * @stage.output string $stateId
 *
 * @stage.name route.to
 * @stage.description to state name on state transaction
 * @stage.input mixed $stateId
 * @stage.output mixed $stateId
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStatesRoute extends IExtension
{
    const SUBJECT = 'states.route';

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
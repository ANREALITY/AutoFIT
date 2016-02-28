<?php
namespace DbSystel\Hydrator\Strategy\Entity;

use Zend\Hydrator\Strategy\StrategyInterface;
use Zend\Hydrator\HydratorInterface;

class GenericEntityStrategy implements StrategyInterface
{

    /**
     * HydratorInterface
     */
    private $hydrator;

    /**
     * object
     */
    private $prototype;

    public function __construct(HydratorInterface $hydrator, $prototype)
    {
        $this->setHydrator($hydrator);
        $this->setPrototype($prototype);
    }

    /**
     *
     * @return the $hydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     *
     * @param HydratorInterface $hydrator            
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     *
     * @return the $prototype
     */
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     *
     * @param object $prototype            
     */
    public function setPrototype($prototype)
    {
        $this->prototype = $prototype;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\Hydrator\Strategy\StrategyInterface::extract()
     */
    public function extract($object)
    {
        return $this->hydrator->extract($object);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\Hydrator\Strategy\StrategyInterface::hydrate()
     */
    public function hydrate($array)
    {
        return $this->hydrator->hydrate($array, $this->prototype);
    }
}

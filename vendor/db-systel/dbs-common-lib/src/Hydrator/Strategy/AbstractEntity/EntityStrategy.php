<?php
namespace DbSystel\Hydrator\Strategy\Entity;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Hydrator\Strategy\StrategyInterface;

class EntityStrategy implements StrategyInterface
{

    /**
     * HydratorInterface
     */
    private $hydrator;

    /**
     * object
     */
    private $prototype;

    public function __construct(HydratorInterface $hydrator, object $prototype)
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
     * @param object $prototype            
     */
    public function setPrototype($prototype)
    {
        $this->prototype = $prototype;
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
     * {@inheritDoc}
     *
     * @see \Zend\Hydrator\Strategy\StrategyInterface::extract()
     */
    public function extract($value)
    {
        return $this->hydrator->extract($value);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\Hydrator\Strategy\StrategyInterface::hydrate()
     */
    public function hydrate($value)
    {
        return $this->hydrator->hydrate($value, $object);
    }
}

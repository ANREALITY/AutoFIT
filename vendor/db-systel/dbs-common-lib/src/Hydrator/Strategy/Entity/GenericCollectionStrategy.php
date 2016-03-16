<?php
namespace DbSystel\Hydrator\Strategy\Entity;

use Zend\Hydrator\Strategy\StrategyInterface;
use Zend\Hydrator\HydratorInterface;

class GenericCollectionStrategy implements StrategyInterface
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
    public function extract($objects)
    {
        $collection = [];
        if (is_array($objects) || $objects instanceof \Traversable) {
            foreach ($objects as $object) {
                $prototypeClass = get_class($this->prototype);
                $collection[] = is_object($object) && $object instanceof $prototypeClass ? $this->hydrator->extract(
                    $object) : [];
            }
        }
        return $collection;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\Hydrator\Strategy\StrategyInterface::hydrate()
     */
    public function hydrate($array)
    {
        $collection = [];
        if (is_array($array)) {
            foreach ($array as $element) {
                $collection[] = is_array($element) ? $this->hydrator->hydrate($element, $this->prototype) : null;
            }
        }
        return $collection;
    }
}

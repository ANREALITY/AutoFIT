<?php
namespace Base\Hydrator\Strategy\Entity;

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
        return $this->prototype ? clone $this->prototype : null;
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
                    $object) : $object;
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
        // hack for radio buttons
        if (is_string($array)) {
            $array = [$array];
        }
        if (is_array($array)) {
            foreach ($array as $element) {
                // the variant for non-array elements
                $element = is_array($element) ? $element : [$element];
                $collection[] = $this->hydrator->hydrate($element, $this->getPrototype());
                // the original clean variant
                // $collection[] = is_array($element) ? $this->hydrator->hydrate($element, $this->getPrototype()) : $element;
            }
        }
        return $collection;
    }
}

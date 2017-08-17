<?php
namespace DbSystel\DataObject;

/**
 * Class Customer
 *
 * @package DbSystel\DataObject
 */
class Customer extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    private $id;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @param integer $id
     * @return Customer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

}
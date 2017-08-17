<?php
namespace DbSystel\DataObject;

/**
 * Class ProductType
 *
 * @package DbSystel\DataObject
 */
class ProductType extends AbstractDataObject
{

    const NAME_CD = 'cd';

    const NAME_FTGW = 'fgw';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $longName;

    /**
     * @param string $name
     * @return ProductType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $longName
     * @return ProductType
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * @return string $longName
     */
    public function getLongName()
    {
        return $this->longName;
    }

}
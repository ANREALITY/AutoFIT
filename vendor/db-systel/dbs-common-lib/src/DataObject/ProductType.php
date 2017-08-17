<?php
namespace DbSystel\DataObject;

/**
 * ProductType
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
     * @return string
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
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }

}
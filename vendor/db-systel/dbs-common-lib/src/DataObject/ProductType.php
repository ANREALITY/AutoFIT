<?php
namespace DbSystel\DataObject;

class ProductType extends AbstractDataObject
{

    const NAME_CD = 'cd';

    const NAME_FTGW = 'fgw';

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $longName;

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $longName
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;
    }

    /**
     *
     * @return string $longName
     */
    public function getLongName()
    {
        return $this->longName;
    }

}
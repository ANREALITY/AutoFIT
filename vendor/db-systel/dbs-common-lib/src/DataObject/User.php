<?php
namespace DbSystel\DataObject;

class User
{

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $msExchangeName;

    /**
     *
     * @var boolean
     */
    protected $admin;

    /**
     *
     * @var string
     */
    protected $sex;

    /**
     *
     * @var string
     */
    protected $firstname;

    /**
     *
     * @var string
     */
    protected $lastname;

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return the $msExchangeName
     */
    public function getMsExchangeName()
    {
        return $this->msExchangeName;
    }

    /**
     *
     * @param string $msExchangeName            
     */
    public function setMsExchangeName($msExchangeName)
    {
        $this->msExchangeName = $msExchangeName;
    }

    /**
     *
     * @return the $admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     *
     * @param boolean $admin            
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     *
     * @return the $sex
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     *
     * @param string $sex            
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     *
     * @return the $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     *
     * @param string $firstname            
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     *
     * @return the $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     *
     * @param string $lastname            
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
}
<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Draft
 *
 * @ORM\Table(
 *     name="draft",
 *     indexes= {
 *         @ORM\Index(name="fk_draft_user_idx", columns={"user_id"})
 *     }
 * )
 * @ORM\Entity
 */
class Draft
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="connection_type", type="string", nullable=false)
     */
    protected $connectionType;

    /**
     * @var string
     *
     * @ORM\Column(name="endpoint_source_type", type="string", nullable=false)
     */
    protected $endpointSourceType;

    /**
     * @var string
     *
     * @ORM\Column(name="endpoint_target_type", type="string", nullable=false)
     */
    protected $endpointTargetType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * @param integer $id
     *
     * @return Draft
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Draft
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set connectionType
     *
     * @param string $connectionType
     *
     * @return Draft
     */
    public function setConnectionType($connectionType)
    {
        $this->connectionType = $connectionType;
        return $this;
    }

    /**
     * Get connectionType
     *
     * @return string
     */
    public function getConnectionType()
    {
        return $this->connectionType;
    }

    /**
     * Set endpointSourceType
     *
     * @param string $endpointSourceType
     *
     * @return Draft
     */
    public function setEndpointSourceType($endpointSourceType)
    {
        $this->endpointSourceType = $endpointSourceType;
        return $this;
    }

    /**
     * Get endpointSourceType
     *
     * @return string
     */
    public function getEndpointSourceType()
    {
        return $this->endpointSourceType;
    }

    /**
     * Set endpointTargetType
     *
     * @param string $endpointTargetType
     *
     * @return Draft
     */
    public function setEndpointTargetType($endpointTargetType)
    {
        $this->endpointTargetType = $endpointTargetType;
        return $this;
    }

    /**
     * Get endpointTargetType
     *
     * @return string
     */
    public function getEndpointTargetType()
    {
        return $this->endpointTargetType;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Draft
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Draft
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Draft
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

}

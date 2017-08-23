<?php

namespace BviEmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email_template")
 * @ORM\Entity(repositoryClass="BviEmailBundle\Repository\EmailRepository")
 */
class Email
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    protected $subject;
    
    /**
     * @var string
     * @ORM\Column(name="key", type="string", length=255, nullable=false)
     */
    protected $key;
    
    /**
     * @var string
     * @ORM\Column(name="content", type="string", nullable=false)
     */
    protected $content;
    
    /**
     * @var string
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('Active','Inactive')",nullable=false) 
     */
    protected $status;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdat;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_dt", type="datetime", nullable=true)
     */
    protected $updatedat;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    protected $createdby;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    protected $updatedby;

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
     * Set Subject
     *
     * @param string $subject
     * @return Email
     */
    public function seSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return Email
     */
    public function setKey()
    {   
        
        $tmp = preg_replace('/\s\s+/', ' ', $this->subject);

        $ky = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $tmp));
        $ky = preg_replace('/\-\-+/', '-', $ky);
        $ky = rtrim($ky, '-');
        $ky = ltrim($ky, '-');
        
        $this->key = $ky;

        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Email
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
     * Set status
     *
     * @param string $status
     * @return Email
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     * @return Email
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime 
     */
    public function getCreatedat()
    {
        return $this->createdat->format('Y-m-d H:i:s');
    }

    /**
     * Set updatedat
     *
     * @param \DateTime $updatedat
     * @return Email
     */
    public function setUpdatedat($updatedat)
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    /**
     * Get updatedat
     *
     * @return \DateTime 
     */
    public function getUpdatedat()
    {
        return $this->updatedat;
    }

    /**
     * Set createdby
     *
     * @param integer $createdby
     * @return Email
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return integer 
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updatedby
     *
     * @param integer $updatedby
     * @return Email
     */
    public function setUpdatedby($updatedby)
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    /**
     * Get updatedby
     *
     * @return integer 
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }
}

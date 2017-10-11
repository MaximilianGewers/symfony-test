<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="projectx")
 */
class Projectx
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $projectName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $description;

    public function __construct()
    {
        // your own logic
    }

    public function getID()
    {
        return $this->id;
    }

    public function getProjectName()
    {
        return $this->projectName;
    }


    public function setProjectName($name)
    {
    	$this->projectName = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description)
    {
    	$this->description = $description;
    }


}
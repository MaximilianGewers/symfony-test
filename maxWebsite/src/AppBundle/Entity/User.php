<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use AppBundle\Entity\Person;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="Person_id", referencedColumnName="id")
     */
    protected $person;

    public function __construct()
    {
        parent::__construct();
    }

    public function setPerson($person)
    {
        $this->person = $person;
    }

    public function getPerson()
    {
        return $this->person;
    }



}
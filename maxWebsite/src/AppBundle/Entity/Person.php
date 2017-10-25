<?php
// src/AppBundle/Entity/Person.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="string")
     */
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }    

    public function getName()
    {
        return $this->name;
    }
    

}
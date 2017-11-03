<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonCompanyRole
 *
 * @ORM\Table(name="person_company_role")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonCompanyRoleRepository")
 */
class PersonCompanyRoleJoin
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
     * @var int
     *
     * @ORM\Column(name="person", type="integer")
     */
    private $person;

    /**
     * @var int
     *
     * @ORM\Column(name="company", type="integer")
     */
    private $company;

    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer")
     */
    private $role;


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
     * Set person
     *
     * @param integer $person
     *
     * @return PersonCompanyRole
     */
    public function setPerson($person)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return integer
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set company
     *
     * @param integer $company
     *
     * @return PersonCompanyRole
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return integer
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set role
     *
     * @param integer $role
     *
     * @return PersonCompanyRole
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return integer
     */
    public function getRole()
    {
        return $this->role;
    }
}


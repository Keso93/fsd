<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee implements BaseEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(callback="getGenders")
     * @Assert\NotBlank
     */
    private $gender;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $birthday;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @var Title[] | ArrayCollection
     * @ORM\ManyToMany(targetEntity="Title", inversedBy="employees", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="employee_title",
     *     joinColumns={
     *          @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="title_id", referencedColumnName="id")
     *     }
     * )
     * @Assert\NotBlank
     */
    private $titles;

    public function __construct()
    {
        $this->titles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    public static function getGenders()
    {
        return ['Male', 'Female'];
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active): void
    {
        $this->active = $active;
    }

    public function addTitle(Title $title): self
    {
        $this->titles[] = $title;

        return $this;
    }

    public function removeTitle(Title $title): bool
    {
        return $this->titles->removeElement($title);
    }

    /**
     * @return Collection|Title[]
     */
    public function getTitles(): Collection
    {
        return $this->titles;
    }
}

<?php

declare(strict_types=1);

namespace Doctrine\Tests\Models\Company;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Annotation as ORM;
use Doctrine\ORM\Mapping;

/**
 * @ORM\Entity
 * @ORM\Table(name="company_contracts")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\EntityListeners({CompanyContractListener::class})
 * @ORM\DiscriminatorMap({
 *     "fix"       = CompanyFixContract::class,
 *     "flexible"  = CompanyFlexContract::class,
 *     "flexultra" = CompanyFlexUltraContract::class
 * })
 *
 * @ORM\NamedNativeQueries({
 *      @ORM\NamedNativeQuery(
 *          name           = "all-contracts",
 *          resultClass    = "__CLASS__",
 *          query          = "SELECT id, completed, discr FROM company_contracts"
 *      ),
 *      @ORM\NamedNativeQuery(
 *          name           = "all",
 *          resultClass    = "__CLASS__",
 *          query          = "SELECT id, completed, discr FROM company_contracts"
 *      ),
 * })
 *
 * @ORM\SqlResultSetMappings({
 *      @ORM\SqlResultSetMapping(
 *          name    = "mapping-all-contracts",
 *          entities= {
 *              @ORM\EntityResult(
 *                  entityClass         = "__CLASS__",
 *                  discriminatorColumn = "discr",
 *                  fields              = {
 *                      @ORM\FieldResult("id"),
 *                      @ORM\FieldResult("completed"),
 *                  }
 *              )
 *          }
 *      ),
 *      @ORM\SqlResultSetMapping(
 *          name    = "mapping-all",
 *          entities= {
 *              @ORM\EntityResult(
 *                  entityClass         = "__CLASS__",
 *                  discriminatorColumn = "discr",
 *                  fields              = {
 *                      @ORM\FieldResult("id"),
 *                      @ORM\FieldResult("completed"),
 *                  }
 *              )
 *          }
 *      ),
 * })
 */
abstract class CompanyContract
{
    /**
     * @ORM\Id @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyEmployee::class, inversedBy="soldContracts")
     */
    private $salesPerson;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $completed = false;

    /**
     * @ORM\ManyToMany(targetEntity=CompanyEmployee::class, inversedBy="contracts")
     * @ORM\JoinTable(name="company_contract_employees",
     *    joinColumns={@ORM\JoinColumn(name="contract_id", referencedColumnName="id", onDelete="CASCADE")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")}
     * )
     */
    private $engineers;

    public function __construct()
    {
        $this->engineers = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function markCompleted()
    {
        $this->completed = true;
    }

    public function isCompleted()
    {
        return $this->completed;
    }

    public function getSalesPerson()
    {
        return $this->salesPerson;
    }

    public function setSalesPerson(CompanyEmployee $salesPerson)
    {
        $this->salesPerson = $salesPerson;
    }

    public function getEngineers()
    {
        return $this->engineers;
    }

    public function addEngineer(CompanyEmployee $engineer)
    {
        $this->engineers[] = $engineer;
    }

    public function removeEngineer(CompanyEmployee $engineer)
    {
        $this->engineers->removeElement($engineer);
    }

    abstract public function calculatePrice();
}

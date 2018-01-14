<?php

declare(strict_types=1);

namespace Doctrine\Tests\Mocks;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Sequencing\SequenceGenerator;

/**
 * Mock class for SequenceGenerator.
 */
class SequenceMock extends SequenceGenerator
{
    /**
     * @var int
     */
    private $sequenceNumber = 0;

    /**
     * {@inheritdoc}
     */
    public function generate(EntityManagerInterface $em, $entity)
    {
        return $this->sequenceNumber++;
    }

    /* Mock API */

    /**
     * @return void
     */
    public function reset()
    {
        $this->sequenceNumber = 0;
    }
}

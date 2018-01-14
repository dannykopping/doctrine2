<?php

declare(strict_types=1);

namespace Doctrine\ORM\Mapping;

/**
 * Class ValueGeneratorMetadata
 */
class ValueGeneratorMetadata
{
    /** @var string */
    protected $type;

    /** @var mixed[] */
    protected $definition;

    /**
     * ValueGeneratorMetadata constructor.
     *
     * @param mixed[] $definition
     */
    public function __construct(string $type, array $definition = [])
    {
        $this->type       = $type;
        $this->definition = $definition;
    }

    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @return mixed[]
     */
    public function getDefinition() : array
    {
        return $this->definition;
    }
}

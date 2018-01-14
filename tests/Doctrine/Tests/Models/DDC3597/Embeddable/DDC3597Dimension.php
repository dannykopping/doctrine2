<?php

declare(strict_types=1);

namespace Doctrine\Tests\Models\DDC3597\Embeddable;

use Doctrine\ORM\Annotation as ORM;

/**
 * Description of DDC3597Dimension
 *
 * @ORM\Embeddable
 */
class DDC3597Dimension
{
    /**
     * @var int
     * @ORM\Column(type="integer", name="width")
     */
    private $width;

    /**
     * @var int
     * @ORM\Column(type="integer", name="height")
     */
    private $height;

    public function __construct($width = 0, $height = 0)
    {
        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = (int)$width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = (int)$height;
    }
}

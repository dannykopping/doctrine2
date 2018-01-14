<?php

namespace Doctrine\Tests\ORM\Functional\Ticket;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Annotation as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Sequencing\Generator;
use Doctrine\Tests\OrmFunctionalTestCase;

/**
 * @group 5804
 */
final class GH5804Test extends OrmFunctionalTestCase
{
    protected function setUp()
    {
        parent::setUp();

        Type::addType(GH5804Type::NAME, GH5804Type::class);

        $this->schemaTool->createSchema(
            [$this->em->getClassMetadata(GH5804Article::class)]
        );
    }

    public function testTextColumnSaveAndRetrieve2()
    {
        $firstArticle = new GH5804Article;
        $firstArticle->text = 'Max';
        $this->em->persist($firstArticle);
        $this->em->flush();

        self::assertSame(1, $firstArticle->version);

        $firstArticle->text = 'Moritz';
        $this->em->persist($firstArticle);
        $this->em->flush();

        self::assertSame(2, $firstArticle->version);
    }
}

final class GH5804Generator implements Generator
{
    /**
     * {@inheritdoc}
     */
    public function generate(EntityManagerInterface $em, $entity)
    {
        return 'test5804';
    }

    /**
     * {@inheritdoc}
     */
    public function isPostInsertGenerator()
    {
        return false;
    }
}

final class GH5804Type extends Type
{
    const NAME = 'GH5804Type';

    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        return 'testGh5804DbValue';
    }
}

/**
 * @ORM\Entity
 */
class GH5804Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="GH5804Type")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=\Doctrine\Tests\ORM\Functional\Ticket\GH5804Generator::class)
     */
    public $id;

    /**
     * @ORM\Version
     * @ORM\Column(type="integer")
     */
    public $version;

    /**
     * @ORM\Column(type="text")
     */
    public $text;
}

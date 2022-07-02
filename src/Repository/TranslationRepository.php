<?php

namespace App\Repository;

use App\Entity\Translation;
use App\Generator\TranslationSearchKeyGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Translation>
 *
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[]    findAll()
 * @method Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private TranslationSearchKeyGeneratorInterface $searchKeyGenerator
    )
    {
        parent::__construct($registry, Translation::class);
    }

    public function add(Translation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Translation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function createTranslation(string $language, string $text): Translation
    {
        $translation = new Translation(
            $language,
            $text,
            $this->searchKeyGenerator->generate($language, $text)
        );
        $this->add($translation);

        return $translation;
    }

    public function findOrCreateTranslation(string $language, string $text): Translation
    {
        $result = $this->createQueryBuilder('translation')
            ->select('translation, translations')
            ->leftJoin('translation.translations', 'translations')
            ->where('translation.searchKey = :searchKey')
            ->setParameter('searchKey', $this->searchKeyGenerator->generate($language, $text))
            ->getQuery()
            ->getResult();

        return !empty($result) ? $result[0] : $this->createTranslation($language, $text);
    }
}

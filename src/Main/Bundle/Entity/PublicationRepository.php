<?php

namespace Main\Bundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PublicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationRepository extends EntityRepository
{

    /**
     * @param array $vars
     * @return array
     */
    public function findMoreEntities(array $vars)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('n')
            ->from('MainBundle:News', 'n')

            ->where('n.lang = :lang')
            ->andWhere('n.city_id = :city_id')
            ->andWhere('n.id < :id')

            ->setParameter('city_id', $vars['city_id'])
            ->setParameter('lang', $vars['lang'])
            ->setParameter('id', $vars['id'])

            ->orderBy('n.id','DESC')

            ->setMaxResults(3)
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * @param array $vars
     * @return array
     */
    public function findMoreRecipeEntities(array $vars)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('n')
            ->from('MainBundle:Recipe', 'n')

            ->where('n.lang = :lang')
            ->andWhere('n.city_id = :city_id')
            ->andWhere('n.id < :id')

            ->setParameter('city_id', $vars['city_id'])
            ->setParameter('lang', $vars['lang'])
            ->setParameter('id', $vars['id'])

            ->orderBy('n.id','DESC')

            ->setMaxResults(3)
        ;

        return $query->getQuery()->getResult();
    }

    public function getAllWithLimit(array $vars)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('p')
            ->from('MainBundle:Publication', 'p')

            ->where('p.lang = :lang')
            ->andWhere('p.city_id = :city_id')

            ->setParameter('city_id', $vars['city_id'])
            ->setParameter('lang', $vars['lang'])

            ->orderBy('p.created_at','DESC')

            ->setMaxResults($vars['limit'])
        ;

        return $query->getQuery()->getResult();
    }
}

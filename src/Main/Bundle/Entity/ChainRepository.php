<?php

namespace Main\Bundle\Entity;

use Doctrine\ORM\EntityRepository;
use Main\Bundle\Entity\Chain;
/**
 * ChainRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChainRepository extends EntityRepository
{
    public function getAllDelivery($city, $_locale)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('c', 'com')
            ->from('MainBundle:Chain', 'c')
            ->join('c.commentsDelivery','com')

            ->where('c.lang = :lang')
            ->andWhere('c.city_id = :city_id')
            ->andWhere(' c.type = :type_f OR c.type = :type_s ')

            ->setParameter('city_id', $city->getId())
            ->setParameter('lang',$_locale)
            ->setParameter('type_f',Chain::TYPE_BOTH)
            ->setParameter('type_s',Chain::TYPE_DELIVERY)
        ;

        return $query->getQuery()->getResult();

    }

    public function getAllNotDelivery($city, $_locale)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('c, branchs','com')
            ->from('MainBundle:Chain', 'c')

            ->join('c.branchs', 'branchs')
            ->join('branchs.comments','com')

            ->where('c.lang = :lang')
            ->andWhere('c.city_id = :city_id')
            ->andWhere(' ( c.type = :type_f OR c.type = :type_s ) ')

            ->setParameter('city_id', $city->getId())
            ->setParameter('lang',$_locale)
            ->setParameter('type_f',Chain::TYPE_BRANCHES)
            ->setParameter('type_s',Chain::TYPE_BOTH)
        ;

        return $query->getQuery()->getResult();
    }

    public function getChainByMaxRating($city_id, $lang, $limit = false)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
                SELECT c.id, SUM(b.rating) as summ FROM MainBundle:Chain c
                JOIN c.branchs b
                WHERE c.city_id = :city_id
                AND c.lang = :lang
                AND b.lang = :lang
                AND  ( c.type = 3 OR c.type = 2 )
                GROUP BY c.id
                ORDER BY summ DESC
                ')
            ->setParameter('city_id', $city_id)
            ->setParameter('lang', $lang)
            ;

        if ($limit) {
            $query->setMaxResults($limit);
        }

        $result = $query->getArrayResult();

        return $result;
    }

    public function getTopDeliveryRating($city_id, $lang, $limit = false)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
                SELECT c FROM MainBundle:Chain c
                WHERE c.city_id = :city_id
                AND c.lang = :lang
                AND  ( c.type = 3 OR c.type = 1 )
                ORDER BY c.rating_delivery DESC
                ')
            ->setParameter('city_id', $city_id)
            ->setParameter('lang', $lang)
        ;

        if ($limit) {
            $query->setMaxResults($limit);
        }

        $result = $query->getResult();

        return $result;
    }

    public function getRecommendByLimit($city_id, $lang, $limit = false)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
                SELECT c FROM MainBundle:Chain c
                WHERE c.city_id = :city_id
                AND c.lang = :lang
                AND c.recommend = :recom
                ORDER BY c.rating_delivery DESC
                ')
            ->setParameter('city_id', $city_id)
            ->setParameter('lang', $lang)
            ->setParameter('recom', Chain::RECOMMEND_ON)
        ;

        if ($limit) {
            $query->setMaxResults($limit);
        }

        $result = $query->getResult();

        return $result;
    }
}

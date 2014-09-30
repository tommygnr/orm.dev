<?php

namespace JMOlivas\ORMDemoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
  public function findAllAsArray(){

    $queryBuilder = $this->getQueryBuilder();

    $query = $queryBuilder->select('a')
      ->from('ORMDemoBundle:Article','a')
      ->getQuery();

    return $query->getArrayResult();
  }

  public function findByArticleCategory(){

    $queryBuilder = $this->getQueryBuilder();

    $query = $queryBuilder->select('a.id, a.title, a.body, c.name as category_name')
      ->from('ORMDemoBundle:Article','a')
      ->leftJoin('a.category', 'c')
      ->getQuery();

    return $query->getArrayResult();
  }

  public function findAllTom(){

    $queryBuilder = $this->createQueryBuilder('a');

    $query = $queryBuilder
      ->leftJoin('a.category', 'c')
      ->leftJoin('a.tags', 't')
      ->addSelect('c')
      ->addSelect('t')
      ->getQuery();

    return $query->getResult();
  }

  public function findTagsByArticle($articleKeys){

    $queryBuilder = $this->getQueryBuilder();

    $query = $queryBuilder->select('article.id as article_id, tag.id as tag_id, tag.name as tag_name')
      ->from('ORMDemoBundle:Tag','tag')
      ->leftJoin('tag.articles', 'article', 'ON')
      ->where('article.id IN (:articleKeys)')
      ->setParameter('articleKeys',$articleKeys)
      ->getQuery();

    return $query->getArrayResult();
  }

  private function getQueryBuilder(){
    return $this->getEntityManager()->createQueryBuilder();
  }

}

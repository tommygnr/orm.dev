<?php

namespace JMOlivas\ORMDemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller{

  public function indexAction(){

    $entityManager = $this->getDoctrine()->getManager();

    $articles = $entityManager->getRepository('ORMDemoBundle:Article')->findAll();

    return $this->render(
      'ORMDemoBundle:Article:index.html.twig',
      ['articles' => $articles]
    );
  }

  public function indexAsArrayAction(){

    $entityManager = $this->getDoctrine()->getManager();

    $articles = $entityManager->getRepository('ORMDemoBundle:Article')->findAllAsArray();

    return $this->render(
      'ORMDemoBundle:Article:index-array.html.twig',
      ['articles' => $articles]
    );
  }

  public function articlesOptimizedAction(){
    $entityManager = $this->getDoctrine()->getManager();

    $articles = $entityManager->getRepository('ORMDemoBundle:Article')->findByArticleCategory();

    $articles_tags = $this->getTags($entityManager, $articles);

    $tags = $this->concatenateTags($articles_tags);

    return $this->render(
      'ORMDemoBundle:Article:index-optimized.html.twig',
      [
        'articles' => $articles,
        'articles_tags' => $articles_tags,
        'tags' => $tags,
      ]
    );
  }

  public function articlesTomAction(){
    $entityManager = $this->getDoctrine()->getManager();

    $articles = $entityManager->getRepository('ORMDemoBundle:Article')->findAllTom();

    return $this->render(
      'ORMDemoBundle:Article:index.html.twig',
      ['articles' => $articles]
    );
  }

  private function getTags($entityManager, $articles){
    $articleKeys = array_column($articles, 'id');

    return $entityManager->getRepository('ORMDemoBundle:Article')->findTagsByArticle($articleKeys);
  }

  private function concatenateTags($articles_tags){
    $tags = [];
    foreach ($articles_tags as $article_tag){
      $article_id = $article_tag['article_id'];
      if (array_key_exists($article_id, $tags)) {
        $tags[$article_id] = $tags[$article_id] . ', ' . $article_tag['tag_name'];
      }
      else {
        $tags[$article_id] = $article_tag['tag_name'];
      }
    }

    return $tags;
  }

} 
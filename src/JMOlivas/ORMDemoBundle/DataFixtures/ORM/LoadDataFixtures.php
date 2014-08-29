<?php


namespace JMOlivas\ORMDemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JMOlivas\ORMDemoBundle\Entity\Category;
use JMOlivas\ORMDemoBundle\Entity\Tag;
use JMOlivas\ORMDemoBundle\Entity\Article;
use JMOlivas\ORMDemoBundle\Entity\Comment;

class LoadDataFixtures implements FixtureInterface {
  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager) {
    $faker = \Faker\Factory::create();
    $categories = [];
    $tags = [];

    for ($i = 0; $i < 10; $i++) {
      $category = new Category();
      $category->setName($faker->sentence(3));
      $category->setDescription($faker->paragraph(1));
      $manager->persist($category);
      $manager->flush();
      $categories[] = $category->getId();
    }

    for ($i = 0; $i < 100; $i++) {
      $tag = new Tag();
      $tag->setName(ucfirst($faker->word));
      $manager->persist($tag);
      $manager->flush();
      $tags[] = $tag->getId();
    }

    for ($i = 0; $i < 250; $i++) {
      $article = new Article();
      $article->setTitle($faker->sentence(10));
      $article->setBody($faker->paragraph(5));
      $article->setCategory(
        $manager->getReference(
          'JMOlivas\ORMDemoBundle\Entity\Category',
          $categories[array_rand($categories, 1)]
        )
      );

      $randomTags = array_rand($tags, 3);

      foreach ($randomTags as $key) {
        $article->addTag($manager->getReference(
          'JMOlivas\ORMDemoBundle\Entity\Tag',
          $tags[$key]
        ));
      }

      $manager->persist($article);
      $manager->flush();
    }
  }
}
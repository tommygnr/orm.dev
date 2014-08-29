<?php

namespace JMOlivas\ORMDemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMOlivas\ORMDemoBundle\Entity\Category;
use JMOlivas\ORMDemoBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="JMOlivas\ORMDemoBundle\Entity\ArticleRepository")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=512)
     */
    private $body;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var datetime
     *
     * @ORM\Column(name="expired_at", type="datetime")
     */
    private $expiredAt;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    protected $category;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="articles_tags")
     **/
    private $tags;

    public function __construct() {
      $this->tags = new ArrayCollection();
      $this->published = true;
      $this->expiredAt = new \DateTime();
      $this->updatedAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Article
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return datetime
     */
    public function getExpiredAt() {
      return $this->expiredAt;
    }

    /**
     * @param datetime $expiredAt
     */
    public function setExpiredAt($expiredAt) {
      $this->expiredAt = $expiredAt;
    }

    /**
     * @return boolean
     */
    public function isPublished() {
      return $this->published;
    }

    /**
     * @param boolean $published
     */
    public function setPublished($published) {
      $this->published = $published;
    }

    /**
     * @return datetime
     */
    public function getUpdatedAt() {
      return $this->updatedAt;
    }

    /**
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
      $this->updatedAt = $updatedAt;
    }

    /**
     * Get Category
     *
     * @return Category
     */
    public function getCategory()
    {
      return $this->category;
    }

    /**
     * Set Category
     *
     * @param Category $category
     */
    public function setCategory($category)
    {
      $this->category = $category;
    }

    public function addTag(Tag $tag)
    {
      $tag->addArticle($this); // synchronously updating inverse side
      $this->tags[] = $tag;
    }

    public function getTags() {
      return $this->tags;
    }

}

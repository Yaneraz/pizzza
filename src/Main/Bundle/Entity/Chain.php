<?php

namespace Main\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Main\Bundle\Entity\Branch;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Chain
 *
 * @ORM\Table(name="chain")
 * @ORM\Entity(repositoryClass="Main\Bundle\Entity\ChainRepository")
 * @Vich\Uploadable
 */
class Chain
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="smallint")
     */
    private $city_id;

    /**
     * @Vich\UploadableField(mapping="chain_logo", fileNameProperty="imageName")
     *
     * @var File $image
     */
    protected $image;

    /**
     * @ORM\Column(type="string", length=255, name="image_name", nullable=true)
     *
     * @var string $imageName
     */
    protected $imageName;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Chain", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Chain", inversedBy="children",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=5)
     */
    private $lang;

    /**
     * @ORM\OneToMany(targetEntity="Branch", mappedBy="chain")
     */
    private $branchs;

    /**
     * @var string
     *
     * @ORM\Column(name="social_text", type="string", length=255)
     */
    private $social_text;

    private $branchse_pohtos;

    /**
     * @ORM\OneToMany(targetEntity="Discount", mappedBy="chain")
     */
    private $discounts;

    public function __construct($lang = 'ru')
    {
        $this->children = new ArrayCollection();
        $this->branchs = new ArrayCollection();
        $this->discounts = new ArrayCollection();
        $this->branchse_pohtos = new ArrayCollection();
        $this->updated_at = new \DateTime();
        $this->keywords = '';
        $this->lang = $lang;
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
     * Set url
     *
     * @param string $url
     * @return Chain
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Chain
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Chain
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set city_id
     *
     * @param integer $city_id
     * @return Chain
     */
    public function setCityId($city_id)
    {
        $this->city_id = $city_id;

        return $this;
    }

    /**
     * Get city_id
     *
     * @return integer
     */
    public function getCityId()
    {
        return $this->city_id;
    }


    public function setBranchs(ArrayCollection $branchs)
    {
        foreach ($branchs as $branch) {
            $branch->setChainy($this);
        }
        $this->branchs = $branchs;
    }

    /**
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getBranchs()
    {
        return $this->branchs;
    }


    /**
     * Set imageName
     *
     * @param string $url
     * @return Chain
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImage($image)
    {
        $this->image = $image;

        if ($image instanceof UploadedFile) {
            $this->updated_at = new \DateTime();
        }
    }

    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set updated_at
     *
     * @param datetime $updated_at
     * @return Chain
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Chain
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set title
     *
     * @param string $title
     * @return Chain
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
     * Set keywords
     *
     * @param string $keywords
     * @return Chain
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }


    /**
     * Set description
     *
     * @param string $description
     * @return Chain
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Add children
     *
     * @param Chain $children
     */
    public function addChain(Chain $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param Chain $parent
     */
    public function setParent(Chain $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Chain
     */
    public function getParent()
    {

        return $this->parent;
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return Chain
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $_locale
     * @return ArrayCollection
     */
    public function getBranchsByLocale($_locale = 'ru')
    {
        $result = new ArrayCollection();
        foreach ($this->getBranchs() as $branch) {
            if ($branch->getLang() == $_locale) {
                $result->add($branch);
            }
        }

        return $result;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Branch
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set social_text
     *
     * @param string $socialText
     * @return Branch
     */
    public function setSocialText($socialText)
    {
        $this->social_text = $socialText;

        return $this;
    }

    /**
     * Get social_text
     *
     * @return string
     */
    public function getSocialText()
    {
        return $this->social_text;
    }

    /**
     * @return ArrayCollection
     */
    public function getAllBranchPhotos()
    {
        foreach ($this->getBranchs() as $branch) {
            foreach ( $branch->getPhotos() as $photo ) {
                $this->branchse_pohtos[] = $photo;
            }
        }

        return $this->branchse_pohtos;
    }

    /**
     * @param ArrayCollection $discounts
     * @return Chain
     */
    public function setDiscounts(ArrayCollection $discounts)
    {
        foreach ($discounts as $discount) {
            $discount->setChainy($this);
        }
        $this->discounts = $discounts;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }

    public function getDiscountsByLocale($_locale)
    {
        $result = new ArrayCollection();
        foreach ($this->getDiscounts() as $discount) {
            if ($discount->getLang() == $_locale) {
                 $result[] = $discount;
            }
        }

        return $result;
    }
}

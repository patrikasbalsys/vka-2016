<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="model")
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $cord_size;

    /**
     * @ORM\Column(type="integer")
     */
    private $cord_amount;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_accent;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCordSize()
    {
        return $this->cord_size;
    }

    /**
     * @param mixed $cord_size
     */
    public function setCordSize($cord_size)
    {
        $this->cord_size = $cord_size;
    }

    /**
     * @return mixed
     */
    public function getCordAmount()
    {
        return $this->cord_amount;
    }

    /**
     * @param mixed $cord_amount
     */
    public function setCordAmount($cord_amount)
    {
        $this->cord_amount = $cord_amount;
    }

    /**
     * @return mixed
     */
    public function getIsAccent()
    {
        return $this->is_accent;
    }

    /**
     * @param mixed $is_accent
     */
    public function setIsAccent($is_accent)
    {
        $this->is_accent = $is_accent;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



}
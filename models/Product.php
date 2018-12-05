<?php
namespace App\Models;
 

/**
 * @Entity @Table(name="product")
 **/

class Product {
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string") **/
    private $type; 
    /** @Column(type="string") **/
    private $name; 
    /** @Column(type="string") **/
    private $brand; 
    /** @Column(type="float") **/
    private $price;  
    /** @Column(type="text") **/
    private $description;
    /** @Column(type="boolean", options={"default":"0"}) **/
    private $new_product;
    /** @Column(type="boolean", options={"default":"0"}) **/
    private $sale;
    /** @Column(type="float") **/
    private $sale_price;
    /** @Column(type="text") **/
    private $image_path;



    public function __construct()    
    {    
    }
    
      /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set brand.
     *
     * @param string $brand
     *
     * @return Product
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand.
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set newProduct.
     *
     * @param bool $newProduct
     *
     * @return Product
     */
    public function setNewProduct($newProduct)
    {
        $this->new_product = $newProduct;

        return $this;
    }

    /**
     * Get newProduct.
     *
     * @return bool
     */
    public function getNewProduct()
    {
        return $this->new_product;
    }

    /**
     * Set sale.
     *
     * @param bool $sale
     *
     * @return Product
     */
    public function setSale($sale)
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * Get sale.
     *
     * @return bool
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * Set salePrice.
     *
     * @param float $salePrice
     *
     * @return Product
     */
    public function setSalePrice($salePrice)
    {
        $this->sale_price = $salePrice;

        return $this;
    }

    /**
     * Get salePrice.
     *
     * @return float
     */
    public function getSalePrice()
    {
        return $this->sale_price;
    }

    /**
     * Set imagePath.
     *
     * @param string $imagePath
     *
     * @return Product
     */
    public function setImagePath($imagePath)
    {
        $this->image_path = $imagePath;

        return $this;
    }

    /**
     * Get imagePath.
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->image_path;
    }
} 
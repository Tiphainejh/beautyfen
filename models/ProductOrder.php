<?php
namespace App\Models;
 

/**
 * @Entity @Table(name="product_order")
 **/

class ProductOrder {
    /**
     * @Id @ManyToOne(targetEntity="Order")
     * @JoinColumn(name="id_order", referencedColumnName="id")
     */
    private $order; 
    
    /**
     * @Id @ManyToOne(targetEntity="Product")
     * @JoinColumn(name="id_product", referencedColumnName="id")
     */
    private $product;  
  
      /** @Column(type="integer") **/
    private $quantity;
 
    
    public function __construct()    
    {    
        $this->products_order = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
  /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return ProductOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set order.
     *
     * @param \App\Models\Order $order
     *
     * @return ProductOrder
     */
    public function setOrder(\App\Models\Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return \App\Models\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product.
     *
     * @param \App\Models\Product $product
     *
     * @return ProductOrder
     */
    public function setProduct(\App\Models\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \App\Models\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
} 
<?php

namespace App\Models;

/**
 * ProductOrder
 */
class ProductOrder
{
    /**
     * @var int
     */
    private $quantity;

    /**
     * @var \App\Models\Order
     */
    private $order;

    /**
     * @var \App\Models\Product
     */
    private $product;


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

<?php

namespace App\Models;

/**
 * Order
 */
class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date_order;

    /**
     * @var float
     */
    private $total_amount;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \App\Models\User
     */
    private $user;


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
     * Set dateOrder.
     *
     * @param \DateTime $dateOrder
     *
     * @return Order
     */
    public function setDateOrder($dateOrder)
    {
        $this->date_order = $dateOrder;

        return $this;
    }

    /**
     * Get dateOrder.
     *
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->date_order;
    }

    /**
     * Set totalAmount.
     *
     * @param float $totalAmount
     *
     * @return Order
     */
    public function setTotalAmount($totalAmount)
    {
        $this->total_amount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount.
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user.
     *
     * @param \App\Models\User|null $user
     *
     * @return Order
     */
    public function setUser(\App\Models\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \App\Models\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}

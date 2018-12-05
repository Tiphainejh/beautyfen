<?php
namespace App\Models;
 

/**
 * @Entity @Table(name="`order`")
 **/

class Order {
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="date") **/
    private $date_order; 
    /** @Column(type="float") **/
    private $total_amount;  
  
    /** @Column(type="string") **/
    private $status;
  
    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="id_user", referencedColumnName="id")
     */
    public $user;

    
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
    public function setUser(\App\Models\User $user)
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
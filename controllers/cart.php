<?php 
	require_once ("./models/User.php");
	require_once ("./models/Product.php");
	require_once ("./models/Order.php");
	require_once ("./models/ProductOrder.php");
    session_start();
	
	use App\Models\User as User;
	use App\Models\Product as Product;
	use App\Models\ProductOrder as ProductOrder;
	use App\Models\Order as Order;

	
	global $twig;
	global $entityManager;

class CartController 
{
    
   private $twig;

    public function __construct()
    {
        global $twig;
        global $entityManager;

        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }
    
    
    public function index()
    {
        global $entityManager;
        $nbcart = 0;

        //on récupère l'utilisateur
         if($_SESSION["user"]==NULL)
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render(["message"=>"Veuillez vous connecter","nbcart"=>0]);
        }
        else
        {
            
            $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));
            $cart = $entityManager
               ->createQueryBuilder()
               ->select('o')
               ->from(' App\Models\Order', 'o')
               ->where('o.user = :id AND o.status LIKE :status')
               ->orderBy('o.date_order', 'ASC')
               ->setParameter('id',$_SESSION["user"])
               ->setParameter('status','%ongoing%')
               ->getQuery()
               ->getResult();
               
            if($cart)
            {
                $productincart=$entityManager->getRepository(ProductOrder::class)->findOneBy(array('order' => $cart,'product'=>$product));
                
                $cartproducts = $entityManager
                   ->createQueryBuilder()
                   ->select('p')
                   ->from(' App\Models\ProductOrder', 'p')
                   ->where('p.order = :cart')
                   ->setParameter('cart',$cart)
                   ->getQuery()
                   ->getResult();
                
                $total_amount = $cart[0]->getTotalAmount();
                $nbcart = sizeof($cartproducts);

            }
    
                $template = $this->twig->load("cart.twig");
                echo $template->render(["products"=>$cartproducts,"total_amount"=>$total_amount,"nbcart"=>$nbcart]);
        }
    }
    
    public function addquantity($post)
    {
        global $entityManager;


        $productid = intval($post);
        
        $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));
        $product=$entityManager->getRepository(Product::class)->findOneBy(array('id' => $productid));
        ob_flush();
        ob_start();
        var_dump($productid);
		file_put_contents("log.txt", date("H:i:s")." ".ob_get_flush()." cart\n", FILE_APPEND);
        //on cherche la commande en cours
         $cart = $entityManager
           ->createQueryBuilder()
           ->select('o')
           ->from(' App\Models\Order', 'o')
           ->where('o.user = :id AND o.status LIKE :status')
           ->orderBy('o.date_order', 'ASC')
           ->setParameter('id',$_SESSION["user"])
           ->setParameter('status','%ongoing%')
           ->getQuery()
           ->getResult();
         
        //on met à jour le montant total du cart      
        $price = $product->getPrice();
        $total_amount = $price + $cart[0]->getTotalAmount();
        $cart[0]->setTotalAmount($total_amount);
        $entityManager->persist($cart[0]);
       
        //on cherche la table associée
        $productincart=$entityManager->getRepository(ProductOrder::class)->findOneBy(array('order' => $cart,'product'=>$product));
        
        //on met à jour la quantité de produit dans le cart
        $quantity = $productincart->getQuantity() + 1;
        $productincart->setQuantity($quantity);
        
        $entityManager->persist($productincart);
        $entityManager->flush();
                    

    }
    
    public function removequantity($post)
    {
        global $entityManager;


        $productid = intval($post);
        
        $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));
        $product=$entityManager->getRepository(Product::class)->findOneBy(array('id' => $productid));

        //on cherche la commande en cours
         $cart = $entityManager
           ->createQueryBuilder()
           ->select('o')
           ->from(' App\Models\Order', 'o')
           ->where('o.user = :id AND o.status LIKE :status')
           ->orderBy('o.date_order', 'ASC')
           ->setParameter('id',$_SESSION["user"])
           ->setParameter('status','%ongoing%')
           ->getQuery()
           ->getResult();
         
        //on met à jour le montant total du cart      
        $price = $product->getPrice();
        $total_amount = $cart[0]->getTotalAmount() - $price;
        $cart[0]->setTotalAmount($total_amount);
        $entityManager->persist($cart[0]);
       
        //on cherche la table associée
        $productincart=$entityManager->getRepository(ProductOrder::class)->findOneBy(array('order' => $cart,'product'=>$product));
        
        //on met à jour la quantité de produit dans le cart
        $quantity = $productincart->getQuantity() - 1;
        $productincart->setQuantity($quantity);
        
        $entityManager->persist($productincart);
        $entityManager->flush();
                    

    }

}
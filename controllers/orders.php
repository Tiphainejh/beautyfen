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

class OrdersController 
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
        //verifie si l'utilisateur est bien connecté
        //verifie si l'utilisateur est bien connecté
        if($_SESSION["user"]!=NULL)
        {
            //affichage du nombre d'éléments du cart
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
           
            $orders = $entityManager
               ->createQueryBuilder()
               ->select('o.id, o.date_order, o.total_amount, o.status')
               ->from(' App\Models\Order', 'o')
               ->where('o.user = :id')
               ->orderBy('o.date_order', 'ASC')
               ->setParameter('id',$_SESSION["user"])
               ->getQuery()
               ->getResult();
        
            if($cart)
            {
                $productsincart=$entityManager->getRepository(ProductOrder::class)->findBy(array('order' => $cart));
                $nbcart = sizeof($productsincart);
            }
            
            $template = $this->twig->load("orders.twig");
            echo $template->render(["nbcart"=>$nbcart,"orders"=>$orders]);
        }
        
        else
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render();
        }
    }
    
    
    
    
    public function addToCart($post)
    {        
        
        global $entityManager;
    
        $productid = intval($post['id']);
       
        //on récupère l'utilisateur
         if($_SESSION["user"]==NULL)
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render(["message"=>"Veuillez vous connecter"]);
        }
        else
        {
            
        $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));
        $product=$entityManager->getRepository(Product::class)->findOneBy(array('id' => $productid));

        //on regarde s'il y a déjà une commande en cours
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
           
            //si non on en crée une
           if(!$cart)
           {
                $date = date('m/d/Y');
                $date_order = new DateTime($date);
                $status = "ongoing";
                $amount = 12;
                
                $cart = new Order();
                $cart->setUser($user);
                $cart->setDateOrder($date_order);
                $cart->setTotalAmount($amount);
                $cart->setStatus($status);
                
                //on cree une table de laison entre le cart et les produits
                $productcart = new ProductOrder();
                $productcart->setQuantity(1);
                $productcart->setProduct($product);
                $productcart->setOrder($cart);
                
                $entityManager->persist($cart);
                $entityManager->persist($productcart);
                $entityManager->flush();
             
           }
            //on ajoute le produit à la commande
           else
           {
                //on met à jour le total du cart
                $price = $product->getPrice();
                $total_amount = $price + $cart[0]->getTotalAmount();
                $cart[0]->setTotalAmount($total_amount);
                $entityManager->persist($cart[0]);
                            
               
               //on cherche la table associée
               //on regarde si le produit est déjà présent dans le cart
                $productincart=$entityManager->getRepository(ProductOrder::class)->findOneBy(array('order' => $cart,'product'=>$product));

                if ($productincart)
                {
                    //on met à jour la quantité de produit dans le cart
                    $quantity = $productincart->getQuantity() + 1;
                    $productincart->setQuantity($quantity);
                    
                    $entityManager->persist($productincart);
                    $entityManager->flush();
                }
                
                else
                {
                    $productcart = new ProductOrder();
                    $productcart->setQuantity(1);
                    $productcart->setProduct($product);
                    $productcart->setOrder($cart[0]);
                    $entityManager->persist($productcart);
                    $entityManager->flush();
                }
              
           }
           
           
        }  
        $template = $this->twig->load("header.twig");
        echo $template->renderView(["nb"=>2]);
           
    }

}
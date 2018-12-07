<?php 
    session_start();

	require_once ("./models/Product.php");
	require_once ("./models/ProductOrder.php");
	require_once ("./models/Order.php");
	require_once ("./models/User.php");
	
	use App\Models\Product as Product;
	use App\Models\ProductOrder as ProductOrder;
	use App\Models\User as User;
	use App\Models\Order as Order;

	
	global $twig;
	global $entityManager;

class ProductDetailController {
    
    private $twig;

    public function __construct() {
        global $twig;
        
        $this->twig = $twig;

    }
    public function index($get) {

        global $entityManager;
        $nbcart = 0;

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
           
            if($cart)
            {
                $productsincart=$entityManager->getRepository(ProductOrder::class)->findBy(array('order' => $cart));
                $nbcart = sizeof($productsincart);
            }

        }
        
        //recherche d'un produit par son id
        if($get['id'])
        {
        	$product = $entityManager
           ->createQueryBuilder()
    	       ->select('p')
    	       ->from(' App\Models\Product', 'p')
    	       ->where('p.id = :id')
    	       ->setParameter('id',$get['id'])
    	       ->getQuery()
    	       ->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    	  
    	    //recherche des produits du meme type
    	   $otherproducts = $entityManager
		       ->createQueryBuilder()
		       ->select('p')
		       ->from(' App\Models\Product', 'p')
		       ->where('p.type = :type AND p.id <> :id')
		       ->orderBy('p.name', 'ASC')
		       ->setParameter('type',$product["type"])
		       ->setParameter('id',$product["id"])
		       ->setMaxResults(8)
		       ->getQuery()
		       ->getResult();	
        }
        
        $template = $this->twig->load("productdetail.twig");
        echo $template->render(["product"=>$product,"otherproducts"=>$otherproducts,"nbcart"=>$nbcart,"user"=>$_SESSION['user']]);
    }
    
    public function addToCart($post)
    {        

        //file_put_contents("log.txt", var_dump($post)." products\n", FILE_APPEND);
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
            //on cherche l'utilisateur et le produit
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
                 if($product->getSale())
                    $amount = $product->getSalePrice();
                else
                    $amount = $product->getPrice();
                
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
                 if($product->getSale())
                    $price = $product->getSalePrice();
                else
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
    }
    
    
}
?>
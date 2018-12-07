<?php 
    session_start();

	require_once ("./models/User.php");
	require_once ("./models/Product.php");
	require_once ("./models/Order.php");
	require_once ("./models/ProductOrder.php");
	
	use App\Models\User as User;
	use App\Models\Product as Product;
	use App\Models\ProductOrder as ProductOrder;
	use App\Models\Order as Order;


	global $twig;
	global $entityManager;

class ProductsController {
    
    private $twig;

    public function __construct() {
        global $twig;
        
        $this->twig = $twig;

    }
    
    public function index($get) {
    global $entityManager;
    $nbcart = 0;

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
    
    //filtre les produits dans une certaine tranche de prix
    if($get['minval'])
    {
    	$products = $entityManager
       ->createQueryBuilder()
	       ->select('p')
	       ->from(' App\Models\Product', 'p')
	       ->where('p.price > :minval AND p.price < :maxval')
	       ->orwhere('p.sale_price > :minval AND p.price < :maxval')
	       ->orderBy('p.name', 'ASC')
	       ->setParameter('minval',$get['minval'])
	       ->setParameter('maxval',$get['maxval'])
	       ->getQuery()
	       ->getResult();
       
       $titre = "Résultats de la recherche : ";
      
       $type = "all";
       $search = $get['search'];
    }
    //Recherche des produits correspondants à un mot clef
    else if ($get["search"] )
    {
    	if (!$get['sort'])
	    {
			$products = $entityManager
	       ->createQueryBuilder()
		       ->select('p')
		       ->from(' App\Models\Product', 'p')
		       ->where('LOWER(p.name) LIKE :name')
		       ->orwhere('LOWER(p.brand) LIKE :name')
		       ->orderBy('p.name', 'ASC')
		       ->setParameter('name','%'.strtolower($get["search"]).'%')
		       ->getQuery()
		       ->getResult();
	    }
    
	    //tri des produits correspondant à un mot clef
	    elseif ($get['sort'])
	    {
	        $sql="  SELECT * 
                    FROM product 
                    WHERE LOWER(name) LIKE '%".strtolower($get["search"])."%'
                    OR LOWER(brand) LIKE '%".strtolower($get["search"])."%'
                    ORDER BY 
                        CASE WHEN  `sale` =  '1'
                        THEN  `sale_price` 
                        ELSE  `price` 
                    END ".$get["sort"];
                    
            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll();
	    	
    	}
    	
       $titre = "Résultats de la recherche : ";
       $type = "all";
       $search = $get['search'];
    }
    else if ($get["type"] && !$get["sort"])
    {
    	//recherche de tous les produits
    	if ($get["type"] == 'all')
    	{
    		$products = $entityManager
	       ->createQueryBuilder()
	       ->select('p')
	       ->from(' App\Models\Product', 'p')
	       ->orderBy('p.name', 'ASC')
	       ->getQuery()
	       ->getResult();
	       
	       $titre = "Tous nos produits";
	       $type = "all";
    	}
    	
    	//recherche de tous les produits d'un certain type
    	else
    	{
		     $products = $entityManager
		       ->createQueryBuilder()
		       ->select('p')
		       ->from(' App\Models\Product', 'p')
		       ->where('p.type = :type')
		       ->orderBy('p.name', 'ASC')
		       ->setParameter('type',$get["type"])
		       ->getQuery()
		       ->getResult();	

		       $titre = $get["type"];
		       $type = $get["type"];
    	}
    }
    
   //tri des produits
   else if($get["sort"])
   {
   		//recherche des produits d'un certain type triés dans un certain ordre
   		if($get["type"]!="all" & $get["type"]!=NULL)
   		{
   		    $sql="  SELECT * 
                    FROM product 
                    WHERE type = '".$get["type"]."' 
                    ORDER BY 
                        CASE WHEN  `sale` =  '1'
                        THEN  `sale_price` 
                        ELSE  `price` 
                    END ".$get["sort"];
                    
            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll();
			
			$titre = $get["type"];
		    $type = $get["type"];
   		}
   		
   		// recherche de tous les produits triés dans un certain ordre
		else if($get["type"]=="all" & $get["type"]!=NULL) 
        {
            $sql="  SELECT * 
                    FROM product
                    ORDER BY 
                        CASE WHEN  `sale` =  '1'
                        THEN  `sale_price` 
                        ELSE  `price` 
                    END ".$get["sort"];
                    
            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll();
    		$titre = "Tous nos produits";
    		$type = "all"; 
        }
   }
   
   // recherche de tous les produits sans filtre
   else 
   {
	    $products = $entityManager
	       ->createQueryBuilder()
	       ->select('p')
	       ->from(' App\Models\Product', 'p')
	       ->orderBy('p.name', 'ASC')
	       ->getQuery()
	       ->getResult();
	   		
	   	$titre = "Tous nos produits";
		$type = "all"; 
   }
    $template = $this->twig->load("products.twig");
    echo $template->render(["products"=> $products,"titre"=>$titre,"type"=>$type,"search"=>$search,"user"=>$_SESSION['user'],"nbcart"=>$nbcart]);
    }
    
   
   public function addToCart($post)
    {        

        //file_put_contents("log.txt", var_dump($post)." products\n", FILE_APPEND);
        global $entityManager;
        if(isset($post['qt']))
            $quantity = intval($post['qt']);
        else
            $quantity = 1;
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
                    $amount = $product->getSalePrice() * $quantity;
                else
                    $amount = $product->getPrice() * $quantity;
                
                $cart = new Order();
                $cart->setUser($user);
                $cart->setDateOrder($date_order);
                $cart->setTotalAmount($amount);
                $cart->setStatus($status);
                
                //on cree une table de laison entre le cart et les produits
                $productcart = new ProductOrder();
                $productcart->setQuantity($quantity);
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
                    $price = $product->getSalePrice() * $quantity;
                else
                    $price = $product->getPrice() * $quantity;
                $total_amount = $price + $cart[0]->getTotalAmount();
                $cart[0]->setTotalAmount($total_amount);
                $entityManager->persist($cart[0]);
                            
               
               //on cherche la table associée
               //on regarde si le produit est déjà présent dans le cart
                $productincart=$entityManager->getRepository(ProductOrder::class)->findOneBy(array('order' => $cart,'product'=>$product));

                if ($productincart)
                {
                    //on met à jour la quantité de produit dans le cart
                    $qt = $productincart->getQuantity() + $quantity;
                    $productincart->setQuantity($qt);
                    
                    $entityManager->persist($productincart);
                    $entityManager->flush();
                }
                
                else
                {
                    $productcart = new ProductOrder();
                    $productcart->setQuantity($quantity);
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
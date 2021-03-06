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

        //on récupère l'utilisateur
         if($_SESSION["user"]==NULL)
        {
            //si l'user n'est pas connecté on le redirige vers la page de connexion
            $template = $this->twig->load("signin.twig");
            echo $template->render(["message"=>"Veuillez vous connecter","nbcart"=>0]);
        }
        else
        {
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
    
    //ajoute 1 unité au produit spécifié
    public function addQuantity($post)
    {
        global $entityManager;

        //on récupère le produit
        $product=$entityManager->getRepository(Product::class)->findOneBy(array('id' => $post['id']));
        
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
        //si le produit est soldé on prend le prix soldé
        if($product->getSale())
            $price = $product->getSalePrice();
        else
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
    
    //retire 1 unité au produit spécifié
    public function removeQuantity($post)
    {
        global $entityManager;

        //on récupère le produit        
        $product=$entityManager->getRepository(Product::class)->findOneBy(array('id' => $post['id']));

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
        //si le produit est soldé on prend le prix soldé
         if($product->getSale())
            $price = $product->getSalePrice();
        else
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
    
    //suppression d'un produit du cart et/ou d'un cart
    public function deleteItem($post)
    {
        global $entityManager;

        //récupération du produit
        $product=$entityManager->getRepository(Product::class)->findOneBy(array('id' => $post['id']));

        //on cherche la commande en cours
         $cart = $entityManager
           ->createQueryBuilder()
           ->select('o')
           ->from(' App\Models\Order', 'o')
           ->where('o.user = :id AND o.status LIKE :status')
           ->setParameter('id',$_SESSION["user"])
           ->setParameter('status','%ongoing%')
           ->getQuery()
           ->getResult();
        
        //on cherche le nombre d'éléments du panier
        $productscart=$entityManager->getRepository(ProductOrder::class)->findBy(array('order' => $cart));
        $taille = sizeof($productscart);
        
        //on cherche l'article dans le panier
        $productincart=$entityManager->getRepository(ProductOrder::class)->findOneBy(array('order' => $cart,'product'=>$product));

        // si c'est le seul article du panier on supprime le panier
        // on supprime l'article
        if ($taille==1)
        {
            $entityManager->remove($productincart);
            $entityManager->remove($cart[0]);
        }
        //sinon on ne supprime que l'article
        else
        {
            //on met à jour le montant total du cart  
             if($product->getSale())
                $price = $product->getSalePrice();
            else
                $price = $product->getPrice();
            $total_amount = $cart[0]->getTotalAmount() - $price;
            
            $cart[0]->setTotalAmount($total_amount);
            $entityManager->persist($cart[0]);
            $entityManager->remove($productincart);
        }
        
        $entityManager->flush();
    }
}
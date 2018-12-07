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

    public function __construct() 
    {
        global $twig;
        $this->twig = $twig;
    }
    
    public function index($get) 
    {

        global $entityManager;

        //regarde si l'utilisateur est connecté
        if($_SESSION["user"]!=NULL)
        {
            $nbcart = 0;
            
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
}
?>
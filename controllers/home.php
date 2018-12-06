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

class HomeController {
    
    private $twig;

    public function __construct() {
        global $twig;
        
        $this->twig = $twig;

    }
    
    public function index() {

    global $entityManager;
    $nbcart = 0;

    //on récupère les produits les plus commandés
    $productsorder = $entityManager
       ->createQueryBuilder()
       ->select('p, count(p.product) as nb')
       ->from(' App\Models\ProductOrder', 'p')
       ->groupby("p.product")
       ->orderby("nb", "DESC")
       ->setMaxResults(12)
       ->getQuery()
       ->getResult();
    $products = array();
      
   foreach($productsorder as $i  =>$p)
      $products[$i]=$p[0]->getProduct();
   
   
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
    
    $template = $this->twig->load("home.twig");
    echo $template->render(["products"=> $products,"user"=>$_SESSION['user'],"nbcart"=>$nbcart]);
    }
    
}

?>
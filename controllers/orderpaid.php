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

class OrderpaidController {
    
    private $twig;

    public function __construct() {
        global $twig;
        
        $this->twig = $twig;

    }
    
    public function index() {

    global $entityManager;
    
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
   
    $cart[0]->setStatus("success");
    
    $entityManager->persist($cart[0]);
    $entityManager->flush();
    
    $template = $this->twig->load("orderpaid.twig");
    echo $template->render(["nbcart"=>0]);
    }
    
}

?>
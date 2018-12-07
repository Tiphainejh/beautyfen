<?php 
    session_start();

	require_once ("./models/Order.php");
	require_once ("./models/User.php");

	use App\Models\Order as Order;
	use App\Models\User as User;

	global $twig;
	global $entityManager;

class OrderpaidController {
    
    private $twig;

    public function __construct()
    {
        global $twig;
        $this->twig = $twig;
    }
    
    public function index()
    {
        global $entityManager;
        
        //la commande est validée, on passe son statut à "success"
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
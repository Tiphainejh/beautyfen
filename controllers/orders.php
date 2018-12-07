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
        //si l'utilisateur n'est pas connecté, on le renvoie à la page de connexion
        else
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render();
        }
    }
}
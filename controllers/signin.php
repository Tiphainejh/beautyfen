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

class SigninController 
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

        //si l'utilisateur est connecté
        if($_SESSION["user"]!=NULL)
        {
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
           
            //récupération du nombre d'éléments du cart
            if($cart)
            {
                $productsincart=$entityManager->getRepository(ProductOrder::class)->findBy(array('order' => $cart));
                $nbcart = sizeof($productsincart);
            }
            
            $template = $this->twig->load("account.twig");
            echo $template->render(["nbcart"=>$nbcart]);
        }
        else
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render();
        }
    }

    //connexion à un compte utilisateur
    public function connect($post)
    {
        global $entityManager;

        if($post)
        {   
            //on verifie que le nom d'utilisateur soit présents dans la bdd
            $username=$entityManager->getRepository(User::class)->findOneBy(array('username' => $post['username']));
            
            //si le nom d'utilisateur n'existe pas
            if (!$username)
            {
                $message = "Le nom d'utilisateur n'existe pas, veuillez réessayer.";
                $template = $this->twig->load("signin.twig");
                echo $template->render(["post" => $_POST,"message"=>$message]);
            }
            else
            {
                //recupération de l'utilisateur
                $user = $entityManager
                   ->createQueryBuilder()
                   ->select('u')
                   ->from(' App\Models\User', 'u')
                   ->where('u.username = :username')
                   ->setParameter('username',$_POST["username"])
                   ->getQuery()
                   ->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
               
               //on vérifie que le mot de passe est correct
                if (sha1($_POST["password"])!= $user["password"])
                {
                    $message = "Le nom mot de passe est incorrect, veuillez réessayer.";
                    $template = $this->twig->load("signin.twig");
                    echo $template->render(["post" => $_POST,"message"=>$message]);
                }
                else
                {
                    $_SESSION["user"] = $user["id"];
                    header("Location: /account");
                }
            }    
        
        }
    }
}
?>
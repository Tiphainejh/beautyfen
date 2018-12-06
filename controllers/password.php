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

class PasswordController 
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
    
            $template = $this->twig->load("password.twig");
            echo $template->render(["nbcart"=>$nbcart]);
        }
        
        else
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render();
        }
    }
    
    public function modify($post)
    {
        
        global $entityManager;

        //on récupère l'utilisateur
        $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));

       //on vérifie que le mot de passe est correct
        if (sha1($_POST["old_password"]) != $user->getPassword())
        {
            $message = "Le mot de passe entré est incorrect, veuillez réessayer.";
            $template = $this->twig->load("password.twig");
            echo $template->render(["message"=>$message,"color"=>"red"]);
        }
        else
        {
            $user->setPassword(sha1($post['password']));
            $entityManager->persist($user);
            $entityManager->flush();
            $message = "Mot de passe modifié avec succès.";
            $template = $this->twig->load("password.twig");
            echo $template->render(["message"=>$message,"color"=>"green"]);
        }
    }

}
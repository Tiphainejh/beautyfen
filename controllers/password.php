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
    
    
    public function index($get)
    {
        global $entityManager;
        
        if($get["error"])
        {
            $message = "Le mot de passe entré est incorrect, veuillez réessayer.";
            $color = "red";
        }
        if($get["success"])
        {
            $message = "Mot de passe modifié avec succès.";
            $color = "green";
        }

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
           
            if($cart)
            {
                $productsincart=$entityManager->getRepository(ProductOrder::class)->findBy(array('order' => $cart));
                $nbcart = sizeof($productsincart);
            }
    
            $template = $this->twig->load("password.twig");
            echo $template->render(["nbcart"=>$nbcart,"message"=>$message,"color"=>$color]);
        }
        //si l'utilisateur n'est pas connecté, on le renvoie à la page de connexion
        else
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render();
        }
    }
    
    //modifie le mot de passe d'un user
    public function modify($post)
    {
        global $entityManager;

        //on récupère l'utilisateur
        $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));
        
        //on vérifie que le mot de passe soit correct
        if (sha1($_POST["old_password"]) != $user->getPassword())
        {
            header("Location: /password?error=ok");
        }
        else
        {
            $user->setPassword(sha1($post['password']));
            $entityManager->persist($user);
            $entityManager->flush();
            header("Location: /password?success=ok");
        }
    }
}
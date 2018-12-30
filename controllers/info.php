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

class InfoController 
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

        if($get["error"]== "u_exists")
        {
            $message = "Ce nom d'utilisateur existe déjà, veuillez en entrer un autre.";
            $color = "red";
        }
        else if($get["error"]== "e_exists")
        {
            $message = "Cette adresse email existe déjà, veuillez en entrer une autre.";
            $color = "red";
        }
        else if($get["error"]== "invalid")
        {
            $message = "Cette adresse email est invalide, veuillez en entrer une autre.";
            $color = "red";
        }
        else if($get["success"])
        {
            $message = "Vos informations ont bien été modifiées.";
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
            
            $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));

            $template = $this->twig->load("info.twig");
            echo $template->render(["user"=>$user,"nbcart"=>$nbcart,"message"=>$message,"color"=>$color]);
        }
        //si l'utilisateur n'est pas connecté, on le renvoie à la page de connexion
        else
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render();
        }
    }
    
    //modifie les données d'un user
    public function modify($post)
    {
        
        global $entityManager;
        //on récupère l'utilisateur
        $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));
        
        //si le nom d'utilisateur a été changé, on verifie qu'il n'existe pas déjà
        if ($post["username"] != $user->getUsername())
        {
            $username=$entityManager->getRepository(User::class)->findOneBy(array('username' => $post['username']));
            
            if($username)
            {
                header("Location: /password?error=u_exists");
            }
        }
        
        //si l'email a été changé, on verifie qu'il nexiste pas déjà
        else if($post["email"] != $user->getEmail())
        {
        //var_dump("ok");die();
            $email=$entityManager->getRepository(User::class)->findOneBy(array('email' => $post['email']));
            
            //on verifie que l'email est valie
            if (!filter_var($post["email"], FILTER_VALIDATE_EMAIL))
            {
                header("Location: /password?error=invalid");
            }
            else if($email)
            {
                header("Location: /password?error=e_exists");
            }
        }
        
        $birth1 = strtotime($post['month']."/".$post['day']."/".$post['year']);
        $birth2 = date('Y-m-d',$birth1);
        $birth = new DateTime($birth2);
        
        $user->setName($post['name']);
        $user->setUserName($post['username']);
        $user->setFirstName($post['firstname']);
        $user->setEmail($post['email']);
        $user->setBirth($birth);
            
        $entityManager->persist($user);
        $entityManager->flush();
        
        header("Location: /info?success=ok");
    }
}
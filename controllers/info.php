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
           
            if($cart)
            {
                $productsincart=$entityManager->getRepository(ProductOrder::class)->findBy(array('order' => $cart));
                $nbcart = sizeof($productsincart);
            }
            
            $user=$entityManager->getRepository(User::class)->findOneBy(array('id' => $_SESSION["user"]));
            $template = $this->twig->load("info.twig");
            echo $template->render(["user"=>$user,"nbcart"=>$nbcart]);
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
                $message = "Le nom d'utilisateur ".$post['username']." existe déjà, veuillez en choisir un autre.";
                $template = $this->twig->load("info.twig");
                echo $template->render(["message"=>$message,"color"=>"red"]);
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
                $message = "L'adresse email est invalide.";
                $template = $this->twig->load("info.twig");
                echo $template->render(["message"=>$message,"color"=>"red"]);
            }
            else if($email)
            {
                $message = "L'adresse email ".$post['email']." existe déjà, veuillez en entrer une autre.";
                $template = $this->twig->load("info.twig");
                echo $template->render(["message"=>$message,"color"=>"red"]);
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
        
        $message = "Vos informations ont bien été modifiées.";
        $template = $this->twig->load("info.twig");
        echo $template->render(["message"=>$message,"color"=>"green","user"=>$user]);
    }
}
<?php 
	require_once ("./models/User.php");
    session_start();
	use App\Models\User as User;

	
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
        if($_SESSION["user"]!=NULL)
        {
            $template = $this->twig->load("account.twig");
            echo $template->render();
        }
        
        else
        {
            $template = $this->twig->load("signin.twig");
            echo $template->render();
        }

    }

    public function register($post)
    {
        global $entityManager;

        if($post)
        {   
            //on verifie que le nom d'utilisateur et l'email ne sont pas déjà présents dans la bdd
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
                
                //recupération du mot de passe 
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
                    $template = $this->twig->load("account.twig");
                    echo $template->render();
                }
            }    
        
        }
    }

}
?>
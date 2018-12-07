<?php 
    session_start();
	
	require_once ("./models/User.php");
	
	use App\Models\User as User;
	
	global $twig;
	global $entityManager;

class SignupController 
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
            $template = $this->twig->load("signup.twig");
            echo $template->render();
        }

    }

    //enregistrement d'un compte utilisateur
    public function register($post)
    {
        global $entityManager;

        if($post)
        {   
            //on verifie que le nom d'utilisateur et l'email ne sont pas déjà présents dans la bdd
            $username=$entityManager->getRepository(User::class)->findOneBy(array('username' => $post['username']));
            $email=$entityManager->getRepository(User::class)->findOneBy(array('email' => $post['email']));

            //teste si l'adresse mail est valide
            if (!filter_var($post["email"], FILTER_VALIDATE_EMAIL))
            {
                $message = "Votre adresse email est invalide.";
                $template = $this->twig->load("signup.twig");
                echo $template->render(["post" => $_POST,"message"=>$message]);
            } 
           
            //si l'addresse mail existe déjà
            else if ($email)
            {
                $message = "Vous possédez déjà un compte chez nous, veuillez vous connecter.";
                $template = $this->twig->load("signin.twig");
                echo $template->render(["message"=>$message]);
            }
            
            //si le nom d'utilisateur existe déjà
            else if ($username)
            {
                $message = "Le nom d'utilisateur ".$post['username']." existe déjà, veuillez en choisir un autre.";
                $template = $this->twig->load("signup.twig");
                echo $template->render(["post" => $_POST,"message"=>$message]);
            }
            else
            {
                $birth1 = strtotime($post['month']."/".$post['day']."/".$post['year']);
                $birth2 = date('Y-m-d',$birth1);
                $birth = new DateTime($birth2);
                
                $user = new User();
                $user->setName($post['name']);
                $user->setUserName($post['username']);
                $user->setFirstName($post['firstname']);
                $user->setEmail($post['email']);
                $user->setBirth($birth);
                $user->setPassword(sha1($post['password']));
                
                $entityManager->persist($user);
                $entityManager->flush();
               
                $_SESSION["user"] = $user->getId();
                $template = $this->twig->load("account.twig");
                echo $template->render();
            }    
        
        }
    }

}
?>
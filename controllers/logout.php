<?php 
class LogoutController 
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
        $_SESSION["user"]=NULL;
        require("controllers/home.php");
        $home = new HomeController();
		$home -> index();
    }
}
?>
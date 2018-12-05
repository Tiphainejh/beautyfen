<?php
session_start();
require_once 'vendor/autoload.php';
require_once "bootstrap.php";

// authentification
$loader = new Twig_Loader_Filesystem('./view');
$twig = new Twig_Environment($loader, array('auto_reload' => true));

//expression reguliere de l'url pour récupérer le controller
preg_match("/([\/])+([a-zA-Z]*)(\/([a-zA-Z]*([\?][a-zA-Z]*[\=][a-zA-Z]*)([\&][a-zA-Z]*[\=][a-zA-Z]*)*\/*)|[\/]*)?/",
$_SERVER['REQUEST_URI'],$url);
$controller = $url[2];

try
{
	if (is_file("controllers/".$controller.".php"))
	{

		//appel de la classe du controller
  		require("controllers/".$controller.".php");
		$classname = ucfirst($controller)."Controller";
		$home = new $classname();
		
		if($_GET)
		{
			$home -> index($_GET);		
		}
		else if($_POST)
		{
			//si une méthode est spécifiée dans le post
			if (isset($_POST["method"]))
			{
				//on appelle la méthode
				call_user_func(array($home,$_POST["method"]),$_POST["id"]);
			}
			
			else if (method_exists($home,"register"))
				$home->register($_POST);
			else if (method_exists($home,"modify"))
				$home -> modify($_POST);
			else if (method_exists($home,"addToCart"))
			{
				$home -> addToCart($_POST);
			}
		}
		else
		{
			$home ->index(NULL);
		file_put_contents("log.txt", date("H:i:s")." ".$_POST["id"]." index\n", FILE_APPEND);
		}
	}

	else if($_SERVER['REQUEST_URI'] =="/")
	{
		require("controllers/home.php");
		$home = new HomeController();
		$home -> index();
	}
	else
	{
		$template = $twig->load("404.twig");
		echo $template->render();
	}

}
catch(Exception $e)
{
	$template = $twig->load("404.twig");
	echo $template->render(["message"=>$e]);
}
?>
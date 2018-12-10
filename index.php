<?php
session_start();
require_once 'vendor/autoload.php';
require_once "bootstrap.php";

// authentification
$loader = new Twig_Loader_Filesystem('./view');
$twig = new Twig_Environment($loader, array('auto_reload' => true));

//expression reguliere de l'url pour récupérer le controller

$regex  = '/[\/]*([A-Z0-9a-z]+)[\/]*';
$regex .= '(([A-Z0-9a-z]*)';
$regex .= '([\?][a-zA-Z]*[\=][a-zA-Z]*';
$regex .= '([\&][a-zA-Z]*[\=][a-zA-Z]*)*';
$regex .= '\/*)*|[\/]*)/';
preg_match($regex, $_SERVER['REQUEST_URI'],$url);
$controller = $url[1];
$method = $url[3];

try
{
	if (is_file("controllers/".$controller.".php"))
	{

		//appel de la classe du controller
  		require("controllers/".$controller.".php");
		$classname = ucfirst($controller)."Controller";
		$home = new $classname();
		
		ob_flush();
        ob_start();
        //echo $_SERVER['HTTP_USER_AGENT'];
		file_put_contents("log.txt", date("H:i:s")." ".ob_get_flush()." cart\n", FILE_APPEND);
		
		if($_POST)
		{
			//si une méthode est spécifiée dans le post
			if (isset($method))
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
		
		if($_GET)
		{
			$home -> index($_GET);		
		}
		else
		{
			$home ->index(NULL);
		}
	}

	else if($_SERVER['REQUEST_URI'] =="/" || $_SERVER['REQUEST_URI'] =="/index.php")
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
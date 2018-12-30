<?php
session_start();
require_once 'vendor/autoload.php';
require_once "bootstrap.php";

// authentification
$loader = new Twig_Loader_Filesystem('./view');
$twig = new Twig_Environment($loader, array('auto_reload' => true));

//expression reguliere de l'url pour récupérer le controller et la méthode appelée
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
		
		//on appelle la méthode specifiée
		if($_POST)
			if (isset($method))
				call_user_func(array($home,$method),$_POST);
		if($_GET)
			$home -> index($_GET);		
		else
			$home ->index(NULL);
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
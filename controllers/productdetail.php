<?php 
	require_once ("./models/Product.php");

	use App\Models\Product as Product;

	
	global $twig;
	global $entityManager;

class ProductDetailController {
    
    private $twig;

    public function __construct() {
        global $twig;
        
        $this->twig = $twig;

    }
    public function index($get) {

        global $entityManager;
        //recherche d'un produit par son id
        if($get['id'])
        {
        	$product = $entityManager
           ->createQueryBuilder()
    	       ->select('p')
    	       ->from(' App\Models\Product', 'p')
    	       ->where('p.id = :id')
    	       ->setParameter('id',$get['id'])
    	       ->getQuery()
    	       ->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    	  
    	    //recherche des produits du meme type
    	   $otherproducts = $entityManager
		       ->createQueryBuilder()
		       ->select('p')
		       ->from(' App\Models\Product', 'p')
		       ->where('p.type = :type AND p.id <> :id')
		       ->orderBy('p.name', 'ASC')
		       ->setParameter('type',$product["type"])
		       ->setParameter('id',$product["id"])
		       ->setMaxResults(8)
		       ->getQuery()
		       ->getResult();	
        }
        
        $template = $this->twig->load("productdetail.twig");
        echo $template->render(["product"=>$product,"otherproducts"=>$otherproducts]);
    }
    
}
?>
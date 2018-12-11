### Doctrine
vendor/bin/doctrine orm:schema-tool:update --force  
vendor/bin/doctrine orm:generate:entities  
file_put_contents("log.txt", date("H:i:s")." ".$_POST["id"]." index\n", FILE_APPEND);

### TODO
- [ ] Vérifier la version mobile (affichage account
- [x] double affichage password et info qd submit
- [x] Affichage du header (password)
- [x] Changer les liens des méthodes
- [x] Réorganiser le code
- [x] Ajouter new
- [x] Ajouter d'autres images 
- [x] Finir de remplir la bdd
- [x] cart noti version mobile
- [x] setTimeout
- [x] sale detail product
- [x] taille onglet compte header
- [x] deconnexion dans / et /home
- [x] cart noti dans /signin
- [x] AUTRES PRODUITS QUE VOUS POURRIEZ AIMER lien bdd
- [x] Gérer le sale_price notamment pour le cart
- [x] Taille des produits quand ils sont seuls dans une liste (petits)
- [x] Résoudre affichage du prix du panier 73.99000000000001
- [x] Gérer suppression d'un article dans le panier (demande de suppression)
- [x] Gérer "Me déconnecter" quand utilisateur pas connecté (voir noti panier)
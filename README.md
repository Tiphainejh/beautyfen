### Doctrine
vendor/bin/doctrine orm:schema-tool:update --force  
vendor/bin/doctrine orm:generate:entities  
file_put_contents("log.txt", date("H:i:s")." ".$_POST["id"]." index\n", FILE_APPEND);

### TODO
- [ ] setTimeout
- [ ] cart in signin
- [ ] sale detail product
- [ ] Finir de remplir la bdd
- [ ] Ajouter d'autres images 
- [ ] Réorganiser le code
- [ ] Vérifier la version mobile
- [x] AUTRES PRODUITS QUE VOUS POURRIEZ AIMER lien bdd
- [x] Gérer le sale_price notamment pour le cart
- [x] Taille des produits quand ils sont seuls dans une liste (petits)
- [x] Résoudre affichage du prix du panier 73.99000000000001
- [x] Gérer suppression d'un article dans le panier (demande de suppression)
- [x] Gérer "Me déconnecter" quand utilisateur pas connecté (voir noti panier)
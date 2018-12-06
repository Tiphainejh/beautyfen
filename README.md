### Doctrine
vendor/bin/doctrine orm:schema-tool:update --force  
vendor/bin/doctrine orm:generate:entities  
file_put_contents("log.txt", date("H:i:s")." ".$_POST["id"]." index\n", FILE_APPEND);

### TODO

- [ ] Résoudre affichage du prix du panier 73.99000000000001
- [ ] Vérifier la version mobile
- [ ] Taille des produits quand ils sont seuls dans une liste (petits)
- [ ] Réorganiser le code
- [ ] Finir de remplir la bdd
- [ ] Ajouter d'autres images 
- [x] Gérer suppression d'un article dans le panier (demande de suppression)
- [x] Gérer "Me déconnecter" quand utilisateur pas connecté (voir noti panier)
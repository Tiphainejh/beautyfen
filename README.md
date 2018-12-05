### Doctrine
vendor/bin/doctrine orm:schema-tool:update --force
vendor/bin/doctrine orm:generate:entities

### TODO

- [ ] Gérer "Me déconnecter" quand utilisateur pas connecté (voir noti panier)
- [ ] Gérer suppression d'un article dans le panier (demande de suppression)
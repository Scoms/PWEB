TODO : 

- moyenne par promo // Laurent 
- gestion de promo 
- Jeu de données 

#Post-IT

- php app/console doctrine:database:create
- php app/console doctrine:schema:update --force
- php app/console doctrine:fixture:load

#Bundle
- Main: tout ce qui independant des donnees 
- User: inscription, authentification, deconnexion
- Data: tout ce qui concerne les donnees

#Stories


##Story 1 // Laurent -> DONE 
 l’utilisateur consulte la liste des examens auxquels il est inscrit

// Home : il faudra pouvoir consulter les examens par promo et par statut (c est assez simple je vous encourage à le faire)

Pour chaque examen de la liste, l’utilisateur peut déposer un examen (document) s’il est étudiant et
si l’examen concerne sa promo. 

S’il est chargé de cours, il peut créer un nouvel examen, gérer les
étudiants inscrits à chaque examen, // Laurent -> En cours

consulter les documents déposés par les étudiants pour chaque
examen. Pour chaque examen, la moyenne s’affiche s’il a un statut « clos ».


##Story 2 // Laurent -> DONE 
 l’utilisateur s’authentifie. 

L’utilisateur saisit un nom d’utilisateur et un mot de passe.

##Story 2 bis // Laurent -> DONE 
 l’utilisateur s’inscrit 

Son mot de passe lui est attribué automatiquement. Il a automatiquement un statut étudiant.

##Story 3  // Laurent -> DONE 
 étudiant dépose un examen 

Pour un examen donné et autorisé, l’utilisateur dépose un fichier word ou PDF correspondant à sa
« copie » d’examen.




Story 4 : l’utilisateur créé un examen // Laurent -> DONE 
Story 5 : l’utilisateur associe des étudiants à un examen // Laurent -> DONE 

Cet écran affiche la liste des étudiants inscrits à l’examen. En bas de page, une liste déroulante avec
les étudiants de la promo correspondante et un bouton « Ajouter » sont disponibles.

Story 6 : Associer une note à un document déposé. // Laurent -> DONE 
Story 7 : un utilisateur accède aux moyennes par promo 
Story 8 : un utilisateur peut gérer les promos


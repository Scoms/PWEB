php app/console doctrine:fixture:load

- utilisateur s'authentifie Laurent -> DONE
- util s'inscrit Laurent -> DONE 
- jeu de données général  
- étudiant consulte la lsite des examens. 
- etu dépose un examen
- prof crée un examen Laurent -> en cours 
- prof associe utilisateur à examens
- prof : associe note à un dépôt 
- moyenne par promo
- gestion de promo

#######update 16-04-15 :

- Il manquait le fichier EnsiieDataBundle dans \Ensiie\Bundle\DataBundle ce qui engendrait une Fatal Error venant de AppKernel.php
- Le Bundle Acme a été rm il serait également préférable d'enlever la ligne lui faisant référence dans AppKernel.php 
Cordialement Maxime

//Post-IT

- php app/console doctrine:database:create
- php app/console doctrine:schema:update --force
- php app/console doctrine:fixture:load

##Bundle
Main: tout ce qui independant des donnees 
User: inscription, authentification, deconnexion
Data: tout ce qui concerne les donnees

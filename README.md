php app/console doctrine:fixture:load

- utilisateur s'authentifie Laurent -> DONE
- util s'inscrit Laurent -> DONE 

- jeu de données général Laurent 
- étudiant consulte la lsite des examens. 
- etu dépose un examen
- prof crée un examen 
- prof associe utilisateur à examens
- prof : associe note à un dépôt 
- moyenne par promo
- gestion de promo

#######update 16-04-15 :

- Il manquait le fichier EnsiieDataBundle dans \Ensiie\Bundle\DataBundle ce qui engendrait une Fatal Error venant de AppKernel.php
- Le Bundle Acme a été rm il serait également préférable d'enlever la ligne lui faisant référence dans AppKernel.php 
Cordialement Maxime
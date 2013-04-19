php app/console doctrine:fixture:load

- étudiant consulte la lsite des examens. 
- utilisateur s'authentifie Done
- util s'inscrit Laurent
- util dépose un examen
- util crée un examen 
- util associe utilisateur à examens
- util : associe note à un dépôt 
- moyenne par promo
- gestion de promo

#######update 16-04-15 :

- Il manquait le fichier EnsiieDataBundle dans \Ensiie\Bundle\DataBundle ce qui engendrait une Fatal Error venant de AppKernel.php
- Le Bundle Acme a été rm il serait également préférable d'enlever la ligne lui faisant référence dans AppKernel.php 
Cordialement Maxime 


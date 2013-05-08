<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Ensiie\Bundle\DataBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ExamenRepository extends EntityRepository
{
 
    public function trieExamen()
    {
          return $this->createQueryBuilder('e')
                    ->add('orderBy', 'e.libelle ASC')
                    ->getQuery()
                    ->getResult();    

    }
    public function triePromo()
    {
        
        return $this->_em
                    ->createQuery('SELECT e FROM EnsiieDataBundle:Examen e, EnsiieDataBundle:Promo p
                     WHERE e.promo = p.id ORDER BY p.libelle ASC') 
                    ->getResult(); 
    }
}
?>

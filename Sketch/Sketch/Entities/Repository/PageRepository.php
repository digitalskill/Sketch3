<?php
namespace Sketch\Entities\Repository;

class PageRepository extends \Doctrine\ORM\EntityRepository
{
    use \Sketch\Traits\CRUD;
    
    public function getBlocks($id){
        $p = $this->_em->createQueryBuilder()
                ->select("p")
                ->from($this->getClassName(),"p")
                ->where("p.id = :id")
                ->setParameter("id", $id)
                ->getQuery()
                ->getOneOrNullResult();
        return $p->getBlocks();
    }
    
    
}
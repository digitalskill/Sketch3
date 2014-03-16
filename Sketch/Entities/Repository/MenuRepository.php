<?php
namespace Sketch\Entities\Repository;

class MenuRepository extends \Gedmo\Tree\Entity\Repository\MaterializedPathRepository
{
    public function getPageByStub($stub){
       return $this->_em->createQueryBuilder()
                ->select("p")
                ->from($this->getClassName(),"p")
                ->where("p.path = ?0")
                ->setParameter(0, $stub)
                ->getQuery()
                ->getOneOrNullResult();
    }
}

<?php
namespace Sketch\Entities\Repository;

class MenuRepository extends \Gedmo\Tree\Entity\Repository\MaterializedPathRepository
{
    public function getPageByStub($stub,$site){
       return $this->_em->createQueryBuilder()
                ->select("m","p","s")
                ->from($this->getClassName(),"m")
                ->join("m.page","p")
                ->join("m.site","s")
                ->where("m.path = :stub")
                ->setParameter("stub", $stub)
                ->andWhere("s.domainname = :site")
                ->setParameter("site", $site)
                ->getQuery()
                ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    
    public function getLandingPage($site){
        return $this->_em->createQueryBuilder()
                ->select("m","s")
                ->from($this->getClassName(),"m")
                ->join("m.site","s")
                ->where("m.landing = 1")
                ->andWhere("s.domainname = :site")
                ->setParameter("site", $site)
                ->getQuery()
                ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    
    public function getHoldingPage($site){
        return $this->_em->createQueryBuilder()
                ->select("m","p","s")
                ->from($this->getClassName(),"m")
                ->join("m.page","p")
                ->join("m.site","s")
                ->where("s.domainname = :site")
                ->andWhere("m.holding = 1")
                ->setParameter("site", $site)
                ->getQuery()
                ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}

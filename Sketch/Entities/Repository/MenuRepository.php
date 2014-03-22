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
    
    public function getPageById($id){
        return $this->_em->createQueryBuilder()
                ->select("m")
                ->from($this->getClassName(),"m")
                ->andWhere("m.id = :id")
                ->setParameter("id", $id)
                ->getQuery()
                ->getOneOrNullResult();
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
    
    public function getTopLevelMenuItems($websiteID,$depth = 2){
        $r = $this->_em->createQueryBuilder()
            ->select("materialized_path_entity")
            ->from($this->getClassName(),"materialized_path_entity")
            ->join("materialized_path_entity.page","p")
            ->orderBy("materialized_path_entity.id","asc")
            ->addOrderBy("materialized_path_entity.level","asc")
            ->addOrderBy("materialized_path_entity.sort","asc")
            ->where("materialized_path_entity.deleted = 0")
            ->andWhere("p.published <= CURRENT_TIMESTAMP() OR p.published IS NULL")
            ->andWhere("materialized_path_entity.site = :website")
            ->setParameter("website",$websiteID)
            ->andwhere("materialized_path_entity.level <= :depth")
            ->setParameter("depth",$depth)    
            ->getQuery()
            ->getArrayResult();
        return $this->buildTree($r);
    }
}

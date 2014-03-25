<?php
namespace Sketch\Entities\Repository;

class SiteRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSite($site)
    {
       return $this->_em->createQueryBuilder()
                ->select("s")
                ->from($this->getClassName(),"s")
                ->where("s.domainname = :site")
                ->andWhere("s.published = 1")
                ->setParameter("site", $site)
                ->getQuery()
                ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function getSiteById($id)
    {
        return $this->_em->createQueryBuilder()
                ->select("s")
                ->from($this->getClassName(),"s")
                ->where("s.id = :id")
                ->setParameter(":id", $id)
                ->getQuery()
                ->getOneOrNullResult();
    }
}

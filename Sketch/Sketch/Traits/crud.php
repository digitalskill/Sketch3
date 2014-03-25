<?php
namespace Sketch\Traits;

trait crud
{
    public function get($id,$hydrate = \Doctrine\ORM\Query::HYDRATE_ARRAY)
    {
        return $this->_em->createQueryBuilder()
                    ->select("p")
                    ->from($this->getClassName(),"p")
                    ->where("p.id = :id")
                    ->setParameter("id", $id)
                    ->getQuery()
                    ->getOneOrNullResult($hydrate);
    }
}

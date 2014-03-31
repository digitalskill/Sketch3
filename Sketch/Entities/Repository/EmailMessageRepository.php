<?php
namespace Sketch\Entities\Repository;

class EmailMessageRepository extends \Doctrine\ORM\EntityRepository
{
    use \Sketch\Traits\Crud;
    public function getByVericationEmail($email,$key)
    {
        try {
            return $this->_em->createQueryBuilder()
                ->select("e")
                ->from($this->getClassName(),"e")
                ->where("e.sendto = :email")
                ->setParameter("email", $email)
                ->andWhere("e.extensions LIKE :key")
                ->setParameter("key", '%'.$key.'%')
                ->andWhere("e.datesent > :datesent")
                ->setParameter("datesent", date('Y-m-d',strtotime('-1 day')))
                ->getQuery()
                ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        } catch (\Doctrine\ORM\NonUniqueResultException $e) {
           return false;
        }
    }
}

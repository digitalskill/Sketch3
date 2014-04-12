<?php
namespace Sketch\Entities\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    use \Sketch\Traits\Crud;
    public function login($username,$password)
    {        
        try {
            $check =  $this->_em->createQueryBuilder()
                        ->select("p")
                        ->from($this->getClassName(),"p")
                        ->where("p.login = :login")
                        ->setParameter("login", $username)
                        ->getQuery()
                        ->getOneOrNullResult();
            if($check){
                return \password_verify($password, $check->password)? $check : null;
            }
        } catch (\Doctrine\ODM\PHPCR\Query\QueryException $e) {
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getToken($token)
    {
        try {
            return $this->_em->createQueryBuilder()
                        ->select("p")
                        ->from($this->getClassName(),"p")
                        ->where("p.token = :token")
                        ->andWhere("p.tokenExpiry >= CURRENT_TIMESTAMP()")
                        ->setParameter("token", $token)
                        ->getQuery()
                        ->getOneOrNullResult();
        } catch (\Doctrine\ODM\PHPCR\Query\QueryException $e) {
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

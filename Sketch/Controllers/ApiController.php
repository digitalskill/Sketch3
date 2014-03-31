<?php
namespace Sketch\Controllers;

class ApiController extends \Sketch\Helpers\API
{
    protected $User;
    protected $em;

    /**
     *
     */
    public function __construct()
    {
        $this->entityManager = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
        }
        try {
            $url     = \Sketch\Sketch::$instance->url;
            unset($url[0]);         // Remove API
            unset($url[1]);         // Remove Version
            $this->startAPI(["request"=>join("/",$url)],$_SERVER['HTTP_ORIGIN']);
        } catch (\Exception $e) {
            echo $this->_response("An Error Occured: ". $e->getMessage(),500);
            die();
        }
    }

    /**
     *
     * @return boolean
     */
    public function authenticate()
    {
        $user           = false;
        $browserDetails = $_SERVER['HTTP_USER_AGENT'];
        $browserDetails .= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $token          = sha1($browserDetails.$_SERVER['REMOTE_ADDR']);
        if (isset($this->request['token'])) {         // Get token from database
            $user = $this->entityManager->getRepository("Sketch\Entities\User")->getToken($this->request['token']);
            if (!$user || $this->request['token'] != $token || $user->token != $token) {  // Lets be really aggressive
                echo $this->_response("Not Authorised",401);
                die();
            } else {
                $user->tokenExpiry  = new \DateTime();
                $user->tokenExpiry->setTimestamp(strtotime('+20 minutes'));
                $this->entityManager->persist($user);       // Update the token Expiry time
                $this->entityManager->flush();              // Commit the new time to the db
                $this->User = $user;

                return true;                                // User is Valid
            }
        } elseif (isset($this->request['login']) && isset($this->request['password'])) {
            $user = $this->entityManager->getRepository("Sketch\Entities\User")->login($this->request['login'],$this->request['password']);
            if (!$user) {
                echo $this->_response("Wrong login credentials provided",401);
                die();
            } else {
                $user->token        = $token;
                $user->tokenExpiry  = new \DateTime();
                $user->tokenExpiry->setTimestamp(strtotime('+20 minutes'));
                $this->entityManager->persist($user);       // Update the token Expiry time
                $this->entityManager->flush();              // Commit the new time to the db
                $this->User = $user;
                echo $this->_response(["token"=>$token],200);
                die();
            }
        }

        return false;
    }

    /**
     *
     * @param array  $request
     * @param string $origin
     */
    public function startAPI(array $request, $origin)
    {
        parent::process($request['request']);
        if ($this->endpoint == 'deploy' && isset($this->request['token']) && $this->request['token'] == 'sketchstart') {
            echo $this->deploy();
            die();
        }
        if (!$this->authenticate()) {
            echo $this->_response("Not Authorised",401);
            die();
        }
        echo $this->processAPI();
    }

    public function deploy($args='')
    {
        if (is_file(SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php")) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
            $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
            try {
                $schemaTool->dropDatabase();
                $schemaTool->createSchema($classes);
                include_once(SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php");
                if (!unlink(SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php")) {
                    return $this->_response("SITE SETUP - PLEASE DELETE THE SETUP FILE: ".SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php");
                }
            } catch (\Exception $e) {
                return $this->_response(array("Cannot Create database: ". $e->getMessage()),500);
            } catch (\PDOException $e) {
                return $this->_response(array("Cannot Create database: ". $e->getMessage()),500);
            }

        } else {
            try {
                $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
                $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
                $schemaTool->updateSchema($classes);
            } catch (\Exception $e) {
                return $this->_response(array("Cannot update database: ". $e->getMessage()),500);
            } catch (\PDOException $e) {
                return $this->_response(array("Cannot update database: ". $e->getMessage()),500);
            }

            return $this->_response(array("Database Entities Updated"),200);
        }

        return $this->_response(array("Site setup Complete"),200);
    }

    public function updateDatabase()
    {
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
        try {
            $schemaTool->updateSchema($classes);
        } catch (\Exception $e) {
            return $this->_response("Cannot update database: ". $e->getMessage(),500);
        }
    }
}

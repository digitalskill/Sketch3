<?php
namespace Sketch\Controllers;

class ApiController extends \Sketch\Helpers\API
{
    protected $User;
    protected $em;
    protected $roles = ["Admin"         =>  ["GET","POST","PUT","DELETE"],
                        "Member"        =>  [""],
                        "Viewer"        =>  ["GET"],
                        "Contributor"   =>  ["GET","POST","PUT"],
                        "Editor"        =>  ['GET',"POST"]
                ];
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
        if (isset($this->request['token'])) {         // Get token from database
            $user           = $this->entityManager->getRepository("Sketch\Entities\User")->getToken($this->request['token']);
            $userid         = $user != null? $user->id : '';
            $tokenExpiry    = $user != null? $user->tokenExpiry->format('dmyhis') : '';
            $token          = sha1($userid.$browserDetails.$_SERVER['REMOTE_ADDR']);
            if (!$user || $this->request['token'] != $token || $user->token != $token || $_SESSION['ch'] != sha1($tokenExpiry.$token)) {  // Lets be really aggressive
                echo $this->_response("Not Authorised",401);
                unset($_SESSION['ch']);
                session_destroy();
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
                unset($_SESSION['ch']);
                session_destroy();
                die();
            } else {
                $user->tokenExpiry  = new \DateTime();
                $user->tokenExpiry->setTimestamp(strtotime('+20 minutes')); 
                $userid         = $user != null? $user->id : '';
                $tokenExpiry    = $user != null? $user->tokenExpiry->format('dmyhis') : '';
                $token          = sha1($userid.$browserDetails.$_SERVER['REMOTE_ADDR']);
                $user->token        = $token;
                $this->entityManager->persist($user);       // Update the token Expiry time
                $this->entityManager->flush();              // Commit the new time to the db
                $this->User = $user;
                
                $_SESSION['ch']     = sha1($tokenExpiry.$token);
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
        if(isset($this->request['setup']) 
                && $this->request['setup']=="setup" 
                && $this->endpoint=="deploy"  
                && is_file(SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php") 
                && $this->method=="POST"){
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
        $setupFile = SITE_ROOT.DIRECTORY_SEPARATOR."setup".DIRECTORY_SEPARATOR."setup.php";
        if(($this->User && $this->User->type=="Admin") || (isset($this->request['setup']) && $this->request['setup']=="setup" && is_file($setupFile) && $this->endpoint == "deploy")){
            if (is_file($setupFile)) {
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
                    return $this->_response("Cannot Create database: ". $e->getMessage(),500);
                }
            } else {
                try {
                    $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
                    $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
                    $schemaTool->updateSchema($classes);
                } catch (\Exception $e) {
                    return $this->_response("Cannot update database: ". $e->getMessage(),500);
                }
                return $this->_response("Database Entities Updated",200);
            }
            return $this->_response("Site setup Complete",200);
        }
        return $this->_response("Not Authorised",401);
    }

    public function updateDatabase()
    {
        if($this->User->type=="Admin"){
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
            $classes    = $this->entityManager->getMetadataFactory()->getAllMetadata();
            try {
                $schemaTool->updateSchema($classes);
            } catch (\Exception $e) {
                return $this->_response("Cannot update database: ". $e->getMessage(),500);
            }
        }else{
            return $this->_response("Not Authorised",401); 
        }
    }
}

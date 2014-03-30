<?php
namespace Sketch\Helpers;

require SKETCH_CORE.DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR.
            "/swiftmailer/swiftmailer/lib/swift_required.php";  // Auto Load Swift Mailer

class Email extends \Swift_Message
{
    private $message;
    private $transport;
    private $mailer;
    private $emailBackup;
    private $em;
    /**
     *
     * @param string $domain
     * @param string $pass
     * @param string $user
     * @param string $port
     */
    public function createTransport()
    {
        if (\Sketch\Sketch::$instance->getConfig('email_transport')==false) {
            $this->transport    = \Swift_MailTransport::newInstance();
        } else {
            if (\Sketch\Sketch::$instance->getConfig('email_transport')=="smtp") {
                $domain =   \Sketch\Sketch::$instance->getConfig('email_domain');
                $port   =   \Sketch\Sketch::$instance->getConfig('email_port');
                $user   =   \Sketch\Sketch::$instance->getConfig('email_user');
                $pass   =   \Sketch\Sketch::$instance->getConfig('email_pass');
                $this->transport    = \Swift_SmtpTransport::newInstance($domain, $port)
                                        ->setUsername($user)
                                        ->setPassword($pass);
            } else {
                if (\Sketch\Sketch::$instance->getConfig('email_transport')=="sendmail") {
                    $this->transport    = \Swift_SendmailTransport::newInstance();
                }
            }
        }
    }

    /**
     *
     * @param  string                $to
     * @param  string                $from
     * @param  string                $subject
     * @param  string                $htmlMessage
     * @param  string                $textMessage
     * @param  string                $files
     * @return \Sketch\Helpers\Email
     */
    public function __construct($to,$from,$subject,$htmlMessage,$textMessage = '',$files='')
    {
        parent::__construct();
        if ($textMessage == '') {
            $textMessage = strip_tags(str_replace(array("</p>","</li>","<br />","</h1>","<h2>","</h3>","</h4>"),"\r\n",$htmlMessage));
        }
        $data               = $_REQUEST;
        $data["sendto"]     = $to;
        $data["sentfrom"]   = $from;
        $data["subject"]    = $subject;
        $data["datesent"]   = new \DateTime();
        $data["message"]    = $htmlMessage;
        $data['formpage']   = join("/",\Sketch\Sketch::$instance->url);
        $data['emailresult']= '';
        $this->em           = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
        $this->emailBackup  = $this->em->getRepository("Sketch\Entities\EmailMessage")->add($data);
        $this->createTransport();
        $this->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($textMessage)
                ->addPart($htmlMessage, 'text/html');
        return $this;
    }

    /**
     *
     * @return bool
     */
    public function sendEmail()
    {
        $this->mailer   = \Swift_Mailer::newInstance($this->transport);
        $result         = $this->mailer->send($this);
        $this->emailBackup->emailresult = $result;
        $this->em->persist($this->emailBackup);
        $this->em->flush();

        return $result;
    }
}

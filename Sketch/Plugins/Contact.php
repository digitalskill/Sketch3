<?php
namespace Sketch\Plugins;

use Sketch\Helpers\Email;

class Contact extends Plugin
{
    private $contactForm;

    public function __construct()
    {
        parent::__construct();
        $formPath = SITE_ROOT.DIRECTORY_SEPARATOR.
                    \Sketch\Sketch::$instance->getConfig("themePath").
                    DIRECTORY_SEPARATOR."forms".DIRECTORY_SEPARATOR."Contact.php";

        $this->contactForm   = new \Sketch\Helpers\Form($formPath,$_POST);
        if (isset($_POST['email']) && isset($_POST['hp']) && $_POST['hp']=='') {
            if ($this->contactForm->isValid()) {
                $this->sendEmail();
            }
        }
        \Sketch\Sketch::$instance->setForm("contact",$this->contactForm);
    }

    private function sendEmail()
    {
        $emailContent   = file_get_contents(SITE_ROOT.DIRECTORY_SEPARATOR.
                            \Sketch\Sketch::$instance->getConfig("themePath").
                            DIRECTORY_SEPARATOR."emails".DIRECTORY_SEPARATOR."index.php");

        $data           = $this->contactForm->getValues();
        $data['message']= "<h2>Hello from ".$data['name']."</h2><p>The contact form has been filled in and this is what ".$data['name']." has said: </p>".$data['message'];
        $to             = \Sketch\Sketch::$instance->getConfig('siteemail');
        $subject        = 'Welcome to Sketch';
        $from           = $data['email'];
        $footerlinks    = "";
        $actionlink     = "<p>Visit our site <a href='".\Sketch\Sketch::$instance->basePath()."'>".\Sketch\Sketch::$instance->getConfig('sitename')."</a></p>";
        $htmlMessage    = str_replace(array("#MESSAGE#","#ACTIONLINK#","#SITEPHONE#","#SITEEMAIL#","#FOOTERLINKS#","#SUBJECT#","#DATE#","#SITELOGO#"),
                                        array($data['message'],$actionlink,\Sketch\Sketch::$instance->getConfig('sitephone'),
                                                \Sketch\Sketch::$instance->getConfig('siteemail'),$footerlinks,
                                        $subject,date("j, F Y h:i"),\Sketch\Sketch::$instance->getConfig('sitelogo')),
                                        $emailContent);
        $mail           = new Email($to, $from, $subject, $htmlMessage);
        if ($mail->sendEmail()) {
            header("Location: /Contact/Thankyou");
            exit;
        } else {
            \Sketch\Sketch::$instance->status   = "404";
            \Sketch\Sketch::$instance->errors[] = "Cannot send Email";
        }
    }
}

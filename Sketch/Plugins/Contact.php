<?php
namespace Sketch\Plugins;

use Sketch\Helpers\Email;

class Contact extends Plugin
{
    public $contactForm;
    public $form           = "Contact.php";
    public $subject        = "Website Comments";
    public $emailTemplate  = "adminemail.php";
    public $thanksPage     = "Contact/Thankyou";
    public $to;
    public $from;
    public $replyto;
    public function __construct()
    {
        parent::__construct();
        $this->to       = \Sketch\Sketch::$instance->getConfig('siteemail');
        $this->from     = \Sketch\Sketch::$instance->getConfig('siteemail');
        $this->replyto  = \Sketch\Sketch::$instance->getConfig('siteemail');
        $formPath = SITE_ROOT.DIRECTORY_SEPARATOR.
                    \Sketch\Sketch::$instance->getConfig("themePath").
                    DIRECTORY_SEPARATOR."forms".DIRECTORY_SEPARATOR.$this->form;

        $this->contactForm   = new \Sketch\Helpers\Form($formPath,$_POST);
        if (isset($_POST['email']) && isset($_POST['hp']) && $_POST['hp']=='') {
            if ($this->contactForm->isValid()) {
                $this->sendEmail();
            }
        }
        \Sketch\Sketch::$instance->setForm(str_replace(".php",'',$this->form),$this->contactForm);
    }
    
    public function prepareMessage($data){
        $message = '<table class="twelve columns">';
        foreach($data as $key => $value){
            if($key != "hp"){
                $message .= '<tr><td class="three sub-columns">'.$key.'</td>';
                $message .= '<td class="nine sub-columns last">'.$value.'</td>';
                $message .= '<td class="expander"></td></tr>';
            }
        }
        $message .= '</table>';
        return $message;
    }
    
    public function sendEmail()
    {
        $emailContent   = file_get_contents(SITE_ROOT.DIRECTORY_SEPARATOR.
                            \Sketch\Sketch::$instance->getConfig("themePath").
                            DIRECTORY_SEPARATOR."emails".DIRECTORY_SEPARATOR.$this->emailTemplate);
        $data           = $this->contactForm->getValues();
        $message        = $this->prepareMessage($data);
        $to             = $this->to;
        $subject        = $this->subject;
        $from           = $this->from;
        $replyto        = $this->replyto;
        $footerlinks    = '<p><a href="'.\Sketch\Sketch::$instance->basePath("Contact\Unsubscribe").'"><unsubscribe>Unsubscribe</unsubscribe></a></p>';
        $actionlink     = "<p>Visit our site <a href='".\Sketch\Sketch::$instance->basePath()."'>".\Sketch\Sketch::$instance->getConfig('sitename')."</a></p>";
        $htmlMessage    = str_replace(array("#MESSAGE#","#ACTIONLINK#","#SITEPHONE#","#SITEEMAIL#","#FOOTERLINKS#","#SUBJECT#","#DATE#","#SITELOGO#"),
                                        array($message,$actionlink,\Sketch\Sketch::$instance->getConfig('sitephone'),
                                                \Sketch\Sketch::$instance->getConfig('siteemail'),$footerlinks,
                                        $subject,date("j, F Y h:i"),\Sketch\Sketch::$instance->getConfig('sitelogo')),
                                        $emailContent);
        $mail           = new Email($to,$from, $subject, $htmlMessage);
        $mail->addReplyTo($replyto);
        if ($mail->sendEmail()) {
            $path = \Sketch\Sketch::$instance->basePath($this->thanksPage);
            header("Location: ".$path);
            exit;
        } else {
            \Sketch\Sketch::$instance->status   = "404";
            \Sketch\Sketch::$instance->errors[] = "Cannot send Email";
        }
    }
    
    public function sendAdminEmail($subject,$from,$message){
        $emailContent   = file_get_contents(SITE_ROOT.DIRECTORY_SEPARATOR.
                                    \Sketch\Sketch::$instance->getConfig("themePath").
                                    DIRECTORY_SEPARATOR."emails".DIRECTORY_SEPARATOR."adminemail.php");   
        $htmlMessage    = str_replace(array("#MESSAGE#","#SUBJECT#","#DATE#","#SITELOGO#"),
                                array($message,
                                        $subject,date("j, F Y h:i"),
                                        \Sketch\Sketch::$instance->basePath(\Sketch\Sketch::$instance->getConfig('sitelogo'))),
                                        $emailContent);

        $adminEmail             = new Email(\Sketch\Sketch::$instance->getConfig('siteemail'),
                                            \Sketch\Sketch::$instance->getConfig('siteemail'), 
                                            $subject, 
                                            $htmlMessage);
        $adminEmail->addReplyTo($from);
        $adminEmail->sendEmail();
        
        
        
    }
}

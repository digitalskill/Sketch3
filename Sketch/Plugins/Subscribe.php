<?php
namespace Sketch\Plugins;

class Subscribe extends Contact
{
    public $form           = "Subscribe.php";
    public $subject        = "New website subscription";
    public $emailTemplate  = "index.php";
    public $thanksPage     = "Contact/Subscribe";
    private $doThanksMessage = false;

    public function __construct()
    {
        parent::__construct();
        if (isset($_GET['verifykey']) && isset($_GET['verifykey'])) {
            $this->sendEmail();
        }
    }

    public function sendEmail()
    {
        if (!isset($_GET['verifykey'])) {
            $this->to           = $_POST['email'];
            $this->contactForm  = $this;
            $this->thanksPage   = "Contact/Subscribe/Verify";
            $this->subject      = "Please verify your email address";
        } else {
            // Get person from the database
            $em = \Sketch\Sketch::$instance->getEntityManager()->entityManager;
            $person = $em->getRepository("Sketch\Entities\EmailMessage")
                            ->getByVericationEmail($_GET['email'],$_GET['verifykey']);
            if ($person) {
                $details = $person['extensions'];
                $details['subscribed'] = 1;
                $details['firstname']  = $details['name'];
                $details['login']      = $person['sendto'];
                $details['password']   = 'New_Subscriber';
                $details['type']       = 'subscriber';
                $em->getRepository("Sketch\Entities\User")->add($details);
                $this->contactForm      = $this;
                $this->doThanksMessage  = true;
                $this->to               = $details['email'];
                $message                = parent::prepareMessage(array(
                    "Name"  => $details['name'],
                    "Email" => $details['email'],
                    "subscribed Date" => \Date("Y-m-d h:i:s"),
                    "Verified Email"  => "Yes",
                ));
                $this->sendAdminEmail("A new subscriber", $details['email'], $message);
            } else {
                header("location: /Contact/Subscribe/Verify/Failed");
                exit;
            }
        }
        parent::sendEmail();
    }

    public function prepareMessage($data)
    {
        $message = '';
        foreach ($data as $key => $value) {
            $message .= $value;
        }

        return $message;
    }

    public function getValues()
    {
        if ($this->doThanksMessage) {
            return array("<h3>Thanks for joining our mailing list<h3>",
                         "<p>You can unsubscribe at any time using the the unsubscribe link at the bottom of the emails</p>",
            );
        } else {
            $key = md5(date("Y-m-d h:i:s").$_POST['email']);

            return array("<h3>Please click the link below</h3></p>This will allow us to add you to our mailing list</p>",
                            "<p><a href='".
                    \Sketch\Sketch::$instance->basePath(\Sketch\Sketch::$instance->getMenuValues("path")).
                    "?email=".$_POST['email']."&verifykey=".$key.
                    "'>".
                    \Sketch\Sketch::$instance->basePath(\Sketch\Sketch::$instance->getMenuValues("path")).
                    "?email=".$_POST['email']."&verifykey=".$key."</a></p>");
        }
    }
}

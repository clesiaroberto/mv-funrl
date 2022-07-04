<?php
    require '../lib/PHPMailer/class.phpmailer.php';

    class mail extends PHPMailer {

        function sendmail($name = "", $mail = "", $subject = "", $body = "") {
            $this->IsSMTP();								//Sets Mailer to send message using SMTP
            $this->Host = 'mail.movelcare.co.mz';		    //Sets the SMTP hosts of your Email hosting, this for Godaddy
            $this->Port = '587';							//Sets the default SMTP server port
            $this->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
            $this->Username = 'funeral@movelcare.co.mz';	//Sets SMTP username
            $this->Password = 'f#n1EEl209';					//Sets SMTP password
            $this->SMTPSecure = 'SSL';						//Sets connection prefix. Options are "", "ssl" or "tls"
            $this->From = 'funeral@movelcare.co.mz';		//Sets the From email address for the message
            $this->FromName = 'MovelCare';				    //Sets the From name of the message
            $this->AddAddress($mail, $name);	            //Adds a "To" address
            $this->WordWrap = 10000;						//Sets word wrapping on the body of the message to a given number of characters
            $this->IsHTML(true);						    //Sets message type to HTML
            $this->Subject = $subject;				        //Sets the Subject of the message
            $this->Body = $body;                            //An HTML or plain text message body
            return $this->Send();						    //Send an Email. Return true on success or false on error
        }
    }
    
?>
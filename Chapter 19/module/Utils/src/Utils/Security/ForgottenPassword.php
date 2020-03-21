<?php

namespace Utils\Security;

class ForgottenPassword {
    
    /**
     * Resets the current user's password and sent that new generated password to the email address.
     *
     * @param string $email user's email
     * 
     * @return boolean
     */
    public function resetPassword($email) {
        $users = new Model_Users();
        $user = $users->getBy(array('email' => $email, 'limit' => 1));
        $lang = Locale_Translate::getInstance();
        
        if ($user) {
            //generate and reset current password
            $allowedChars = '234578QWERTYUPASDFGHJKLZXCVBNM';
            $shuffle = str_shuffle($allowedChars);
            $passwd = substr($shuffle, 0, rand(7, 7));
            //echo $passwd;

            $newPassword = Validate_Validator::sha2($passwd, $user->getSalt());
            $sqlArray['password'] = $newPassword['hash'];

            $users->update($sqlArray, 'id='.$user['id']);
            Email_Messages::send(
                $email, 
                $lang->_('email.resetPassword.title'), 
                $lang->_('email.resetPassword.message', array($passwd)),
                array('theme_id' => Email_Messages::THEME_ZAPLANUJTRANSPORT)
            );

            return true;
        } else {
            return false;
        }
    }

    /*private function sendEmail($password, $email){
        $lang = Locale_Translate::getInstance();
            $subject = $lang->translate('mail.forgottenPassword.title');
            
            $message = $lang->translate('mail.forgottenPassword.text')."<br />";
            $message .= $password;
            $message .= $lang->translate('mail.footer');
            
            $headers ='From: '.$lang->translate('mail.from'). "\r\n";
            $headers .='Reply-To: '.$lang->translate('mail.from'). "\r\n";
            $headers .='Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .='X-Mailer: PHP/'.phpversion();		
            mail($email, $subject, $message, $headers);
    }*/
}
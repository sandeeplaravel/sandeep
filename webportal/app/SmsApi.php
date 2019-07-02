<?php
namespace app;

/**
* class TextLocal to send SMS on Mobile Numbers.
* @author Lucky Wankhede
*/
class SmsApi {

    function __construct() {

    }
    //?apiKey=CPOy5D0efOk-w7husQhbzVKAnqenFw47FuRkeHVTIG&sender=TXTLCL&numbers=9993479764&message=HelloAaayu
    private $API_KEY = 'dp9HzyUbKjQ-glDmaV1PpWzovTH2ZbOqdYS1a5gnzj';

    private $SENDER_ID = "FXJOBS";
    private $ROUTE_NO = 4;
    private $RESPONSE_TYPE = 'json';

    public function sendSMS($OTP, $mobileNumber){
        $isError = 0;
        $errorMessage = true;

        //Your message to send, Adding URL encoding.
        $message = rawurlencode("Thank you for registering with foxiJobs.com. Your verification code is $OTP.");

        //Preparing post parameters
        $postData = array(
            'apiKey' => $this->API_KEY,
            'sender' => $this->SENDER_ID,
            'numbers' => $mobileNumber,
            'message' => $message,
        );
        
        $url = "https://api.textlocal.in/send/";
     
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));
     
     
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     
     
        //get response
        $output = curl_exec($ch);
     
        //Print error if any
        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }
        curl_close($ch);
        if($isError){
            return array('error' => 1 , 'message' => $errorMessage);
        }else{
            return array('error' => 0 );
        }
    }
    
    public function sendResetPassword($OTP, $mobileNumber){
        $isError = 0;
        $errorMessage = true;

        //Your message to send, Adding URL encoding.
        $message = rawurlencode("We have recieved your account password reset request for FoxiJobs.com. Your verification code is : $OTP");
     

        //Preparing post parameters
        $postData = array(
            'apiKey' => $this->API_KEY,
            'sender' => $this->SENDER_ID,
            'numbers' => $mobileNumber,
            'message' => $message,
        );
     
        $url = "https://api.textlocal.in/send/";
     
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));
     
     
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     
     
        //get response
        $output = curl_exec($ch);
     
        //Print error if any
        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }
        curl_close($ch);
        if($isError){
            return array('error' => 1 , 'message' => $errorMessage);
        }else{
            return array('error' => 0 );
        }
    }
}
?>
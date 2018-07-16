<?php 

class Push {
    //notification title
    private $title;

    //notification message 
    private $message;

    //initializing values in this constructor
    function __construct($title, $message) {
         $this->title = $title;
         $this->message = $message; 
    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['title'] = $this->title;
        $res['message'] = $this->message;
        return $res;
    }
 
}
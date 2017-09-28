<?php namespace scfr\oauth\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
    
    /**
    * Constructor
    */
    public function __construct() {
        
    }
    
    static public function getSubscribedEvents()
    {
        return array(

        );
    }
    
    

    
}
?>
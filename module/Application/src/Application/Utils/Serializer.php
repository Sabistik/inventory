<?php

namespace Application\Utils;

use JMS\Serializer as JMS;

class Serializer {
    
    public static function entityToArray($object)
    {
        $oSerializer = JMS\SerializerBuilder::create()->build();
        $array = $oSerializer->toArray($object, JMS\SerializationContext::create()->enableMaxDepthChecks());
        
        return $array;
    }
}


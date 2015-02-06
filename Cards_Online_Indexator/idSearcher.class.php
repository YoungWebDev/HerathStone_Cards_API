<?php

class idSearcher
{
    protected $CardsInfoFileName = "cards_info.json";
    
    protected $CardsIDFileName = "cards_id.json";
    
    protected $CardsInfo = [];
    
    protected $CardsID = [];
    
    protected $CardsKinds = [
        "Basic" => true,
        "Classic" => true,
        "Credits" => true,
        "Debug" => false, // Wont be indexed
        "Goblins vs Gnomes" => true,
        "Missions" => true,
        "Promotion" => true,
        "Reward" => true,
        "System" => false // Wont be indexed
        
    ];
    
    public function __construct()
    {
        $this->CardsInfo = $this->decodeCardsInfo();
    }
    
    public function run()
    {
        return $this->getCardsID();
    }
     
    
    protected function decodeCardsInfo()
    {
        $decoded = json_decode($this->openCardsInfo(), true);
        return $decoded;
    }
    
    protected function openCardsInfo()
    {
        return file_get_contents($this->CardsInfoFileName);
    }
    
    protected function getCardsID()
    {
        foreach($this->CardsKinds as $kindName => $index)
        {
            $index ? $this->searchOnlyID($kindName) : false;
        }
        
        return $this->saveToJson();
        
    }
    
    protected function searchOnlyID($kindName)
    {
        foreach($this->CardsInfo[$kindName] as $a => $b)
        {
            array_push( $this->CardsID, $b["id"] );
        }
    }
    
    protected function saveToJson()
    {
        $encoded = json_encode($this->CardsID);
        
        $handler = fopen($this->CardsIDFileName, "w");
        
        $save    = fwrite($handler, $encoded);
        
        $close   = fclose($handler);
        
        return $save ? true : false;
        
    }
    
}

$index = new idSearcher;

$run = $index->run();

echo $run ? "true" : "false";
<?php

class cardsIndexer
{
    protected $cardsIDFileName = "cards_id.json";
    
    protected $cardsFolder = "cards/";
    
    protected $cardsID = [];
    
    public function __construct()
    {
        $this->cardsID = json_decode( file_get_contents($this->cardsIDFileName) );
        
         if( !is_dir($this->cardsFolder) )
        {
            mkdir($this->cardsFolder, 0777);
        }
        
    }
    
    public function run()
    {
        $this->index();
    }
    
    protected function index()
    {
        
        foreach($this->cardsID as $ID)
        {
            if ( !file_exists($this->cardsFolder.$ID."/".$ID.".png") && !file_exists($this->cardsFolder.$ID."/".$ID."_gold.gif"))
            {
            // NORAML
            
            $url = "http://wow.zamimg.com/images/hearthstone/cards/enus/original/"; // id.png
            
            $normal = file_get_contents($url.$ID.".png");
            
            $this->save($ID, ".png", $normal);
            
            //GOLD
            
            
            $url = "http://wow.zamimg.com/images/hearthstone/cards/enus/animated/"; // id_premium.gif
            
            $gold = file_get_contents($url.$ID."_premium.gif");
            
            $this->save($ID, "_gold.gif", $gold);
                
            }
        }
        
    }
    
    protected function save($cardID, $type, $img)
    {
        if( !is_dir($this->cardsFolder.$cardID) )
        {
            mkdir($this->cardsFolder.$cardID, 0777);
        }
        
        $sdir = $this->cardsFolder.$cardID."/".$cardID.$type;
        
        if( !file_exists($sdir) )
        {
            file_put_contents($sdir, $img);   
        }
        
    }
}

$a = new cardsIndexer;
$a->run();
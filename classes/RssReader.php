<?php 

class RssReader{
	protected $rsspage;
	
	public function __construct($rsspage){
		$this->rsspage = $rsspage;		
	}
	
	public function getRss(){		
		try{		
		$xml = new SimpleXMLElement($this->rsspage, null, true);
		
		foreach ($xml->channel->item as $node){
			$contents = file_get_contents($node->guid);
			
			$pdf = new PdfWriter();
			
			$pdf->createPage($contents);
		}
		
		return $xml;
		}catch(Exception $e){
			var_dump($e->getMessage());
		}		
	}
}


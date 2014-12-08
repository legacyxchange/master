<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cron_model extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
    }

	public function buildsitemap ()
	{
		//echo "DOC ROOT: {$_SERVER['DOCUMENT_ROOT']}" . PHP_EOL; exit;
	
		$file = $_SERVER['DOCUMENT_ROOT'] . "sitemap.xml";
		
		// gets location IDs
		$locations = $this->getLocationIDs();
	
		// first deletes any old sitemaps
		@unlink($file);
	
		// create sitemap file
		$create = touch($file);
		
		if ($create === false) throw new Exception("Unable to create new {$file}");
		
		$fp = fopen($file, 'w');
		
		if ($fp === false) throw new Exception("Unable to open file for writing! {$file}");
		
		fwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
		
		fwrite($fp, '<urlset xmlns="http://www.google.com/schemas/sitemap/0.90">' . PHP_EOL);
		
		if (!empty($locations))
		{
			foreach ($locations as $r)
			{
				fwrite($fp, "\t<loc>http://karate.com/dojos/info/{$r->id}</loc>" . PHP_EOL);
				fwrite($fp, "\t<lastmod>" . date('Y-m-d\TH:i:sP') . "</lastmod>" . PHP_EOL);
				fwrite($fp, "\t<changefreq>weekly</changefreq>" . PHP_EOL);
				fwrite($fp, "\t<priority>0.5</priority>" . PHP_EOL);
			}
		}
		
		
		fwrite($fp, '</urlset>');
		
		fclose($fp);
	}
    
    private function getLocationIDs ()
    {
	    $mtag = "locations";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
        	$this->db->select('id');
        	$this->db->from('locations');
			$this->db->where('active', 1);
			$this->db->where('deleted', 0);
			$this->db->where('company', $this->config->item('bmsCompanyID'));
			
			$query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
        
        return $data;
    }
    
}
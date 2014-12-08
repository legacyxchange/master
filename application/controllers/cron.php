<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    function Cron ()
    {
        parent::__construct();
     
		if (PHP_SAPI == 'cli') $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(__FILE__))) . '/';
        
        $this->load->driver('cache');
        $this->load->model('cron_model', 'cron', true);
    }

	/**
	* Generates the sitemap XML
	*/
	public function buildsitemap ()
	{
		try
		{
			$this->cron->buildsitemap();
		}
		catch (Exception $e)
		{
			$this->functions->sendStackTrace($e);
		}
	}
}
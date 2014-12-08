<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!defined('DATESTAMP')) DEFINE('DATESTAMP', date('Y-m-d G:i:s'));
if (!defined('DS')) DEFINE('DS', DIRECTORY_SEPARATOR);
if (!defined('EOL')) DEFINE('EOL', PHP_EOL);
if (!defined('TAB')) DEFINE('TAB', "\t");

if (!defined('DYNAMIC')) DEFINE('DYNAMIC', isset($_GET['dynamic']));



class bms_pre_system
{
	protected $filepath;
	
	function __construct ()
	{
		//parent::__construct();
	}
	
	public function initialize ()
	{
		print_r($_SERVER);
		
		if (!$system_folder) $system_folder = "system";
		
		if (!$application_folder) $application_folder = 'application';
		
		
		// sets server path
		if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
		{
			$root_path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
			$system_folder = $root_path . DS . $system_folder;

		  //  $system_folder = str_replace("\\", "/", realpath($system_folder)).'/'.$system_folder;
		}

		/*
		* DEFINE APPLICATION CONSTANTS
		|
		| EXT        - The file extension.  Typically ".php"
		| FCPATH    - The full server path to THIS file
		| SELF        - The name of THIS file &#40;typically "index.php&#41;
		| BASEPATH    - The full server path to the "system" folder
		| APPPATH    - The full server path to the "application" folder
		|
		*/

		define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
		define('FCPATH', __FILE__);
		define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
		define('BASEPATH', $system_folder.'/');
		

		if (is_dir($application_folder))
		{
			$appp = $root_path . DS . $application_folder . DS;
		    define('APPPATH', $appp);
		}
		else
		{
		    if ($application_folder == '')
		    {
		        $application_folder = 'application';
		    }

		    define('APPPATH', BASEPATH.$application_folder.'/');
		}
		
		print_r(APPPATH);
		
		if ( ! defined('E_STRICT'))
		{
		    define('E_STRICT', 2048);
		}

		echo BASEPATH.'codeigniter/Common'.EXT;
		require(BASEPATH.'codeigniter/Common'.EXT);
		
		
		set_error_handler('_exception_handler');
		set_magic_quotes_runtime(0); // Kill magic quotes

		/*
		 * ------------------------------------------------------
		 *  Instantiate the base classes
		 * ------------------------------------------------------
		 */

		$CFG =& load_class('Config');
		$LANG =& load_class('Language');
		
		require(BASEPATH.'codeigniter/Base5'.EXT);
		
		$ci = load_class('Controller');

		print_r($ci);
		
		error_log($ci);

		try
		{
			// includes trait files
			$this->filepath = dirname(dirname(__FILE__));
			
			$this->filepath = rtrim($this->filepath, '/') . DS; // ensure path ends with a directory seperaator
	
			$path = $this->filepath . 'traits' . DS;
			
			if (is_dir($path))
			{
				$files = scandir($path);
				
				$files = array_diff($files, array('.', '..'));
				
				if (!empty($files))
				{
					foreach ($files as $file)
					{
						//require_once $path . $file;
					}
				}
			}
			
		
			self::create_controller_symlink($this->filepath);
		}
		catch (Exception $e)
		{
			error_log($e);
			
			return false;
		}
		
		return true;
	}
	
	private static function create_controller_symlink ($path)
	{
		
		
		$pathFrom = $path . 'controllers/js.php';
		

		
		$pathTo = dirname(dirname($path)) . DS . 'controllers/js.php';

		error_log($pathFrom);
		error_log($pathTo);
		
		$link = symlink($pathFrom, $pathTo);
	
		if ($link === false) throw new Exception("Unable to create BMS controller symlink");
	
		return true;
	}

}
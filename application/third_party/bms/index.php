<?php


if (!defined('DATESTAMP')) DEFINE('DATESTAMP', date('Y-m-d G:i:s'));
if (!defined('DS')) DEFINE('DS', DIRECTORY_SEPARATOR);
if (!defined('EOL')) DEFINE('EOL', PHP_EOL);
if (!defined('TAB')) DEFINE('TAB', "\t");

if (!defined('DYNAMIC')) DEFINE('DYNAMIC', isset($_GET['dynamic']));

class bmsLoader
{
	public static function build ()
	{
		
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'traits' . DIRECTORY_SEPARATOR;

		if (is_dir($path))
		{
			$files = scandir($path);
			
			$files = array_diff($files, array('.', '..'));
			
			if (!empty($files))
			{
				foreach ($files as $file)
				{
					require_once $path . $file;
				}
			}
		}
	}
}

// implements traits for controllers
bmsLoader::build();

/*
print_r($_SERVER);

if (!$system_folder) $system_folder = "system";

if (!$application_folder) $application_folder = 'application';


// sets server path
if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
{
    $system_folder = str_replace("\\", "/", realpath(dirname(__FILE__))).'/'.$system_folder;
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


define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_folder.'/');


if (is_dir($application_folder))
{
    define('APPPATH', $application_folder.'/');
}
else
{
    if ($application_folder == '')
    {
        $application_folder = 'application';
    }

    define('APPPATH', BASEPATH.$application_folder.'/');
}


if ( ! defined('E_STRICT'))
{
    define('E_STRICT', 2048);
}
*/
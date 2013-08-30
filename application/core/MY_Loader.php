<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Specific Autoloader (99% ripped from the parent)
	 *
	 * The config/autoload.php file contains an array that permits sub-systems,
	 * libraries, and helpers to be loaded automatically.
	 *
	 * @param array|null $basepath
	 *
	 * @return void
	 */
	protected function ci_autoloader($basepath = NULL)
	{
		$autoload_path = (($basepath !== NULL) ? $basepath : APPPATH).'config/autoload'.EXT;

		if ( ! file_exists($autoload_path))
		{
			return FALSE;
		}

		include($autoload_path);

		if ( ! isset($autoload))
		{
			return FALSE;
		}

		if ($basepath !== NULL)
		{
			// Autoload packages
			if (isset($autoload['packages']))
			{
				foreach ($autoload['packages'] as $package_path)
				{
					$this->add_package_path($package_path);
				}
			}
		}

		// Autoload sparks
		if (isset($autoload['sparks']))
		{
			foreach ($autoload['sparks'] as $spark)
			{
				$this->spark($spark);
			}
		}

		if ($basepath !== NULL)
		{
			if (isset($autoload['config']))
			{
				// Load any custom config file
				if (count($autoload['config']) > 0)
				{
					$CI =& get_instance();
					foreach ($autoload['config'] as $key => $val)
					{
						$CI->config->load($val);
					}
				}
			}

			// Autoload helpers and languages
			foreach (array('helper', 'language') as $type)
			{
				if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
				{
					$this->$type($autoload[$type]);
				}
			}

			// A little tweak to remain backward compatible
			// The $autoload['core'] item was deprecated
			if ( ! isset($autoload['libraries']) AND isset($autoload['core']))
			{
				$autoload['libraries'] = $autoload['core'];
			}

			// Load libraries
			if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
			{
				// Load the database driver.
				if (in_array('database', $autoload['libraries']))
				{
					$this->database();
					$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
				}

				// Load all other libraries
				foreach ($autoload['libraries'] as $item)
				{
					$this->library($item);
				}
			}

			// Autoload models
			if (isset($autoload['model']))
			{
				$this->model($autoload['model']);
			}
		}
	}
	
}
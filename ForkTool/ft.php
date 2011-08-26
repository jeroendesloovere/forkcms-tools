<?php

/**
 * Fork NG CLI tool
 *
 * @author	 Jelmer Snoeck <jelmer.snoeck@netlash.com>
 */
class FT
{
	/**
	 * The working directory
	 *
	 * @var	string
	 */
	private $workingDir, $frontendPath, $backendPath, $libraryPath;

	/**
	 * CLI Path, this will be used to get base files
	 *
	 * @var	string
	 */
	private $cliPath;

	/**
	 * Arguments
	 *
	 * @var	array
	 */
	private $argv;

	/**
	 * Create Widget
	 *
	 * @return	void
	 */
	private function createAction($module, $location, $name)
	{
		// require the widget generator
		require_once $this->cliPath . 'action/generator.php';

		// make widget
		$action = new ActionGenerator($module, $location, $name);
	}

	/**
	 * Create a new module
	 *
	 * @return	void
	 */
	private function createModule($name)
	{
		// get the module generator
		require_once $this->cliPath . 'module/generator.php';

		// start a new module generator
		$module = new ModuleGenerator($name);
	}

	/**
	 * Create Widget
	 *
	 * @return	void
	 */
	private function createWidget($module, $name)
	{
		// require the widget generator
		require_once $this->cliPath . 'widget/generator.php';

		// make widget
		$widget = new WidgetGenerator($module, $name);
	}

	/**
	 * Execute the fork tool
	 *
	 * @return	void
	 */
	private function execute()
	{
		// set working dir and cli path
		$this->workingDir = getcwd();
		$this->cliPath = $this->argv[0];

		// get home directory
		$this->getHomeDir();

		// run the tool
		$this->run();
	}

	/**
	 * Gets the home directory of the current path
	 *
	 * @return	void
	 */
	private function getHomeDir()
	{
		// are we in default_www or library?
		$posDefWWW = strpos($this->workingDir, 'default_www');
		$posDefLib = strpos($this->workingDir, 'library');

		// we're not in one of forks working dirs
		if(empty($posDefWWW) && empty($posDefLib))
		{
			// is there a library path and default_www path available?
			if(!is_dir($this->workingDir . '/default_www') && !is_dir($this->workingDir . '/library'))
			{
				echo "This is not a valid Fork NG path. Please initiate in your home folder of your project. \n";
				exit;
			}
			// create working paths
			$this->frontendPath = $this->workingDir . '/default_www/frontend/';
			$this->backendPath = $this->workingDir . '/default_www/backend/';
			$this->libraryPath = $this->workingDir . '/library/';
		}
		// we're in one
		else
		{
			// where to split on
			$splitChar = (!empty($posDefWWW)) ? 'default_www' : 'library';

			// split the directory to go into default_www
			$workingDir = explode($splitChar, $this->workingDir);
			$workingDir = $workingDir[0];

			// create paths
			$this->frontendPath = $this->workingDir . '/default_www/frontend/';
			$this->backendPath = $this->workingDir . '/default_www/backend/';
			$this->libraryPath = $this->workingDir . '/library/';
		}

		// create real cli path
		$this->cliPath = substr($this->cliPath, 0, -6);

		// set paths for overall use
		define('CLIPATH', $this->cliPath);
		define('FRONTENDPATH', $this->frontendPath);
		define('BACKENDPATH', $this->backendPath);
	}

	/**
	 * Run the tool
	 *
	 * @return	void
	 */
	private function run()
	{
		// get command and command name
		$command = $this->argv[1];

		// check what to do
		switch($command)
		{
			case 'module':
				$this->createModule($this->argv[2]);
			break;
			case 'widget':
				$this->createWidget($this->argv[2], $this->argv[3]);
			break;
			case 'action':
				$this->createAction($this->argv[2], $this->argv[3], $this->argv[4]);
			break;
			default:
				echo "Not a valid action.\n";
				exit;
		}
	}

	/**
	 * Start the Fork Tool
	 *
	 * @return	void
	 * @param 	array $argv		The arguments passed by the CLI.
	 */
	public static function start($argv)
	{
		// are there any arguments given?
		if(count($argv) < 3) exit;

		// create fork tool
		$ft = new self();

		// set arguments
		$ft->argv = $argv;

		// execute the fork tool
		$ft->execute();
	}
}

FT::start($argv);

?>
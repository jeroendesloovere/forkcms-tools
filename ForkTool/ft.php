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
	private $workingDir, $frontendPath, $backendPath, $libraryPath, $basePath;

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
	 * Adjust the settings
	 *
	 * @return	void
	 * @param	string $setting		The name of the setting.
	 * @param	string $value		The value of the setting.
	 */
	private function adjustSetting($setting, $value)
	{
		// open the settings file
		$oSettings = fopen(CLIPATH . '.settings', 'r');
		$rSettings = fread($oSettings, filesize(CLIPATH . '.settings'));

		switch($setting)
		{
			case 'author':
				// check if the value is right according to the coding standards
				$match = preg_match('/([a-zA-Z]*)( )([a-zA-Z]*)( )(\<)([a-zA-Z0-9\.\-]{1,})(\@)([a-zA-Z0-9\.\-]{3,20})(\.)([a-z]{3,4})(\>)/', $value);

				if($match) $rSettings = preg_replace('/#author=(.*);/', '#author=' . $value . ';', $rSettings);
				else
				{
					echo "This is an invalid author input. It should be in the form of: First Name <email@provider.ext>\n";
					return;
				}
			break;

		}

		// close the file
		fclose($oSettings);

		// write to the file
		$wSettings = fopen(CLIPATH . '.settings', 'w');
		fwrite($wSettings, $rSettings);

		echo "Setting succesfully adjusted.\n";
	}


	/**
	 * Create Widget
	 *
	 * @return	void
	 * @param	string $module		The module name.
	 * @param	string $location	The location to create the action.
	 * @param	string $name		The action name.
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
	 * @param	string $name	The module name.
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
	 * @param	string $name	The theme name.
	 */
	private function createTheme($name)
	{
		// require the widget generator
		require_once $this->cliPath . 'theme/generator.php';

		// make widget
		$theme = new ThemeGenerator($name);
	}


	/**
	 * Create Widget
	 *
	 * @return	void
	 * @param	string $module		The module name.
	 * @param	string $name		The widget name.
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
				return;
			}
			// create working paths
			$this->frontendPath = $this->workingDir . '/default_www/frontend/';
			$this->backendPath = $this->workingDir . '/default_www/backend/';
			$this->libraryPath = $this->workingDir . '/library/';
			$this->basePath = $this->workingDir . '/';
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
			$this->frontendPath = $workingDir . 'default_www/frontend/';
			$this->backendPath = $workingDir . 'default_www/backend/';
			$this->libraryPath = $workingDir . 'library/';
			$this->basePath = $workingDir;
		}

		// read the version
		$oVersion = fopen($this->basePath . 'VERSION.md', 'r');
		$rVersion = fread($oVersion, filesize($this->basePath . 'VERSION.md'));
		$rVersion = (int) str_replace('.', '', $rVersion);

		// check if the frontend and backend exist (old fork doesn't have this)
		if(!is_dir($this->frontendPath) || !is_dir($this->backendPath) || $rVersion < 200)
		{
			echo"This is an older version of Fork. The Fork tool only works with V2+.\n";
			return;
		}

		// create real cli path
		$this->cliPath = substr($this->cliPath, 0, -6);

		// set paths for overall use
		define('CLIPATH', $this->cliPath);
		define('FRONTENDPATH', $this->frontendPath);
		define('BACKENDPATH', $this->backendPath);
	}


	/**
	 * Load the settings
	 *
	 * @return	void
	 */
	private function loadSettings()
	{
		// open the settings file
		$oSettings = fopen(CLIPATH . '.settings', 'r');
		$rSettings = fread($oSettings, filesize(CLIPATH . '.settings'));

		// author
		$author = preg_match('/#author=(.*);/', $rSettings, $matches);
		define('AUTHOR', $matches[1]);

		// close the file
		fclose($oSettings);
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
			case 'show':
				$this->showAction($this->argv[2]);
			break;
			case 'theme':
				$this->createTheme($this->argv[2]);
			break;
			case 'widget':
				if(count($this->argv) <= 3)
				{
					echo "We expect 2 parameters to create a widget. The module and the widget name. Example:\n";
					echo "ft widget blog show_most_related\n";
					return;
				}
				$this->createWidget($this->argv[2], $this->argv[3]);
			break;
			case 'action':
				if(count($this->argv) <= 4)
				{
					echo "We expect 3 parameters to create an action. The location, the module and the action name. Example:\n";
					echo "ft action backend blog edit\n";
					return;
				}
				$this->createAction($this->argv[3], $this->argv[2], $this->argv[4]);
			break;
			case 'settings':
				$this->adjustSetting($this->argv[2], $this->argv[3]);
			break;
		}
	}


	/**
	 * The show action, this will show info
	 *
	 * @return	void
	 * @param	string $showing		What to show?
	 */
	private function showAction($showing)
	{
		// version?
		switch($showing)
		{
			case 'version':
				// get version file
				$vFile = fopen($this->basePath . 'VERSION.md', 'r');
				$rFile = fread($vFile, filesize($this->basePath . 'VERSION.md'));

				// print version
				echo $rFile . "\n";
			break;
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
		echo "--------------------------------------------------------------------------------------------------\n";

		// are there any arguments given?
		if(count($argv) < 3)
		{
			$error = "Invalid arguments, you can use these: \n\n";
			$error.= "-action		[place, module, actionname] Example: ft action frontend blog review\n";
			$error.= "-module		[modulename] Example: ft module timetracker\n";
			$error.= "-widget		[modul, widgetname] Example: ft widget timetracker user_overview\n";
			$error.= "-theme		[themename] Example: ft theme triton\n";
			$error.= "-show		[whattoshow] Example: ft show version\n";

			echo $error;
		}

		// create fork tool
		$ft = new self();

		// set arguments
		$ft->argv = $argv;

		// execute the fork tool
		$ft->execute();

		$ft->loadSettings();

		// run the tool
		$ft->run();

		echo "--------------------------------------------------------------------------------------------------\n";
	}
}

FT::start($argv);

?>
<?php

/**
 * Class for generating an action
 *
 * @author	Jelmer Snoeck <jelmer.snoeck@netlash.com>
 *
 */
class ActionGenerator
{
	/**
	 * The values
	 *
	 * @var	string
	 */
	private $module, $actionname, $location, $workingDir, $filename;


	/**
	 * Start the action generator
	 * E
	 * @param 	string $module		The module name.
	 * @param	string $location	The location the action should come.
	 * @param	string $actionname	The name of the action.
	 */
	public function __construct($module, $location, $actionname)
	{
		// set variables
		$this->module = (string) strtolower($module);
		$this->filename = (string) strtolower($actionname);
		$this->location = (string) strtolower($location);

		// create valid name
		$this->createName();
		// check the paths
		$this->checkPaths();

		// check if the widget doesn't exists to continue
		if(!file_exists($this->workingDir . $this->module . '/actions/' . $this->filename . '.php'))
		{
			// create the action
			$this->createAction();

			// widget created
			echo "The action '$this->actionname' is created.\n";
		}
		// widget exists
		else echo "The action already exists.\n";
	}


	/**
	 * Checks if the paths are right
	 */
	private function checkPaths()
	{
		// check if the location is right
		if($this->location != 'frontend' && $this->location != 'backend')
		{
			$error = "Please specify if you want to create this action in the frontend or backend. \n";
			FT::error($error);
		}

		// get the working dir
		$this->getWorkingDir();

		// check if the module is set
		if(!is_dir($this->workingDir . $this->module))
		{
			$error = "This is not an existing module. \n";
			FT::error($error);
		}
	}


	/**
	 * Create the action files
	 *
	 * @return	void
	 */
	private function createAction()
	{
		// load the base file
		$acBaseFile = CLIPATH . 'action/bases/' . $this->location . '/base.php';
		$fhBaseFile = fopen($acBaseFile, "r");

		// replace parameters for the frontend
		if($this->location == 'frontend')
		{
			// generate replacement names
			$className = 'Frontend' . ucfirst($this->module) . $this->actionname;
			$extensionName = 'FrontendBaseBlock';
		}
		// replace parameters for the backend
		elseif($this->location == 'backend')
		{
			// generate replacement names
			$className = 'Backend' . ucfirst($this->module) . $this->actionname;
			$extensionName = 'BackendBaseAction';

			// check if we need to add some additional info tot he extension
			$lcAction = strtolower($this->actionname);
			if($lcAction == 'edit' || $lcAction == 'delete' || $lcAction == 'add' || $lcAction == 'index') $extensionName.= $this->actionname;
		}

		// start replacement
		$fhRepFile = fread($fhBaseFile, filesize($acBaseFile));
		$fhRepFile = str_replace('classname', $className, $fhRepFile);
		$fhRepFile = str_replace('actionname', strtolower($this->actionname), $fhRepFile);
		$fhRepFile = str_replace('modulename', $this->module, $fhRepFile);
		$fhRepFile = str_replace('extension', $extensionName, $fhRepFile);
		$fhRepFile = str_replace('authorname', AUTHOR, $fhRepFile);

		// create new file
		$acFile = fopen($this->workingDir . $this->module . '/actions/' . $this->filename . '.php', 'w');
		fwrite($acFile, $fhRepFile);

		// close the files
		fclose($acFile);
		fclose($fhBaseFile);

		// create the template for the action
		$this->createTemplate();
	}


	/**
	 * Creates a valid name
	 *
	 * @return	void
	 */
	private function createName()
	{
		// are there any underscores?
		if(strpos($this->filename, '_') > 0)
		{
			// temporary string
			$tempStr = '';

			// temporary names
			$tempNames = explode('_', $this->filename);

			// uppercase it
			foreach($tempNames as $name) $tempStr.= ucfirst($name);

			// reassign
			$this->actionname = $tempStr;
		}
		// no underscores
		else $this->actionname = ucfirst($this->filename);
	}


	/**
	 * Make the template file
	 *
	 * @return	void
	 */
	private function createTemplate()
	{
		// create index template
		$acFile = fopen($this->workingDir . $this->module . '/layout/templates/' . $this->filename . '.tpl', 'w');
		fwrite($acFile, '');

		// close files
		fclose($acFile);
	}


	/**
	 * Sets the right path to work in (frontend/backend)
	 *
	 * @return	void
	 */
	private function getWorkingDir()
	{
		// create temporary path
		$tempPath = ($this->location == 'frontend') ? FRONTENDPATH : BACKENDPATH;

		// set working dir
		$this->workingDir = $tempPath . 'modules/';
	}
}

?>
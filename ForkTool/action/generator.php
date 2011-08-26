<?php

/**
 * Class for generating an action
 *
 * @author	Jelmer Snoeck <jelmer.snoeck@netlash.com>
 *
 */
class ModuleGenerator
{
	/**
	 * The values
	 *
	 * @var	string
	 */
	private $module, $actionname, $location, $workingDir;

	/**
	 * Start the widget generator
	 * E
	 * @param 	string $module		The module name.
	 * @param	string $this->module		The name the widget should have.
	 */
	public function __construct($module, $location, $actionname)
	{
		echo 'test';
		// set variables
		$this->module = (string) strtolower($module);
		$this->file = (string) strtolower($actionname);
		$this->location = (string) strtolower($location);

		// create valid name
		$this->createName();

		// do some checks
		if(!is_dir(FRONTENDPATH . 'modules/' . $this->module) && !is_dir(BACKENDPATH . 'modules.' . $this->module))
		{
			"This is not an existing module. \n";
			exit;
		}
		if($this->location != 'frontend' && $this->location != 'backend')
		{
			"Please specify if you want to create this action in the frontend or backend. \n";
			exit;
		}

		// check if we need to work in the frontend or backend
		$this->getWorkingDir();

		// check if the widget doesn't exists to continue
		if(!is_dir($this->workingDir . 'actions/' . $this->filename . '.php'))
		{
			// create the action
			//$this->createAction();

			// create template
			//$this->createTemplate();

			// widget created
			echo "The action '$this->actionname' is created.\n";
		}
		// widget exists
		else echo "The action already exists.\n";
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

	/**
	 * Build the backend
	 *
	 * @return	void
	 */
	private function buildBackend()
	{
		// make backend dirs
		mkdir(BACKENDPATH . 'modules/' . $this->module);
		mkdir(BACKENDPATH . 'modules/' . $this->module . '/actions');
		mkdir(BACKENDPATH . 'modules/' . $this->module . '/engine');
		mkdir(BACKENDPATH . 'modules/' . $this->module . '/installer');
		mkdir(BACKENDPATH . 'modules/' . $this->module . '/installer/data');
		mkdir(BACKENDPATH . 'modules/' . $this->module . '/layout');
		mkdir(BACKENDPATH . 'modules/' . $this->module . '/layout/templates');
	}

	/**
	 * Build the frontend
	 *
	 * @return	void
	 */
	private function buildFrontend()
	{
		// make frontend
		mkdir(FRONTENDPATH . 'modules/' . $this->module);
		mkdir(FRONTENDPATH . 'modules/' . $this->module . '/actions');
		mkdir(FRONTENDPATH . 'modules/' . $this->module . '/engine');
		mkdir(FRONTENDPATH . 'modules/' . $this->module . '/layout');
		mkdir(FRONTENDPATH . 'modules/' . $this->module . '/layout/templates');

	}

	/**
	 * Create action
	 *
	 * @return	void
	 */
	private function createAction()
	{
		// index action template
		$modTemplate = CLIPATH . 'module/bases/backend/index.php';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create index action
		$modFile = fopen(BACKENDPATH . 'modules/' . $this->module . '/actions/index.php', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);

		// index action template
		$modTemplate = CLIPATH . 'module/bases/frontend/index.php';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create index action
		$modFile = fopen(FRONTENDPATH . 'modules/' . $this->module . '/actions/index.php', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);
	}

	/**
	 * Create model
	 *
	 * @return	void
	 */
	private function createModel()
	{
		// module template
		$modTemplate = CLIPATH . 'module/bases/backend/model.php';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create model
		$modFile = fopen(BACKENDPATH . 'modules/' . $this->module . '/engine/model.php', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);


		// module template
		$modTemplate = CLIPATH . 'module/bases/frontend/model.php';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create model
		$modFile = fopen(FRONTENDPATH . 'modules/' . $this->module . '/engine/model.php', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);
	}

	/**
	 * Make names
	 *
	 * @return	void
	 */
	private function createTemplate()
	{
		// index action template
		$modTemplate = CLIPATH . 'module/bases/backend/index.tpl';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create index template
		$modFile = fopen(BACKENDPATH . 'modules/' . $this->module . '/layout/templates/index.tpl', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);

		// create index template
		$modFile = fopen(FRONTENDPATH . 'modules/' . $this->module . '/layout/templates/index.tpl', 'w');
		fwrite($modFile, '');

		// close file
		fclose($modFile);
	}

	/**
	 * Create config
	 *
	 * @return	void
	 */
	private function createConfig()
	{
		// config template
		$modTemplate = CLIPATH . 'module/bases/backend/config.php';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create config
		$modFile = fopen(BACKENDPATH . 'modules/' . $this->module . '/config.php', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);

		// module template
		$modTemplate = CLIPATH . 'module/bases/frontend/config.php';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create model
		$modFile = fopen(FRONTENDPATH . 'modules/' . $this->module . '/config.php', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);
	}

	/**
	 * Create installer
	 *
	 * @return	void
	 */
	private function createInstaller()
	{
		// install template
		$modTemplate = CLIPATH . 'module/bases/backend/install.php';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create installer
		$modFile = fopen(BACKENDPATH . 'modules/' . $this->module . '/installer/install.php', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);
	}
}

?>
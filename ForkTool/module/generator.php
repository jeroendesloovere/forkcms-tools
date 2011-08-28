<?php

/**
 * Class for generating a module
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
	private $module;

	/**
	 * Start the module generator
	 * E
	 * @param 	string $module		The module name.
	 */
	public function __construct($module)
	{
		// check if the widget doesn't exists to continue
		if(!is_dir(FRONTENDPATH . 'modules/' . $module))
		{
			// set variables
			$this->module = $module;

			// build the backend
			$this->buildBackend();

			// build the frontend
			$this->buildFrontend();

			// create the action
			$this->createAction();

			// create the models
			$this->createModel();

			// create the configs
			$this->createConfig();

			// create the installer
			$this->createInstaller();

			// create template
			$this->createTemplate();

			// widget created
			echo "The module '$this->module' is created.\n";
		}
		// widget exists
		else echo "The module already exists.\n";
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

		// create locale
		$modTemplate = CLIPATH . 'module/bases/backend/locale.xml';
		$fhModTemplate = fopen($modTemplate, "r");
		$tdModTemplate = fread($fhModTemplate, filesize($modTemplate));
		$tdModTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdModTemplate);
		$tdModTemplate = str_replace('tempname', $this->module, $tdModTemplate);

		// create installer
		$modFile = fopen(BACKENDPATH . 'modules/' . $this->module . '/installer/data/locale.xml', 'w');
		fwrite($modFile, $tdModTemplate);

		// close files
		fclose($modFile);
		fclose($fhModTemplate);

		// create installer
		$modFile = fopen(BACKENDPATH . 'modules/' . $this->module . '/installer/data/install.sql', 'w');
		fwrite($modFile, '');

		// close files
		fclose($modFile);
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
}

?>
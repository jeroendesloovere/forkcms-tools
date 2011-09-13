<?php

/**
 * Class for generating a widget
 *
 * @author	Jelmer Snoeck <jelmer.snoeck@netlash.com>
 *
 */
class WidgetGenerator
{
	/**
	 * The values
	 *
	 * @var	string
	 */
	private $module, $name, $filename;

	/**
	 * Start the widget generator
	 * E
	 * @param 	string $module		The module name.
	 * @param	string $name		The name the widget should have.
	 */
	public function __construct($module, $name)
	{
		// check if the widget doesn't exists to continue
		if(!file_exists(FRONTENDPATH . 'modules/' . $module . '/widgets/' . $name . '.php'))
		{
			// set variables
			$this->module = $module;
			$this->filename = $name;

			// create name
			$this->createName();

			// create the action
			$this->createAction();

			// create template
			$this->createTemplate();

			// widget created
			echo "The widget '$this->name' is created.\n";
		}
		// widget exists
		else echo "The widget already exists.\n";
	}


	/**
	 * Create action
	 *
	 * @return	void
	 */
	private function createAction()
	{
		// check if widget php dir is available
		if(!is_dir(FRONTENDPATH . 'modules/' . $this->module . '/widgets')) mkdir(FRONTENDPATH . 'modules/' . $this->module . '/widgets');

		// widget template
		$widTemplate = CLIPATH . 'widget/bases/widget.php';
		$fhWidTemplate = fopen($widTemplate, "r");
		$tdWidTemplate = fread($fhWidTemplate, filesize($widTemplate));
		$tdWidTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdWidTemplate);
		$tdWidTemplate = str_replace('tempname', $this->module, $tdWidTemplate);
		$tdWidTemplate = str_replace('wname', ucfirst($this->name), $tdWidTemplate);
		$tdWidTemplate = str_replace('authorname', AUTHOR, $tdWidTemplate);

		// create widget
		$modFile = fopen(FRONTENDPATH . 'modules/' . $this->module . '/widgets/' . $this->filename . '.php', 'w');
		fwrite($modFile, $tdWidTemplate);

		// close the files
		fclose($modFile);
		fclose($fhWidTemplate);
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
			echo strpos($this->filename, '_');
			// temporary string
			$tempStr = '';

			// temporary names
			$tempNames = explode('_', $this->filename);

			// uppercase it
			foreach($tempNames as $name) $tempStr.= ucfirst($name);

			// reassign
			$this->name = $tempStr;
		}
	}


	/**
	 * Make names (make _ to upercase)
	 *
	 * @return	void
	 */
	private function createTemplate()
	{
		// check if the widget dir is available
		if(!is_dir(FRONTENDPATH . 'modules/' . $this->module . '/layout/widgets')) mkdir(FRONTENDPATH . 'modules/' . $this->module . '/layout/widgets');

		// build a new template
		$widTemplate = CLIPATH . 'widget/bases/widget.tpl';
		$fhWidTemplate = fopen($widTemplate, "r");
		$tdWidTemplate= fread($fhWidTemplate, filesize($widTemplate));
		$tdWidTemplate = str_replace('tempnameuc', ucfirst($this->module), $tdWidTemplate);
		$tdWidTemplate = str_replace('tempname', $this->module, $tdWidTemplate);
		$tdWidTemplate = str_replace('wname', ucfirst($this->name), $tdWidTemplate);
		$tdWidTemplate = str_replace('authorname', AUTHOR, $tdWidTemplate);

		// make new widget template and fill it
		$widFile = fopen(FRONTENDPATH . 'modules/' . $this->module . '/layout/widgets/' . $this->filename . '.tpl', 'w');
		fwrite($widFile, $tdWidTemplate);

		// close files
		fclose($widFile);
		fclose($fhWidTemplate);
	}
}

?>
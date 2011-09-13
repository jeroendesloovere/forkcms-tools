<?php

/**
 * Class for generating a theme
 *
 * @author	Jelmer Snoeck <jelmer.snoeck@netlash.com>
 *
 */
class ThemeGenerator
{
	/**
	 * The values
	 *
	 * @var	string
	 */
	private $themename;

	/**
	 * Start the theme generator
	 *
	 * @param	string $name		The name the theme should have.
	 */
	public function __construct($name)
	{
		// check if the widget doesn't exists to continue
		if(!is_dir(FRONTENDPATH . 'themes/' . $name))
		{
			// set themename
			$this->themename = strtolower($name);

			// build the backend
			$this->buildStructure();

			// create the action
			$this->createFiles();

			// widget created
			echo "The theme '$this->themename' is created.\n";
		}
		// widget exists
		else echo "The theme already exists.\n";
	}


	/**
	 * Build the directories
	 *
	 * @return	void
	 */
	private function buildStructure()
	{
		// make backend dirs
		mkdir(FRONTENDPATH . 'themes/' . $this->themename);
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/core');
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/core/js');
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout');
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/css');
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/fonts');
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/images');
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/templates');
		mkdir(FRONTENDPATH . 'themes/' . $this->themename . '/modules');
	}


	/**
	 * Make the files
	 *
	 * @return	void
	 */
	private function createFiles()
	{
		// create css
		$oCSS = fopen(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/css/screen.css', 'w');
		fwrite($oCSS, '');

		// close file
		fclose($oCSS);

		// reade base javascript
		$oBase = fopen(CLIPATH . 'theme/bases/html5.js', 'r');
		$rBase = fread($oBase, filesize(CLIPATH . 'theme/bases/html5.js'));

		// create default
		$oTemp = fopen(FRONTENDPATH . 'themes/' . $this->themename . '/core/js/html5.js', 'w');
		fwrite($oTemp, $rBase);

		// close file
		fclose($oTemp);

		// copy the triton files to the new dir
		$tritonPath = FRONTENDPATH . 'themes/triton/core/layout/templates/';
		$themePath = FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/templates/';

		// copy the files
		copy($tritonPath . 'default.tpl', $themePath . 'default.tpl');
		copy($tritonPath . 'footer.tpl', $themePath . 'footer.tpl');
		copy($tritonPath . 'head.tpl', $themePath . 'head.tpl');
		copy($tritonPath . 'home.tpl', $themePath . 'home.tpl');
	}
}

?>
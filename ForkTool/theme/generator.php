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

		// create template files
		$oTemp = fopen(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/templates/footer.tpl', 'w');
		fwrite($oTemp, '');

		// close file
		fclose($oTemp);

		// read base file
		$oBase = fopen(CLIPATH . 'theme/bases/head.tpl', 'r');
		$rBase = fread($oBase, filesize(CLIPATH . 'theme/bases/head.tpl'));
		$rBase = str_replace('themename', $this->themename, $rBase);

		// create template files
		$oTemp = fopen(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/templates/head.tpl', 'w');
		fwrite($oTemp, $rBase);

		// close file
		fclose($oTemp);
		fclose($oBase);

		// read base file
		$oBase = fopen(CLIPATH . 'theme/bases/default.tpl', 'r');
		$rBase = fread($oBase, filesize(CLIPATH . 'theme/bases/default.tpl'));
		$rBase = str_replace('themename', $this->themename, $rBase);

		// create default
		$oTemp = fopen(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/templates/default.tpl', 'w');
		fwrite($oTemp, $rBase);

		// create template files
		$oTemp = fopen(FRONTENDPATH . 'themes/' . $this->themename . '/core/layout/templates/home.tpl', 'w');
		fwrite($oTemp, $rBase);

		// close file
		fclose($oTemp);
		fclose($oBase);

		// reade base javascript
		$oBase = fopen(CLIPATH . 'theme/bases/html5.js', 'r');
		$rBase = fread($oBase, filesize(CLIPATH . 'theme/bases/html5.js'));

		// create default
		$oTemp = fopen(FRONTENDPATH . 'themes/' . $this->themename . '/core/js/html5.js', 'w');
		fwrite($oTemp, $rBase);

		// close file
		fclose($oTemp);
	}
}

?>
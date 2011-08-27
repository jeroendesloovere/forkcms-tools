<?php

/**
 * Installer for the tempname module
 *
 * @package		installer
 * @subpackage	tempname
 *
 * @author		Jelmer Snoeck <jelmer.snoeck@netlash.com>
 * @since		2.6.2
 */
class tempnameucInstall extends ModuleInstaller
{
	/**
	 * Execute the installer
	 *
	 * @return	void
	 */
	public function execute()
	{
		// load install.sql
		$this->importSQL(dirname(__FILE__) . '/data/install.sql');

		// add 'temname' as a module
		$this->addModule('tempname', 'The tempname module.');

		// import locale
		$this->importLocale(dirname(__FILE__) . '/data/locale.xml');

		// module rights
		$this->setModuleRights(1, 'tempname');

		// set action rights
		$this->setActionRights(1, 'tempname', 'index');

		// add extra's
		$tempnameID = $this->insertExtra('tempname', 'block', 'tempnameuc', null, null, 'N', 1000);
	}
}

?>

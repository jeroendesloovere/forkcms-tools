<?php

/**
 * This is the actionname-action
 *
 * @package		frontend
 * @subpackage	modulename
 *
 * @author		Jelmer Snoeck <jelmer.snoeck@netlash.com>
 * @since		2.6.2
 */
class classname extends extensionname
{
	/**
	 * Execute the extra
	 *
	 * @return	void
	 */
	public function execute()
	{
		// call the parent
		parent::execute();

		// load template
		$this->loadTemplate();

		// load the data
		$this->getData();

		// parse
		$this->parse();
	}


	/**
	 * Load the data, don't forget to validate the incoming data
	 *
	 * @return	void
	 */
	private function getData()
	{
	}


	/**
	 * Parse the data into the template
	 *
	 * @return	void
	 */
	private function parse()
	{
	}
}

?>
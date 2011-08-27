<?php

/**
 * This is the actionname-action.
 *
 * @package		backend
 * @subpackage	modulename
 *
 * @author		Jelmer Snoeck <jelmer.snoeck@netlash.com>
 * @since		2.6.2
 */
class classname extends extensionname
{
	/**
	 * Execute the action
	 *
	 * @return	void
	 */
	public function execute()
	{
		// call parent, this will probably add some general CSS/JS or other required files
		parent::execute();

		// parse page
		$this->parse();

		// display the page
		$this->display();
	}


	/**
	 * Parse all datagrids
	 *
	 * @return	void
	 */
	private function parse()
	{
	}
}

?>
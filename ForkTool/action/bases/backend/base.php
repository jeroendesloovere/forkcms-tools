<?php

/**
 * This is the actionname-action.
 *
 * @package		backend
 * @subpackage	modulename
 *
 * @author		authorname
 * @since		2.6.2
 */
class classname extends extension
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
	protected function parse()
	{
	}
}

?>
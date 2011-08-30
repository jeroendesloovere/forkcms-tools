<?php

/**
 * This is the index-action (default), it will display the overview of tempname posts
 *
 * @package		backend
 * @subpackage	tempname
 *
 * @author		authorname
 * @since		2.6.2
 */
class BackendtempnameucIndex extends BackendBaseActionIndex
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

		// display the page
		$this->display();
	}
}

?>
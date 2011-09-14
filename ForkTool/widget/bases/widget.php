<?php

/**
 * This is a widget
 *
 * @package		frontend
 * @subpackage	tempname
 *
 * @author		authorname
 * @since		2.6.2
 */
class FrontendtempnameucWidgetwname extends FrontendBaseWidget
{
	/**
	 * Execute the extra
	 *
	 * @return	void
	 */
	public function execute()
	{
		// call parent
		parent::execute();

		// load the data
		$this->loadData();

		// load template
		$this->loadTemplate();

		// parse
		$this->parse();
	}


	/**
	 * Load the data
	 *
	 * @return	void
	 */
	private function loadData()
	{
		// get the data
		$this->data = false;
	}


	/**
	 * Parse
	 *
	 * @return	void
	 */
	private function parse()
	{
		// assign the data
		$this->tpl->assign('wname', $this->data);
	}
}

?>
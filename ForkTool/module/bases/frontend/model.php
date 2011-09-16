<?php

/**
 * In this file we store all generic functions that we will be using in the tempname module
 *
 * @package		frontend
 * @subpackage	tempname
 *
 * @author		authorname
 * @since		2.6.2
 */
class FrontendtempnameucModel
{
	/**
	 * Builds a detail url
	 *
	 * @return	void
	 * @param	array $data		The records to convert the url for.
	 */
	public static function buildURL(array &$data)
	{
		// go trough the data
		foreach($data as &$item)
		{
			// is the item an array(so multiple items)
			if(is_array($item))
			{
				$item['full_url'] = FrontendNavigation::getURLForBlock('tempname', 'detail') . '/' . $item['url'];
			}
			// nope, single entry
			else
			{
				$data['full_url'] = FrontendNavigation::getURLForBlock('tempname', 'detail') . '/' . $data['url'];
				break;
			}
		}
	}
}

?>
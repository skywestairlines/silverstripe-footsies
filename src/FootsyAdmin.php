<?php

use SilverStripe\Admin\ModelAdmin;
/*
	This will be a new tab only viewable by admins
	
	- !Home footer -- This is only on the home page so I just put it in the homepage backend.
	- regular footer
	
	will show each page in the site tree with a check mark by them ????
	
*/
class FootsyAdmin extends ModelAdmin {
	private static $managed_models = array(
		'Footsy',
		'HomeFootsy'
	);
	
	private static $url_segment = 'footsies';
	private static $menu_title = 'Footsies';
	
	private static $set_page_length = 100;
	
	var $showImportForm = false;
}
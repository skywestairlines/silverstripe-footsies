<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class IntLink extends DataObject {
	private static $db = array(
		'Title' => 'Varchar(50)',
		'SortOrder' => 'Int'
	);

	private static $has_one = array(
		'icon' => 'BetterImage',
		'Link' => 'SiteTree',
		'Footsy' => 'Footsy'
	);

	private static $singular_name = 'IntLink';
	private static $plural_name	  = 'IntLinks';

	//private static $default_sort = 'SortOrder ASC';

	private static $summary_fields = array(
		'Title' => 'Title',
		'Link.Title' => 'Link',
		//'icon.CMSThumbnail.Tag' => 'Icon'
	);
	private static $default_sort = 'SortOrder ASC';

	public function getCMSFields() {
		$f = new FieldList();

		$fLink = new TreeDropdownField('LinkID', 'Link to Page', 'SiteTree');
        //$fLink->setEmptyString('Select One...');

        $icon = new UploadField('icon');
		$icon->setFolderName('Uploads/LinkIcons');
		if(!Permission::check('ADMIN')) {
			$icon->removeFolderSelection();
		}

        $f->push(TextField::create('Title')->setTitle('Link Title'));
        $f->push($fLink);
        //$f->push($icon);

        $f->removeByName('SortOrder');

		return $f;
	}

	function FooterLink() {
		if($this->LinkID) {
			//debug::show($this->LinkID);
			$pageLink = SiteTree::get()->byID($this->LinkID);
			return $pageLink->Link();
			//debug::show($pageLink->Link());
		}
	}

	/**
	 * onBeforeWrite function checks to see if title is filled out, if not put the page title from the dropdown in
	 *
	 * @access public
	 * @return void
	 */
	function onBeforeWrite() {
		//debug::show(DataObject::get_by_id('SiteTree', $this->record['LinkID']));
		//die();
		parent::onBeforeWrite();
		if(isset($this->record['Title']) && $this->record['Title'] != '' && $this->record['Title'] != '#') {
			$this->Title = $this->record['Title'];
		} else {
			$t = SiteTree::get()->byID($this->record['LinkID']);
			$this->Title = $t->Title;
		}
	}
}

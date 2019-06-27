<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;
/*
	this will be a tab on the home page
	can add pages that will be the footer, can order them however you want
*/
class HomeFootsy extends DataObject {
	private static $db = array(
		'LinkTitle' => 'Varchar(50)'
	);

	private static $has_one = array(
		'Link' => SiteTree::class,
		'HomePage' => HomePage::class,
	);

	private static $singular_name = 'HomeFootsy';
	private static $plural_name	  = 'HomeFootsies';

	private static $summary_fields = array(
		'LinkTitle' => 'LinkTitle',
		'Link.Title' => 'Link'
	);

	public function getCMSFields() {
		$f = new FieldList();

		$fLink = new TreeDropdownField('LinkID', 'Link to Page', 'SiteTree');
        //$fLink->setEmptyString('Select One...');

        $f->push(TextField::create('LinkTitle')->setTitle('Link Title'));
        $f->push($fLink);

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
		if(isset($this->record['LinkTitle']) && $this->record['LinkTitle'] != '' && $this->record['LinkTitle'] != '#') {
			$this->LinkTitle = $this->record['LinkTitle'];
		} else {
			// the following line fails LOCALLY only, on the live site it works... for now (1/19/12)
			$t = SiteTree::get()->byID( $this->record['LinkID']);
			$this->LinkTitle = $t->Title;
		}
	}
}

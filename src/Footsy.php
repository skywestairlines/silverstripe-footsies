<?php
use SilverStripe\ORM\DataObject;
class Footsy extends DataObject {
	private static $db = array(
		'Title' => 'Varchar(25)',
		'SortOrder' => 'Int(25)'
	);
	
	private static $has_many = array(
		'IntLinks' => 'IntLink',
		'ExtLinks' => 'ExtLink'
	);
	
	private static $singular_name = 'Footsy';
	private static $plural_name	  = 'Footsies';
	
	private static $default_sort = 'SortOrder ASC';
	
	private static $summary_fields = array(
		'Title' => 'Title'
	);
	
	public function getCMSFields() {
		$f = new FieldList();
		
		$iDom = new GridField(
			'IntLinks',
			'IntLink',
			$this->IntLinks(),
			GridFieldConfig_RelationEditor::create()->addComponent(new GridFieldSortableRows('SortOrder'))
		);
		//$iDom->setPopupWidth('960');
        //$iDom->setAddTitle('Internal Link');
        
        $eDom = new GridField(
			
			'ExtLinks',
			'ExtLink',
			$this->ExtLinks(),
			GridFieldConfig_RelationEditor::create()
		);
		//$eDom->setPopupWidth('960');
        //$eDom->setAddTitle('External Link');
        
        $f->push(TextField::create('Title')->setTitle('Link Title'));
        $f->push(TextField::create('SortOrder'));
        $f->push(new LiteralField('', '<br />'));
        $f->push($iDom);
        $f->push(new LiteralField('', '<br />'));
        $f->push($eDom);
		
		return $f;
	}
}
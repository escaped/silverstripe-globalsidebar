<?php

/**
 * Decorator adds a WidgetArea to SiteConfig.
 * 
 * Use in template:
 * <code>
 * $SiteConfig.Sidebar
 * </code>
 *
 *
 * @package silverstripe-globalsidebar
 * @author Alexander Frenzel <alex[at]relatedworks[dot]com>
 */
class GlobalSidebarSiteConfig extends DataObjectDecorator {

	// add database fields
	function extraStatics() {
		return array(
			'has_one' => array(
				"Sidebar" => "WidgetArea"
			)
		);
	}
    
	// Create CMS fields
	public function updateCMSFields(FieldSet &$fields) {
		$fields->addFieldToTab("Root.Widgets", new WidgetAreaEditor("Sidebar"));
	}
}

/**
 * This extension fixes the save-behavior in SiteConfig.
 * 
 * BeforeSave() method is not called in WidgetAreaEditor.js.
 * This can be tracked down to LeftAndMain_right.js:168
 * where __form.elements.ID is not defined for RootForm.
 * As you can see in CMSMain.php:431 getEditForm($id) the ID
 * is only generated for the EditForm form.
 * 
 * To fix this, we just add this field to the RootForm.
 *
 * @package silverstripe-globalsidebar
 * @author Alexander Frenzel <alex[at]relatedworks[dot]com>
 */
class FixSiteConfigForm extends DataObjectDecorator {
	public function updateEditForm(&$form) {
		if ($form->Name() == 'RootForm')
			$form->Fields()->push($idField = new HiddenField("ID"));
	}
}

/**
 * Decorator which provides easy acces to GlobalSidebar in templates.
 * 
 * Use in template:
 * <code>
 * $GlobalSidebar
 * </code>
 *
 * @package silverstripe-globalsidebar
 * @author Alexander Frenzel <alex[at]relatedworks[dot]com>
 */
class GlobalSidebarSiteTree extends SiteTreeDecorator {
	public function GlobalSidebar() {
		return SiteConfig::current_site_config()->Sidebar();
	}
}
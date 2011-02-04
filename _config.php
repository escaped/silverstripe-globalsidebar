<?php

// add GlobalSidebar
Object::add_extension('SiteConfig', 'GlobalSidebarSiteConfig');
Object::add_extension('SiteTree', 'GlobalSidebarSiteTree');

// Fix CMS
Object::add_extension('CMSMain', 'FixSiteConfigForm');

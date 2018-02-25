<?php
//#section#[header]
// Use Important Headers
use \API\Platform\importer;
use \API\Platform\engine;
use \Exception;

// Check Platform Existance
if (!defined('_RB_PLATFORM_')) throw new Exception("Platform is not defined!");

// Import DOM, HTML
importer::import("UI", "Html", "DOM");
importer::import("UI", "Html", "HTML");

use \UI\Html\DOM;
use \UI\Html\HTML;

// Import application for initialization
importer::import("AEL", "Platform", "application");
use \AEL\Platform\application;

// Increase application's view loading depth
application::incLoadingDepth();

// Set Application ID
$appID = 51;

// Init Application and Application literal
application::init(51);
// Secure Importer
importer::secure(TRUE);

// Import SDK Packages
importer::import("API", "Profile");
importer::import("BSS", "Market");
importer::import("INU", "Views");
importer::import("UI", "Apps");

// Import APP Packages
//#section_end#
//#section#[view]
use \API\Profile\team;
use \BSS\Market\appMarket;
use \UI\Apps\APPContent;
use \INU\Views\fileExplorer;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Build the application view content
$appContent->build("", "fileExplorerApplicationContainer", TRUE);

$modes = array();
$modes[] = "team";
$modes[] = "account";

// Set navigation
$menuItems = array();
$menuItems['apps'] = "apps/appList";
$menuItems['shared'] = "sharedExplorer";
$menuItems['system'] = "systemExplorer";
$menuItems['full'] = "fullExplorer";
$mainContent = HTML::select(".fileExplorerApplication .mainContent")->item(0);
foreach ($modes as $viewMode)
	foreach ($menuItems as $class => $viewName)
	{
		// Get menu item
		$mItem = HTML::select(".fileExplorerApplication .sidebar .menu-container.".$viewMode." .menuitem.".$class)->item(0);

		// Set navigation ref
		$appContent->setStaticNav($mItem, $ref = "", $targetcontainer = "", $targetgroup = "", $navgroup = "fxnavgroup", $display = "none");

		// Set action
		$attr = array();
		$attr['mode'] = $viewMode;
		$actionFactory->setAction($mItem, $viewName, ".fileExplorerApplication .mainContent", $attr, "replace");
	}

// Return output
return $appContent->getReport();
//#section_end#
?>
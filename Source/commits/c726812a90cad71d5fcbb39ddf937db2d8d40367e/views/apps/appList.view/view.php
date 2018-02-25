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
importer::import("BSS", "Market");
importer::import("UI", "Apps");

// Import APP Packages
//#section_end#
//#section#[view]
use \BSS\Market\appMarket;
use \UI\Apps\APPContent;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Build the application view content
$appContent->build("", "appListContainer", TRUE);



// Get all team applications and add to dashboard
$teamApplications = appMarket::getTeamApplications();
usort($teamApplications, "sortApps");
$updates = array();
$appList = HTML::select(".appList .list")->item(0);
foreach ($teamApplications as $appInfo)
{
	// Get app info
	$applicationID = $appInfo['application_id'];
	$applicationVersion = $appInfo['version'];
	
	// Create application grid box
	$appBox = DOM::create("div", "", "", "appBox");
	DOM::append($appList, $appBox);
	
	// Set action to load explorer
	$attr = array();
	$attr['app_id'] = $applicationID;
	$attr['app_name'] = $appInfo['title'];
	$actionFactory->setAction($appBox, "apps/appExplorer", ".appList .fxContainer", $attr);
	
	// Application Icon
	$ico = DOM::create("span", "", "", "ico");
	DOM::append($appBox, $ico);
	
	// Set ico image
	if (!empty($appInfo['icon_url']))
	{
		$img = DOM::create("img");
		DOM::attr($img, "src", $appInfo['icon_url']);
		DOM::append($ico, $img);
	}
	
	// Application title
	$t = DOM::create("span", $appInfo['title'], "", "title");
	DOM::append($appBox, $t);
	
	// Add application data
	$applicationData = array();
	$applicationData['id'] = $applicationID;
	HTML::data($appBox, "app", $applicationData);
	
	// Check if there is an update and show notifications
	$lastAppVersion = appMarket::getLastApplicationVersion($applicationID);
	if (version_compare($applicationVersion, $lastAppVersion, "<"))
		$updates[] = $applicationID;
}

// Return output
return $appContent->getReport();
//#section_end#
?>
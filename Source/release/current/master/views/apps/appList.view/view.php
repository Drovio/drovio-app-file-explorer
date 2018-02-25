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
use \BSS\Market\devApps;
use \UI\Apps\APPContent;

// Create Application Content
$appContent = new APPContent();
$actionFactory = $appContent->getActionFactory();

// Get view mode
$viewMode = engine::getVar("mode");

// Build the application view content
$appContent->build("", "appListContainer", TRUE);
$appList = HTML::select(".appList .list")->item(0);

// Check if there are developer apps
$devApplications = devApps::getDevApplications();
$isDev = !empty($devApplications);

// Create dashboard
if ($isDev)
{
	$title = DOM::create("h2", "Team Apps", "", "hd");
	DOM::append($appList, $title);
}
$marketApplications = appMarket::getTeamApplications();
foreach ($marketApplications as $appInfo)
{
	// Build the app box
	$appBox = buildAppBox($appInfo['application_id'], $appInfo, $actionFactory, $viewMode);
	DOM::append($appList, $appBox);
}

if ($isDev)
{
	$title = DOM::create("h2", "Developer Apps", "", "hd");
	DOM::append($appList, $title);
	foreach ($devApplications as $appInfo)
	{
		// Build the app box
		$appBox = buildAppBox($appInfo['id'], $appInfo, $actionFactory, $viewMode);
		DOM::append($appList, $appBox);
	}
}

// Return output
return $appContent->getReport();

function buildAppBox($applicationID, $appInfo, $actionFactory, $viewMode)
{
	// Create application grid box
	$appBox = DOM::create("div", "", "", "appBox");
	
	// Set action to load explorer
	$attr = array();
	$attr['app_id'] = $applicationID;
	$attr['app_name'] = $appInfo['title'];
	$attr['mode'] = $viewMode;
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
	
	return $appBox;
}
//#section_end#
?>
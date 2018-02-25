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
$appContent->build("", "fullExplorerContainer");

// Create file explorer
$fxID = "fullFileExplorer".team::getTeamID()."_".time()."_".mt_rand();
$fe = new fileExplorer(team::getTeamFolder(), $fxID, team::getTeamName(), $showHidden = FALSE, $readOnly = TRUE);

// Get all team applications to create the map
$teamApps = appMarket::getTeamApplications();
$nameMap = array();
foreach ($teamApps as $appInfo)
{
	$appFolderName = application::getAppFolderName($appInfo['application_id']);
	$nameMap[$appFolderName] = (empty($appInfo['name']) ? str_replace(" ", "_", $appInfo['title']) : $appInfo['name']);
}

// Build file explorer
$subpath = "/";
$teamExplorer = $fe->build($subpath, $nameMap)->get();
$appContent->append($teamExplorer);

// Return output
return $appContent->getReport();
//#section_end#
?>
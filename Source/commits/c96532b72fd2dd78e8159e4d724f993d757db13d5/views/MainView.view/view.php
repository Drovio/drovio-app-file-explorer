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
importer::import("UI", "Apps");
importer::import("INU", "Views");

// Import APP Packages
//#section_end#
//#section#[view]
use \API\Profile\team;
use \UI\Apps\APPContent;
use \INU\Views\fileExplorer;

// Create Application Content
$appContent = new APPContent($appID);
$actionFactory = $appContent->getActionFactory();

// Build the application view content
$appContent->build("", "TeamFileExplorer");

// Create file explorer
$rootPath = team::getTeamFolder();
$teamName = team::getTeamName();
$fe = new fileExplorer($rootPath, $id = "teamFolderExplorer", $friendlyRootName = $teamName, $showHidden = FALSE, $readOnly = FALSE);
$teamExplorer = $fe->build()->get();
$appContent->append($teamExplorer);

// Return output
return $appContent->getReport();
//#section_end#
?>
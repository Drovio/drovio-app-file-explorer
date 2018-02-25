var jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Initialize first explorer
	jq(document).on("content.modified", function() {
		jq(".fileExplorerApplication .sidebar .menuitem.init").removeClass("init").trigger("click");
	});
	
	// Init first item
	jq(".fileExplorerApplication .sidebar .menuitem.init").removeClass("init").trigger("click");
	
	// Open and close directory menus
	jq(document).on("click", ".fileExplorerApplication .sidebar .side_title", function() {
		// Check if this is selected
		if (jq(this).hasClass("selected"))
			return;
		
		// Set selected
		jq(".side_title").removeClass("selected");
		jq(this).addClass("selected");
		
		// Show only current
		jq(".menu-container").animate({
			height: "toggle"
		}, 200);//.addClass("open");
	});
});
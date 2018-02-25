var jq = jQuery.noConflict();
jq(document).one("ready", function() {
	// Initialize first explorer
	jq(document).on("content.modified", function() {
		jq(".fileExplorerApplication .sidebar .menuitem.init").removeClass("init").trigger("click");
	});
});
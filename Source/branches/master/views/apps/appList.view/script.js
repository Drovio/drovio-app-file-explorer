jq = jQuery.noConflict();
jq(document).one("ready", function() {
	jq(document).on("applist.switchto.explorer", function(ev, context) {
		// Set visibility
		jq(".appList").addClass("fxview");
		jq(".appList .pathbar").addClass("fxview");
		
		// Add mi
		jq(".appList .pathbar .mi.current").html(context);
	});
	
	jq(document).on("click", ".appList .pathbar .mi.all", function() {
		jq(".appList").removeClass("fxview");
		jq(".appList .pathbar").removeClass("fxview");
	});
});
/**
 * Backend JavaScript for module NewsReader.
 *
 * @version         0.4.0
 * @lastmodified    May 2015
 *
 */
function popUp(URL) {
   	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, \'" + id + "\', \'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=400\');");
}

function testRDF(URL, aFormName) {
	var nrWindow;
	var fRef = document.getElementById(aFormName);

	if (fRef) {	
		var values =  "/?RSS_URI=" + fRef.uri.value;
		values += "&SHOW_IMAGE=" + fRef.show_image.value;
		values += "&SHOW_DESCRIPTION=" + fRef.show_desc.value;
		values += "&MAX_ITEMS=" + fRef.show_limit.value;
		values += "&CODE_FROM=" + fRef.coding_from.value;
		values += "&CODE_TO=" + fRef.coding_to.value;
		values += "&USE_UTF8ENCODE=" + (fRef.use_utf8_encode.checked ? fRef.use_utf8_encode.value : 0);
		values += "&OWN_DATEFORMAT=" + fRef.own_dateformat.value;
		
		// document.write(values);
		nrWindow = open(URL + values,"Test", 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=400');
		nrWindow.resizeTo(800,400);
	}
}
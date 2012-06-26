window.onload = init; 

var selections;

function init() {

	selections = document.getElementById( "selections" );//.value;
	
	// slightly bymanuscript specific code
	// snag the file from the URL 
	var prev_selection = getURLParam( 'file' );	

	// if file exists
	if ( prev_selection ) {

		// get the menu button and add the text
		var prev = document.getElementById( prev_selection );
		add_text( prev );
	
	}

	// end slightly bymanuscript specific code
	
}

function add_text( elt ) {
 
	// code specific to bymanuscript
	// removes previous selections as only one manuscript can be selected	

	if ( selections.children[0] ) {

		// grab the previous text from selection bin
		var oldtext = selections.children[0];

		// get the id of the text, which will be "selTEXTNAME"
		// and take out the "sel"
		var oldtextid = oldtext.id;
		oldtextid = oldtextid.replace( "sel", "" );

		// grab the menu element with the id and delete it and it's
		// corresponding element in the selection div
		oldtext = document.getElementById( oldtextid );
		del_text( oldtext );

	}

	// end specific code
	 
	// get the text name and s/ /_/
	var text = elt.innerHTML; // or id
	//text.replace( " ", "_" );

	// update the class to change appearence
	var classlist = elt.className;
	classlist = classlist.replace( "unchecked", "checked" );

	// update attributes to effectivly reverse this process onclick	
	elt.setAttribute( "onclick", "del_text(this);" );
	elt.setAttribute( "class", classlist );

	// create node with text
	var newtext = document.createTextNode( text );

	// create div and place that text in a div
	var newgraf = document.createElement( "tr" );
	newgraf.appendChild( newtext );

	// set id to something unique
	newgraf.setAttribute( "id", "sel" + text );

	// add the new span as a child
	selections.appendChild( newgraf );

	// add the selection to the hidden form field 'print'
	document.getElementById( 'print' ).value = text;

}

function del_text( elt ) {

	// get the text name
	var text = elt.innerHTML; // or id
	
	// the list of classes of the object
	var classlist = elt.className;

	// unmark the text
	classlist = classlist.replace( "checked", "unchecked" );

	// update attributes to effectivly reverse this process onclick	
	elt.setAttribute( "onclick", "add_text(this);" );
	elt.setAttribute( "class", classlist );

	// delete the bit from the selection box
	var delgraf = document.getElementById( "sel" + text );
	selections.removeChild( delgraf );
	

}


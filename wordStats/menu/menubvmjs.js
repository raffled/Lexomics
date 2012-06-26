// menubvmjs.js
window.onload = init; 

var selections;		// div with appearing and disappearing text choices
var magic_print;	// hidden box that actually stores the text choices

// function init()
// 	runs onload
// fetches selections and print elements, initializes them
// to whatever was passed in the 'file' param of the URL
function init() {

	selections = document.getElementById( "selections" );//.value;
	magic_print = document.getElementById( "print" );//.value;

	// ensure that the form field is empty,
	// FIREFOX doesn't empty on refresh
	magic_print.value = "";
	
	// BVM specific code
	// snag the file(s) from the URL  
	var prev_selection = getURLParam( 'file' );	

	var prev_array = prev_selection.split( "+" );

	// if file(s) exists
	if ( prev_array[0] ) {

		// reselect all the text
		for ( var i in prev_array ) {
		
			// get the menu button and add the text
			var prev = document.getElementById( prev_array[i] );
			add_text( prev );
	
		}
	
	}

	// end BVM specific code
	
}

// function add_text( Object )
// takes a span object with the id of the text or submenu selected
// 	if text has submenus, propegate down
// 	else add the text to the selection div and the print form that builds the url
function add_text( elt ) {

	// if element is part of sub1 or sub2 classes, ie
	//  the entire corpus or a genre, return, too many
	//  things to select
	if ( elt.className.match( /sub(1|2)/gi ) ) {

		return;

	}

	// if the span has a submenu, propegate to the bottom and exit
	if ( next( elt ) ) {

		propagate( elt );
		return;

	}
 
	// get the text name and s/ /_/
	var text = elt.innerHTML; // or id
	//text.replace( " ", "_" );

	// update the class to change appearence
	var classlist = elt.className;
	classlist = classlist.replace( /unchecked/, "checked" );

	// update attributes to effectivly reverse this process onclick
	elt.setAttribute( "onclick", "del_text(this);" );
	elt.setAttribute( "class", classlist );

	// create node with text
	var newtext = document.createTextNode( text );

	// create div and place that text in a div
	var newgraf = document.createElement( "div" );
	newgraf.appendChild( newtext );

	// set id to something unique
	newgraf.setAttribute( "id", "sel" + text );

	// add the new div as a child
	selections.appendChild( newgraf );

	// add the selection to the hidden form field 'print'
	magic_print.value += ' ' + text;
	magic_print.value = magic_print.value.replace( /  /g, " "  );
	magic_print.value = magic_print.value.replace( /^ /, "" );	

}

// function del_text( Object )
// like add_text but undoes the changes of add text
function del_text( elt ) {

	// if the span has a submenu, propegate to the bottom and exit
	if ( next( elt ) ) {

		propagate( elt );
		return;

	}

	// get the text name
	var text = elt.innerHTML; // or id
	
	// the list of classes of the object
	var classlist = elt.className;

	// unmark the text
	classlist = classlist.replace( /checked/g, "unchecked" );

	// update attributes to effectivly reverse this process onclick	
	elt.setAttribute( "onclick", "add_text(this);" );
	elt.setAttribute( "class", classlist );

	// delete the bit from the selection box
	var delgraf = document.getElementById( "sel" + text );
	selections.removeChild( delgraf );

	// delete from the hidden box of magic
	// lot of hackery here to keep url valid
	var old_print = magic_print.value;
	magic_print.value = magic_print.value.replace( text, ""  );
	magic_print.value = magic_print.value.replace( /  /g, " "  );
	magic_print.value = magic_print.value.replace( /^ /, "" );	

}

// function propegate( Object )
// takes an element object, if the object has no siblings, click it
//   a span should be passed, if it has a ul sibling (ie. a submenu),
//   then propagate further until a span is encountered with no ul
//   siblings
function propagate( elt ) {

	if ( next( elt ) ) {//elt.nextSibling ) {

		var ul = next( elt );
		for ( var i = 0; i < ul.children.length; i++ ) {
			
			propagate( ul.children[i].children[0] );

		}

	}
	else {

		elt.onclick();

	}

}

// function next( Object )
// grab the next real sibling
// many, but not all, browsers see whitespace and comments as siblings
//   but define them as a #text node or nodeType == 1
function next( elem ) {

	do {

		elem = elem.nextSibling;

	} while (elem && elem.nodeType != 1);

	return elem;  
              
}


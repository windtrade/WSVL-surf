/*
 * general.js
 *
 * 01-02-2013 : Huug: Creation
 */
function loadPage(page)
{
	window.location.assign(page);
}

/*
 * setAndSubmitformId, [fieldName, value] ...)
 */
function setAndSubmit()
{
    if (arguments.length <  3) {
	window.alert("Too few arguments");
	return false;
    }
    if (arguments.length%2 == 0) {
	window.alert("Incomplete fieldName/value pairs");
	return false;
    }
    var formId =  arguments[0];
    var form = document.getElementById(formId);
    if (!form) {
	window.alert(formId + " niet gevonden");
	return false;
    }
    var elts = form.elements;
    for (var j=1; j < arguments.length; j++) {
	var fieldName = arguments[j++];
	var value = arguments[j++];
	// The backslash must be backslashed
	// or the resulting patt won't work
	var patt =new RegExp(fieldName + "[\\]]*$", "");
	for (var i = 0; i < elts.length ; i++) {
	    if (elts[i].name.match(patt)) {
		elts[i].value = value;
		break;
	    }
	}
	if (i >= elts.length) {
	    window.alert(fieldName+" not found");
	    return false;
	}
    }
    form.submit();
    return true;
}

function showLogin()
{
	var login = document.getElementById("login");
	if (!login) {
		window.alert("Sorry, deze functie is niet beschikbaar");
		return;
	}
	login.style.height="2em";
	login.style.visibility="visible";
	login.style.textIndent="50%";
}
/*!
 * makes user log in or moves to personal pagae
 */
function showPersonal()
{
	if (gLoggedIn == 0) {
		showLogin();
		return;
	}
	loadPage("showPersonal.php");
}

/*
 * returns the first row in a table within a form
 * that holds a sunmit button
 * or false when the form is not found, or no
 * submit button is found within the form
 */
function formButtonRow(id)
{
    form = document.getElementById(id);
    if (!form) return false;
    submitButton = false;
    for (var i = 0; i < form.elements.length ; i++) {
	if (from.elements[i].type == 'submit') {
	    submitButton = form.elements[i];
	    break;
	}
    }
    if (!submitButton) return false;
    if (submitButton.parentNode.tagName != 'td') return false;
    if (submitButton.parentNode.parentNode.tagName != 'tr') return false;
    return submitButton.parentNode.parentNode;
}

function addAttr(elt, attrName, attrValue)
{
    var attr=document.createAttibute(attrName);
    attr.nodeValue=attrValue;
    elt.setAttibuteNode(attr);
}

function addInputRow( nextRow, label, type, disabled, value)
{
    if (!before) return false;
    var tr = document.createElement('TR');
    var td =  document.createElement('TD');
    var n =document.createTextNode(label);
    td.appendChild(n);
    tr.appendChild(td);
    td = document.createElement('TD');
    if (disabled) {
	n = document.createTextNode(value);
    } else {
	var input = document.createNode('INPUT');
	addAttr(input, "type", type);
	addAttr(input, "value", value);
    }
    td.appendChild(n);
    tr.appendChild(td);
    nextRow.parentNode.insertBefore(tr);
}
    


	

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

/**
 * obj is expected to have members that match
 * existing div elements in the page
 * obj = { block: [ {property:val, ...} , ...  ], ...}
 * msg is the most common property
 */
function displayMessages(obj, keep)
{
    var blocks = ["errors", "infos"];
    for (var i = 0; i < blocks.length; i++) {
        var block = blocks[i];
        if ($("."+ block)) {
            if (!keep) $("."+ block).html("")
            var list = obj[block];
            $.each(list, function(key, val) {
                for (property in val) {
                var msg = "<div class='"+property+"'>" +val[property] + "</div>";
                $( "."+ block ).append( msg );
                }
            });
        }
    }
}

function testDisplayMessages()
{
        var obj = {"firstName":"John", "lastName":"Doe",
        "infos": [ 
        {"msg":"info 1"},
        {"msg":"info 2"}, 
        {"msg":"info 3"},
        ],
        "errors": [ 
        {"msg":"error 1"},
        {"msg":"error 2"}, 
        {"msg":"error 3"},
        ]};
      displayMessages(obj, false);
}
// Show or hide the login
function showLogin(showIt)
{
    if (showIt) {
        $(".login").show();
    } else {
        $(".login").hide();
    }
}

function uriForJSON()
{
    var uri = document.documentURI;
    uri = uri.replace(/[^\/]*$/, '')+'jsonAction.php';
    return uri;
}

function logonJSON()
{
    var result = true;
    var uri = document.documentURI;
    uri = uriForJSON();
    // All input elements of login form
    var inputs = $("form[name=loginform]  input");
    var getdata = {};
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].name.length >0) {
            getdata[inputs[i].name] = inputs[i].value;
        }
    }
    getdata["JSON"] = true;
    $.getJSON(uriForJSON(),
        getdata,
        function(response, status, xhr)
        {
            displayMessages(response, false);
            if(response["status"] === false) {
                showLogin(true);
            } else {
                showLogin(false);
                resetMenuJSON();
            }
        });
}

function logoutJSON()
{
    resetMenu();
    var getdata = { JSON: true, action: "JSONlogout"};
    $.getJSON(uriForJSON(),
        getdata,
        function(response, status, xhr)
        {
            displayMessages(response,false);
            resetMenuJSON(); 
        });
}

// Send an authority request, let callBack handle the response
function ifAuthorized(targetUrl,callBack)
{
    var result;
    var getData = {JSON: true, action:"JSONauthority", "targetURL":targetUrl };
    $.getJSON(
        uriForJSON(),
        getData,
        callBack
    );
}

/**
 * test if user is authorized to submit form, if so:
 * submit form through callback function
 */
function submitIfAuthorized(elt, event)
{
    event.preventDefault();
    var obj = elt;
    var eltform = elt.form;
    var targetUrl = elt.form.getAttribute("action");
    ifAuthorized(
        targetUrl,
        function(response, status, xhr)
        {
            displayMessages(response, false);
            if (response["authorized"]) {
                eltform.submit();
            } else {
                showLogin(true);
            }
        });
}

/**
 * Adds onclicks to various types of elements
 */
function addOnClicks()
{
      $("#login").click(function(){
        showLogin(true);
        resetMenu();
        return false;
        }
      );
      $("#logout").click(function(){
        logoutJSON();
        return false;
        }
      );
}

/**
 * fold up the menu;
 */
function resetMenu(menu)
{
    /**
     This should trick the pull-down menu to fold
    $("#cssmenu").find().mouseout();
    $("#cssmenu").find().mouseleave();
    */
    if (!menu) var menu = $("#cssmenu").html();
    $("#cssmenu").html("");
    $("#cssmenu").html(menu);
    addOnClicks();
    return false;    
}

function resetMenuJSON()
{
    var getdata = { JSON: true, action: "JSONmenu"};
    $.getJSON(uriForJSON(),
        getdata,
        function(response, status, xhr)
        {
            displayMessages(response, true);
            resetMenu(response["menu"]); 
        });
}

function bulkCheck(event, label, checked)
{
    event.preventDefault();
    $("input[type='checkbox'][name^='"+label+"']").prop('checked', checked);
    return false;
}
	

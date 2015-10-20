function renameElement(elt, origNr, newNr)
{
}
    
function copyGroup(name)
{
    var src = document.getElementsByName(name);
    var i;
    var dst = new Array();
    window.alert(name+"gevonden "+src.length);
    for (i=0;i<src.length;i++) {
	dst[i] = src[i].cloneNode();
	renameElement(dst[i],origNr, newNr);
    }
    
}
function switchList(form, prefix, enabled)
{
    var x=document.getElementById(form);
    if (x===undefined) {
	return;
    }
    var pattern = prefix.replace(/\[/g, "\\\[");
    pattern = "^"+pattern.replace(/\]/g, "\\\]");
    for (var i=0; i< x.elements.length; i++) {
	var name = x.elements[i].name;
	if (x.elements[i].name.indexOf(prefix) == 0) {
	    x.elements[i].disabled=(enabled? false : true);
	}
    }
    return;
}

function getValueFromXMLTag(node, label, defValue)
{
	rs = node.getElementsByTagName(label);
	if (rs.length == 0 ||
			rs[0].childNodes.length == 0) { return defValue; }
	return rs[0].childNodes[0].nodeValue;

}
function createXMLHttp()
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

/*
 * function: addMissingInputToForm
 * when no form element with id "field" is not
 * already present in "form" it is added as hidden
 * input with id and name "field" amd value "val"
 */
function addMissingInputToForm(form, field, val)
{
	if (document.getElementById(field)) {
		return;
	}
	// create/insert new
	var el = document.createElement("input");
	el = form.appendChild(el);
	el.name = field;
	el.id = field;
	el.type = "hidden";
	el.value = val;
}

function getIdElts(id)
{
	return id.split('_');
}

function getIdGroup(id)
{
	var idElts = getIdElts(id);
	if (idElts.length < 2) return false;
	return idElts[1];
}

function getIdLabel(id)
{
	var idElts = getIdElts(id);
	if (idElts.length < 2) return false;
	return idElts[0];
}

function finishGroup(myForm, group, uniqueKey)
{
	for (i=0; i<myForm.elements.length;i++) {
		myElement = myForm.elements[i];
		myGroup = getIdGroup(myElement.id);
		if (myGroup != group) continue;
		myLabel = getIdLabel(myElement.id);
		if (myLabel=="decision" ||
				myLabel=="upload") {
			myElement.disabled=true;
		} else if (myLabel=="match") {
			myParent = myElement.parentNode;
			while (myParent.childNodes.length > 0) {
				myParent.removeChild(myParent.childNodes[0]);
			}
			myParent.appendChild(document.createTextNode(uniqueKey));
		}
	}
	// hide datarows, data_key_n is the name of the <TD> holding the 
	// unique key of the data row
	x=document.getElementsByName("data_key_"+group);
	for (i=0; i<x.length; i++) {
		x[i].parentNode.style.display="none";
	}
	reportError(group,"");
}

function reportError(group, error) {
	if (error=="") {
		styleDisplay="none";
	} else {
		styleDisplay="";
	}
	elt = document.getElementById("error_"+group); // element in row that gave the error
	if (elt) {
		elt.style.display=styleDisplay;
		elt.innerHTML=error;
	} else {
		window.alert(error);
	}
}

function processResults(myForm, results)
{
	for (i=0 ; i < results.length;i++) {
		defValue = -1;
		retStatus = getValueFromXMLTag(results[i], "status",defValue);
		retGroup = getValueFromXMLTag(results[i], "group", defValue);
		retUniqueKey = getValueFromXMLTag(results[i], "uniqueKey",defValue);
		retError = getValueFromXMLTag(results[i], "error", "");
		if (retStatus == defValue) {
			reportError(retGroup, "Status veld ontbreekt");
			return;
		}
		if (retStatus == 0) {
			reportError(retGroup, retError);
			return;
		}
		finishGroup(myForm, retGroup, retUniqueKey);
	}
}
function processDecision()
{
	/*
	 * This fuction be triggered by an element with 
	 * id = "<label>_<nr>";
	 * <nr> is used to determine all other form elements to be sent along:
	 * "match_<nr>" holds the unique key to be uodated, if any
	 * "upload_<nr>_<column> hods the value for <column> to be updated/inserted
	 * "data_<nr>_<uk>_<column> holds the original value of <column> in the record with
	 * 	unique key <uk>
	 * only data_<nr>_<uk> is sent where <uk> == match_<nr>
	 */
	var myForm = event.srcElement.form;
	var decisionId = event.srcElement.id;
	var group = getIdGroup(decisionId);
	var match;
	var dataParts = new Array();
	var urlToGet = processingPage;
	var uniqueKey = document.getElementById("uniqueKey");
	if (uniqueKey == undefined) {
		window.alert("Veld uniqueKey niet aanwezig, sorry...");
		return;
	}
	urlToGet += "?"+decisionId+"="+encodeURIComponent(event.srcElement.value)+
		"&"+uniqueKey.id+"="+uniqueKey.value;
	for (i=0 ; i < myForm.elements.length; i++) {
		var myId = myForm.elements[i].id;
		var myIdElts = getIdElts(myId);
		var myGroup = getIdGroup(myId);
		var myLabel = getIdLabel(myId);
		if (myGroup === false || group != myGroup) continue;
		// id is structured label_group[_uniqueKey][_col]
		if (myLabel == "match") {
			if (myForm.elements[i].value != "") {
				match = myForm.elements[i].value;
			}
			urlToGet += "&"+myForm.elements[i].id+"="+
				encodeURIComponent(myForm.elements[i].value);
		}
		if (myLabel == "upload") {
			urlToGet += "&"+myForm.elements[i].id+"="+
				encodeURIComponent(myForm.elements[i].value);
		}
		if (myLabel == "data") {
			var myUniqueKey = myIdElts[2];
			if (dataParts[myUniqueKey] == undefined) {
				dataParts[myUniqueKey] = "";
			}
			dataParts[myUniqueKey] += "&"+myId+"="+
				encodeURIComponent(myForm.elements[i].value);
		}
	}
	if (match != undefined) {
		urlToGet = urlToGet + dataParts[match];
	}
	xmlhttp = createXMLHttp();
	xmlhttp.open('GET', urlToGet, false);
	xmlhttp.send();
	if (xmlhttp.readyState==4) {
		if (xmlhttp.status != 200) {
			reportError(-1, processingPage+" returned status "+
					xmlhttp.status);
			return;
		}
	} else {
		reportError(-1, "Unexpected ready state for "+processingPage+
				" state="+xmlhttp.readyState);
		return;
	}
	xmlText = xmlhttp.responseText; // just for debugging... 
	xmlResponse = xmlhttp.responseXML;
	if (null == xmlResponse) {
		reportError(-1, "geen correcte XML respons: "+xmlText);
		return;
	}
	if (null == xmlResponse.getElementsByTagName("results")) {
		reportError(-1, "geen resultaten in respons");
		return;
	}
	x = xmlResponse.getElementsByTagName("result");
	if(null == x) {
		reportError(-1, "geen resultaat in respons");
		return;
	}
	processResults(myForm, x);
}

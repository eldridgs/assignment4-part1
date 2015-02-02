var httpRequest;
if (window.XMLHttpRequest) {
  httpRequest = new XMLHttpRequest();
} else {
  throw 'Unable to create request!';
}
var pageOptions = document.getElementsByName('page_options');
//var python = document.getElementById("language_python").checked;
//var json = document.getElementById("language_json").checked;
//var javascript = document.getElementById("language_javascript").checked;
//var sql = document.getElementById("language_SQL").checked;
var url = 'https://api.github.com/gists/public?page=' + pageOptions.toString();

httpRequest.open('GET', url, true);
httpRequest.send();

httpRequest.onreadystatechange = function() {
  if (this.readyState === 4) {
    if (this.status === 200) {
	  //if (python == false && json == false && javascript == false && sql == false) {
	    //document.getElementById('userGists').innerHTML = JSON.parse(XMLHttpRequest.responseText);
	  //}
	  //else {
	    for (var language in XMLHttpRequest.responseText) {
		  if (document.getElementById("language_python").checked == true) {
		    document.getElementById('userGists').innerHTML = JSON.parse(XMLHttpRequest.responseText);
		  }
		  if (json == true) {
		    document.getElementById('userGists').innerHTML = JSON.parse(XMLHttpRequest.responseText);
		  }
		  if (javascript == true) {
		    document.getElementById('userGists').innerHTML = JSON.parse(XMLHttpRequest.responseText);
		  }
		  if (sql == true) {
		    document.getElementById('userGists').innerHTML = JSON.parse(XMLHttpRequest.responseText);
		  }
	    }
	  }
    }
  }

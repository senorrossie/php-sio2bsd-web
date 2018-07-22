  function loadDoc(_param, _elid="msg-bar") {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       document.getElementById(_elid).innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", _param, true);
    xhttp.send();
  }

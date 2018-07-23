/*** Drag n Drop ***/
function allowDrop(ev) {
    ev.preventDefault();
}
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}
function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data).cloneNode(true));
    msg = "Dropped a disk on " + data + "\n";
    var drives = [ "drive1", "drive2", "drive3", "drive4"];
    for (i = 0; i < drives.length; i++) {
        var _el = document.getElementById(drives[i]);
        var _hasChild = _el.hasChildNodes();
        if (_hasChild == true ) {
            msg += "D" + i + ": [";
            msg += _el.firstChild.id;
            msg += "]\n";
        }
    }
    alert(msg);
}
function eject(ev) {
    ev.preventDefault();
    var el = document.getElementById(ev.dataTransfer.getData('Text'));
    el.parentNode.removeChild(el);
}

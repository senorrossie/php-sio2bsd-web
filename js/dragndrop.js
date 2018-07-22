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
}
function eject(ev) {
    ev.preventDefault();
    var el = document.getElementById(ev.dataTransfer.getData('Text'));
    el.parentNode.removeChild(el);
}

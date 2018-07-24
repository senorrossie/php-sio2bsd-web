/*** Floppy Logic ***/
function hasDisks () {
  var empty = "-";
  var myDrives = ["drive1", "drive2", "drive3", "drive4"];
  var myFloppies = {};
  for( var i=0; i < myDrives.length; i++) {
      var dId = i + 1;
      var d = "drive" + dId;
      if( document.getElementById(d).getElementsByTagName("img")[0] ) {
        myFloppies[i] = document.getElementById(d).getElementsByTagName("img")[0].id;
      } else {
        myFloppies[i] = empty;
      }
      console.log(" contains - " + myFloppies[i]);
  }
  return(myFloppies);
}
function swapDisks (_Floppies) {
  var myFloppies = JSON.stringify(_Floppies);
  loadDoc('swap_floppies.php?drives=' + myFloppies, 'msg-bar');
}
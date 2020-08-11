/* Dore Single Theme Initializer Script 

Table of Contents

01. Single Theme Initializer
*/

/* 01. Single Theme Initializer */

$().ready(function () {
  if ($().dropzone) {
    Dropzone.autoDiscover = false;
  }
  var $dore = $("body").dore();
});

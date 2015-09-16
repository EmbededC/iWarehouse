/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* Function to response when user press Enter key on containerCode textbox */
document.getElementById('containerCode').onkeypress = function(e){
    if (!e) e = window.event;
    var keyCode = e.keyCode || e.which;
    if (keyCode == '13'){
      // Enter pressed
      if (document.getElementById('containerCode').value == '')
      {
        window.location = './';
        return false;
      }
      else
      {
        window.location = document.getElementById('containerCode').value;
        return false;
      }
    }
}


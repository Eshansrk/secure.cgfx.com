
  showNoti();

  function showNoti(){
  	var noti = document.getElementById('noti-body').innerHTML;
 	if (noti != "") {
    	document.getElementById('notification').style.display = "block";
    	setTimeout(closeNoti,5000);
        }
    }

  function closeNoti(){
    document.getElementById('notification').style.display = "none";
  }
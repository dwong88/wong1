function popup(pageURL, windowname, w, h) 
{
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, windowname, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=1, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	targetWin.focus();
}
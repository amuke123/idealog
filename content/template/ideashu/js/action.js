// JavaScript Document

function good(aid,path){
	var ajcode=document.getElementById("ajcode").value;
	url=path+'include/action/action.php';
	data="ajcode="+ajcode
		+"&aid="+aid
		+"&type="+"good"
	sendHttpPost(url,data);
}

function bad(aid,path){
	var ajcode=document.getElementById("ajcode").value;
	url=path+'include/action/action.php';
	data="ajcode="+ajcode
		+"&aid="+aid
		+"&type="+"bad"
	sendHttpPost(url,data);
}
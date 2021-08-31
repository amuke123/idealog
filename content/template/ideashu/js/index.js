// JavaScript Document

function listorcard(key,el){
	var alist=el.parentNode.getElementsByTagName('a');
	var ul=el.parentNode.parentNode.getElementsByTagName('ul')[0];
	var pages=el.parentNode.parentNode.getElementsByClassName('list_page')[0].getElementsByTagName('a');
	alist[0].className = key=="list"?'active':'';
	alist[1].className = key=="list"?'':'active';
	for(i=0;i<pages.length;i++){
		phref=pages[i].href.split('&');
		pages[i].href=phref[0]+'&style='+key;
	}
	ul.className = 'art'+key;
}

function commentReply(pid,c,txt){
	var response = document.getElementById('comment-post');
	document.getElementById('comment-pid').value = pid;
	var text2="@"+txt;
	document.getElementById('comment').setAttribute("placeholder",text2);
	c.parentNode.parentNode.parentNode.appendChild(response);
	document.getElementById('cancel-reply').style.display = 'block';
}

function cancelReply(){
	var commentPlace = document.getElementById('comment-place'),response = document.getElementById('comment-post');
	document.getElementById('comment-pid').value = 0;
	document.getElementById('comment').setAttribute("placeholder",'相信你的评论可以一针见血！');
	document.getElementById('cancel-reply').style.display = 'none';
	commentPlace.appendChild(response);
}
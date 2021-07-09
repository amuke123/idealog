// JavaScript Document

function listorcard(key,el){
	var alist=el.parentNode.getElementsByTagName('a');
	var ul=el.parentNode.parentNode.getElementsByTagName('ul')[0];
	alist[0].className = key=="list"?'active':'';
	alist[1].className = key=="list"?'':'active';
	ul.className = 'art'+key;
}
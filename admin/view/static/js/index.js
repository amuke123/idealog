// JavaScript Document

function show(el){
	var pro=el.getElementsByTagName('i')[1];
	var par=el.parentNode;
	pro.className=par.className==''?'icon2 aicon-fold2':'icon2 aicon-fold';
	par.className=par.className==''?'active':'';
}

function hide(){
	var side=document.getElementById('side');
	var head=document.getElementById('head');
	var main=document.getElementById('main');
	side.className=side.className=='side'?'side sidehide':'side';
	head.className=side.className=='side'?'head':'head leftall';
	main.className=side.className=='side'?'main':'main leftall';
}

function autoShow(post,list=''){
	var nav = document.getElementById('nav_'+post);
	nav.parentElement.className = list==''?'action':'active';
	if(list!=''){
		var num = nav.childElementCount-1;
		nav.children[num].className = 'icon2 aicon-fold2';
		document.getElementById('nav_'+list).parentElement.className = 'action';
	}
}

function showurl(key){
	var ycxz = document.getElementById('ycxz');
	var geturl = document.getElementById('geturl');
	if(key==1){ycxz.style.display="inline-block";geturl.style.display="none";}
	if(key==2){ycxz.style.display="none";geturl.style.display="inline-block";}
}
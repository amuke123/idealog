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

function show_add(box){
	var add = document.getElementById(box);
	add.style.display = add.style.display != 'block' ? 'block' : 'none' ;
}


function yzBannAdd2(){
	if(bannadd.pic2.value==""){
		if(bannadd.pic.value==""){
			prompt1('请选择图片');
			bannadd.pic.focus();
			return false;
		}
	}
}
function yzBannAdd(){
	if(bannadd.pic.value==""){
		prompt1('请选择图片');
		bannadd.pic.focus();
		return false;
	}
}

function prompt1(str){
	hint=document.getElementById('hint');
	hint.innerHTML=str;
	hint.style.display="block";
	setTimeout("prompt2(hint)",3000);
}
function prompt2(hint){
	hint.style.display="none";
}
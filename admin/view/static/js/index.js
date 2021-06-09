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
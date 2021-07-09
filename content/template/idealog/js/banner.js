// JavaScript Document
window.onload=function(){
	//轮播图
	var curIndex=0;//初始化
	var key=0;//控制切换变量
	var keypower=400;//时间控制，keypower * 10 后单位是 毫秒
	var alpha=0;
	var img_number = document.getElementsByClassName('tabImg').length;
	var _timer = setInterval(runFn,10);//4秒，10为更新频率，与判断语句中的400共同控制更新时间4秒
	function runFn(){ //运行定时器
		if(key > keypower ){//keypower=400,keypower*10=4000 毫秒 = 4 秒，与上面的更新频率结合控制时间
			curIndex = ++curIndex == img_number ? 0 : curIndex;//算法 4为banner图片数量
		}
		slideTo(curIndex);
	 }
	 
	//圆点点击切换轮播图
	

	function tabBtnFc(num){
		clearInterval(_timer);//细节处理，关闭定时，防止点切图和定时器函数冲突
		key=0;
		curIndex = num;
		slideTo(num);
		_timer = setInterval(runFn,10);//点击事件处理完成，继续开启定时轮播
	}

	var prve = document.getElementsByClassName("prve");
	prve[0].onclick = function () {//上一张
		clearInterval(_timer);//细节处理，关闭定时，防止点切图和定时器函数冲突
		curIndex--;
		key=0;
		if(curIndex == -1){
			curIndex = img_number-1;
		}
		slideTo(curIndex);
		_timer = setInterval(runFn,10);//点击事件处理完成，继续开启定时轮播
	}

	var next = document.getElementsByClassName("next");
	next[0].onclick = function () {//下一张
		clearInterval(_timer);//细节处理，关闭定时，防止点切图和定时器函数冲突
		curIndex++;
		key=0;
		if(curIndex == img_number){
			curIndex =0;
		}
		slideTo(curIndex);
		_timer = setInterval(runFn,10);//点击事件处理完成，继续开启定时轮播
	}

	//切换banner图片 和 按钮样式
	function slideTo(index){
		var index = parseInt(index);
		var images = document.getElementsByClassName('tabImg');
		if(key>( keypower -50)){hidepic(images,curIndex);}
		for(var i=0;i<images.length;i++){//遍历每个图片
			if( i == index ){
				images[i].style.display = 'inline';//显示            
			}else{
				images[i].style.display = 'none';//隐藏
			}
		}
		var tabBtn = document.getElementsByClassName('tabBtn');
		for(var j=0;j<tabBtn.length;j++){//遍历每个按钮
			if( j == index ){
				tabBtn[j].classList.add("hover");    //添加轮播按钮hover样式
				curIndex=j;
			}else{
				tabBtn[j].classList.remove("hover");//去除轮播按钮hover样式
			}
		}
		if(key<50){showpic(images,index);}
		if(key> keypower ){key=0;}else{key++;}//400*10=4000 毫秒 = 4 秒，与上面的更新频率结合控制时间
	}
	function showpic(imgarr,index2){//下一张图片透明度逐渐显示
		imgarr[index2].style.opacity= alpha / 100;
		imgarr[index2].style.filter = 'alpha(opacity='+alpha+')';
		if(alpha < 100){alpha = alpha + 2;}
	}
	function hidepic(imgarr,index2){//上一张图片透明度逐渐隐藏
		imgarr[index2].style.opacity= alpha / 100;
		imgarr[index2].style.filter = 'alpha(opacity='+alpha+')';
		if(alpha > 0){alpha = alpha - 2;}
	}
}
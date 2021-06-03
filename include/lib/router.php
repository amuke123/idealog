<?php
//路由
class Router{

    private static $model = '';//模型控制器
    private static $method = '';//控制器方法
    private static $params;//请求参数
    private static $routers;//路由表
    private static $path = NULL;//访问路径
	
	private static function auto(){
        self::$path = self::setPath();
        self::$routers = Control::getRoute();

        $urlType = Control::get('url_type');
        foreach(self::$routers as $route) {
            if(!isset($route['reg_'.$urlType])){
                $reg = isset($route['reg']) ? $route['reg'] : $route['reg_1'];
            }else{
                $reg = $route['reg_'.$urlType];
            }
            if(preg_match($reg,self::$path,$matches)){
                self::$model = $route['model'];
                self::$method = $route['method'];
                self::$params = $matches;
                break;
            }else if(preg_match($route['reg_1'],self::$path,$matches)){
                self::$model = $route['model'];
                self::$method = $route['method'];
                self::$params = $matches;
                break;
            }
        }

        if(empty(self::$model)){show_404();exit;}
    }
	
	public static function dispatch(){
		self::auto();

		$module = new self::$model();
		$methods = self::$method;
		$module->$methods(self::$params);
	}
	
	public static function setPath(){
        $path = '';
        if(isset($_SERVER['HTTP_X_REWRITE_URL'])){ 
            $path = $_SERVER['HTTP_X_REWRITE_URL'];
        }elseif(isset($_SERVER['REQUEST_URI'])){
            $path = $_SERVER['REQUEST_URI'];
        }else{
            if(isset($_SERVER['argv'])) {
                $path = $_SERVER['PHP_SELF'].'?'.$_SERVER['argv'][0];
            }else{
                $path = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
            }
        }

        if(isset($_SERVER['SERVER_SOFTWARE']) && false !== stristr($_SERVER['SERVER_SOFTWARE'],'IIS')){
            if(function_exists('mb_convert_encoding')){
                $path = mb_convert_encoding($path,'UTF-8','GBK');
            }else{
                $path = @iconv('GBK','UTF-8',@iconv('UTF-8','GBK',$path)) == $path ? $path : @iconv('GBK','UTF-8',$path);
            }
        }
        $r = explode('#', $path, 2);
        $path = $r[0];
        $path = str_ireplace('index.php','',$path);
        $t = parse_url(IDEA_URL);
        $path = str_replace($t['path'],'/',$path);

        return $path;
    }
}

?>
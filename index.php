<?php 
	const CONTROLLERS = 'controllers/';
	const VIEWS = 'views/';

	class Router{
		private static $request = [
			'Controller'=>'HomeController',
			'Action'=>'index_action'
		];

		public static function init(){
			self::getRequest();
			self::initPage();
		}

		public static function error404(){
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
			include VIEWS.'404.php';
		}

		public static function getRequest(){
			// self::$request = 
			list($controller, $action) = explode('/',trim($_SERVER['REQUEST_URI'],'/'));
			if(!empty($controller)) self::$request['Controller'] = $controller.'Controller';
			if(!empty($action))	self::$request['Action'] = $action.'_action';
		}
		private function initPage(){
			$controllerFile = CONTROLLERS . ucfirst(self::$request['Controller']) . '.php';
			$pageController = ucfirst(self::$request['Controller']);
			$pageAction = self::$request['Action'];
			if(file_exists($controllerFile)){
				require_once $controllerFile;
				$page = new $pageController();
				if(method_exists(self::$request['Controller'], self::$request['Action'])){						
					$page->$pageAction();
				}else{
					self::error404();
				}
			}else{
				self::error404();
			}
		}
	}
	Router::init();
?>
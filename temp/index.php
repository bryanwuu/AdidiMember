<?php
class Control {
    static function exceptionResponse($statusCode, $message) {
        header("HTTP/1.0 {$statusCode} {$message}");
        echo "{$statusCode} {$message}";
        exit;
    }
 
    function index() {
        echo 'index...';
    }
} 
 
interface RESTfulInterface {
    public function restGet($segments);
    public function restPut($segments);
    public function restPost($segments);
    public function restDelete($segments);
}
 
class Container extends Control {
    private $control = false;
    private $segments = false;
 
    function __construct() {
    	echo '測試1 path info = '. $_SERVER['PATH_INFO'].'<BR>';
        if ( !isset($_SERVER['PATH_INFO']) or $_SERVER['PATH_INFO'] == '/') {
            // $this->control = $this->segments = false;
     	echo '2 path info = '. $_SERVER['PATH_INFO'].'<BR>';
           return;
        }
 
        $this->segments = explode('/', $_SERVER['PATH_INFO']);
        $test = array_shift($this->segments); // first element always is an empty string.
        echo '$$test  = '. $test .'<BR>';
        
        $controlName = ucfirst(array_shift($this->segments));
        echo '$controlNameinfo = '. $controlName.'<BR>';
         
        if ( !class_exists($controlName) ) {
            $controlFilepath = $controlName . '.php';
 
            if ( file_exists($controlFilepath) ) { // 載入客戶要求的 control
                require_once $controlFilepath;
            }
            else { // 找不到客戶要求的 control
                self::exceptionResponse(503, 'Service Unavailable!');
                // 回傳 501 (Not Implemented) 或 503.
                // See also: RFC 2616
            }
        }
 
        $this->control = new $controlName;
    }
 
    function index() {
        echo 'index.php/{control name}/{object id}';
    }
 
    function run() {
        if ( $this->control === false) {
        	echo "1<br>";
            return $this->index();
        }
 
        if ( empty($this->segments) ) { // Without parameter
        	echo "2<br>";
        	return $this->control->index();
        }
 
        //request resource by RESTful way.
        //$method = $this->restMethodname;
        $method = 'rest' . ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
        if ( !method_exists($this->control, $method) ) {
        	echo "3<br>";
        	 
            self::exceptionResponse(405, 'Method not Allowed!');
        }
         
        $arguments = $this->segments;
 
        $this->control->$method($arguments);
    }
} //end class Container
 
$container = new Container();
 
$container->run();
 
?>
<?php

class SoictApp {

    private static $_helpers = array();
    private static $_instanse;

    public static function getInstanse(){
        if ( ! self::$_instanse ) {
            self::$_instanse = new self();
        }
        return self::$_instanse;
    }

    public static function getController($name, $area = ''){
        $controller = false;
        $name_path = explode('/', str_replace('\\', '/', trim($name, '/')));
        foreach($name_path as $key => $path) $name_path[$key] = ucfirst($path);
        $name = str_replace('-', '_', implode( DS, $name_path ));
        if($name){
            if($area == 'backend'){
                if(file_exists(SOICT_PLUGIN_DIR . 'controllers'. DS . 'adminhtml' . DS . $name.'.php')){
                    include SOICT_PLUGIN_DIR . 'controllers'. DS . 'adminhtml' . DS . $name.'.php';
                    $className = '\\Soict\\Controller\\Adminhtml\\'.str_replace(DS, '\\', $name);
                    $controller = new $className ();
                    return $controller;
                }
            }else{
                if(file_exists(SOICT_PLUGIN_DIR . 'controllers'. DS .$name.'.php')){
                    include SOICT_PLUGIN_DIR . 'controllers'. DS . $name.'.php';
                    $className = '\\Soict\\Controller\\'.str_replace(DS, '\\', $name);
                    if (class_exists($className)) {
                        return new $className ();
                    }
                    return false;
                }
            }
        }

        return $controller;
    }

    public static function getView($name, $area = ''){
        if($area == 'backend'){
            if(file_exists(SOICT_PLUGIN_DIR . 'views'. DS . 'adminhtml' . DS . 'templates' . DS . $name)){
                return SOICT_PLUGIN_DIR . 'views'. DS . 'adminhtml' . DS . 'templates' . DS . $name;
            }
        }else{
            if(file_exists(SOICT_PLUGIN_DIR . 'views'. DS . 'frontend' . DS . 'templates' . DS . $name)){
                return SOICT_PLUGIN_DIR . 'views'. DS . 'frontend' . DS . 'templates' . DS . $name;
            }
        }
        return false;
    }

    public static function getModel($name){
        $obj = new stdClass();
        $names = explode('\\', str_replace('/', '\\', $name));
        foreach($names as $key => $n){
            $names[$key] = ucfirst($n);
        }
        $name = implode('\\', $names);
        $file = SOICT_PLUGIN_MODEL_DIR . implode(DS, $names). '.php';
        if(file_exists($file)){
            require_once $file;
            $className = SOICT_PREFIX . '\\Model\\' . ucfirst($name);
            $obj = new $className ();
        }

        return $obj;
    }

    public static function helper($name){
        $obj = new stdClass();
        $names = explode('\\', str_replace('/', '\\', $name));
        foreach($names as $key => $n){
            $names[$key] = ucfirst($n);
        }
        $name = implode('\\', $names);
        $file = SOICT_PLUGIN_HELPER_DIR .implode(DS, $names). '.php';
        if(file_exists($file)){
            require_once $file;
            if ( !isset(self::$_helpers[$name]) ) {
                $className = SOICT_PREFIX . '\\Helper\\'. ucfirst($name);
                self::$_helpers[$name] = new $className ();
            }
            return self::$_helpers[$name];
        }
        return $obj;
    }

    public static function validator($name){
        $obj = new stdClass();
        $names = explode('\\', str_replace('/', '\\', $name));
        foreach($names as $key => $n){
            $names[$key] = ucfirst($n);
        }
        $name = implode('\\', $names);
        $file = SOICT_PLUGIN_VALIDATOR_DIR .implode(DS, $names). '.php';
        if(file_exists($file)){
            require_once $file;
            $className = SOICT_PREFIX . '\\Validator\\'. ucfirst($name);
            $obj = new $className ();
        }
        return $obj;
    }

    public static function getCssUrl($file, $area = ''){
        if($area == 'backend'){
            $fileUrl = SOICT_PLUGIN_PUBLIC_BACKEND_VIEW_URI . '/css/'.$file;
        }else{
            if(file_exists(get_template_directory().DS.'assets'.DS.'css'.DS.str_replace('/', '\\', $file))){
                return get_template_directory_uri().'/assets/css/'.$file;
            }
            $fileUrl = SOICT_PLUGIN_PUBLIC_FRONTEND_VIEW_URI. '/css/'.$file;
        }
        return $fileUrl;
    }

    public static function getJsUrl($file, $area = ''){
        if($area == 'backend'){
            $fileUrl = SOICT_PLUGIN_PUBLIC_BACKEND_VIEW_URI . '/js/'.$file;
        }else{
            if(file_exists(get_template_directory().DS.'assets'.DS.'js'.DS.str_replace('/', '\\', $file))){
                return get_template_directory_uri().'/assets/js/'.$file;
            }
            $fileUrl = SOICT_PLUGIN_PUBLIC_FRONTEND_VIEW_URI. '/js/'.$file;
        }
        return $fileUrl;
    }

    public static function getImageUrl($file, $area = ''){
        if($area == 'backend'){
            $fileUrl = SOICT_PLUGIN_PUBLIC_BACKEND_VIEW_URI . '/images/'.$file;
        }else{
            if(file_exists(get_template_directory().DS.'assets'.DS.'images'.DS.str_replace('/', '\\', $file))){
                return get_template_directory_uri().'/assets/images/'.$file;
            }
            $fileUrl = SOICT_PLUGIN_PUBLIC_FRONTEND_VIEW_URI. '/images/'.$file;
        }
        return $fileUrl;
    }

    public static function getPublicUrl($file, $area = ''){
        if($area == 'backend'){
            $fileUrl = SOICT_PLUGIN_PUBLIC_BACKEND_VIEW_URI . '/'.$file;
        }else{
            $fileUrl = SOICT_PLUGIN_PUBLIC_FRONTEND_VIEW_URI. '/'.$file;
        }
        return $fileUrl;
    }

    /**
     * dispatch all url to controller if match
     * get dispatch from url
     */
    public static function dispatch(){
        $domain = trim(str_replace(array('http://', 'https://'), array('', ''), $_SERVER['HTTP_HOST']), '/');
        $rewriteBaseurl = str_replace(array('http://'.$domain, 'https://'.$domain), array('', ''), home_url());
        $queries = explode('?', $_SERVER['REQUEST_URI']);
        $requestUri = str_replace($rewriteBaseurl, '', $queries[0]);
        if(is_admin() || ( defined( 'WP_CLI' ) && WP_CLI )){
            $controller = \SoictApp::getController($requestUri, 'backend');
            if($controller){
                $controller->init();
                $controller->display();
            }
        }else{
            $controller = \SoictApp::getController($requestUri);
            if($controller){
                $controller->init();
            }
        }

        return false;
    }

    //remove home_url
    public static function getUrlPath($url = ''){
        $domain = trim(str_replace(array('http://', 'https://'), array('', ''), $_SERVER['HTTP_HOST']), '/');
        $rewriteBase = str_replace(array('http://'.$domain, 'https://'.$domain), array('', ''), home_url());
        if($url){
            return str_replace(array('http://'.$domain.$rewriteBase, 'https://'.$domain.$rewriteBase), array('', ''), $url);
        }
        return str_replace($rewriteBase, '', $_SERVER['REQUEST_URI']);
    }

    //home_url + url_path
    public static function getFullUrl($urlPath = ''){
        return home_url(self::getUrlPath($urlPath));
    }

    //remove absolute dir path, from document root site
    public static function getDirPath($file){
        return str_replace(ABSPATH, '', $file);
    }
}
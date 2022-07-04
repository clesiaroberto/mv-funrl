<?php
	/*
	 * Directory router
	 * Update version 1.0.5
	 * Abr 20 of 2021
	 * Clésia Chale
	*/

	namespace funeraria\router;
	use \funeraria\config\config AS con;

	class config extends con {

		function __construct() {
            global $router;
            $base = $this->getCurrentUri();
		    $this->router = explode('/', $base);
        }

        function _getDefault() {
        	return $this->router;
        }

		function _getUrl($key = "") {
		    $url = (count($this->router) > 2) ? "../../" : "./" ;

		    switch ($key) {
		    	case 'url':
		    		return $url;
		    		break;
		    	
		    	default:
		    		return ((empty($key)) ? $this->router : $this->router[$key] );
		    		break;
		    }
		}

		function _getRouter($key = "") {
			if (in_array($key, ['2', '3', '4'])) {
				return $this->router[$key];
			} else {
				return $this->router['1'];
			}
		}
	}
?>
<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 10-Mar-20
	 * Time: 10:28 PM
	 */
	
	function __autoload( $class_name ) {
		if ( file_exists( './' . $class_name . '.php' ) ) {
			require_once './' . $class_name . '.php';
		}
	}
	
	$requestMethod = $_SERVER["REQUEST_METHOD"];
	if($requestMethod == 'GET'){
		$getRequest = new GetRequest();
	}elseif($requestMethod == 'POST'){
		$postRequest = new PostRequest();
	}elseif($requestMethod == 'DELETE'){
		$deleteRequest = new DeleteRequest();
	}elseif($requestMethod == 'PUT'){
		$putRequest = new PutRequest();
	}

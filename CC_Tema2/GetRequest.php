<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 10-Mar-20
	 * Time: 9:46 PM
	 */
	
	class GetRequest {
		
		private static $validPaths = ["entities"];
		
		public function __construct(  ) {
			
			$requestedPath = explode('/',$_SERVER['REQUEST_URI']);
			array_shift( $requestedPath);
			array_shift( $requestedPath);
			
			if(in_array($requestedPath[0], self::$validPaths) && count($requestedPath) == 2){
				$this->displayResource( $requestedPath[1] );
			}else{
				http_response_code( 404 );
				die();
			}
		}
		
		public function displayResource( $id ) {
			try {
				$db     = new DbConnection();
				$sql    = "SELECT * FROM ENTITIES WHERE Id = $id";
				$result = $db->queryDatabase( $sql );
				
				if($result == false){
					http_response_code( 404 );
					echo json_encode(
						[
							'status'  => 404,
							'message' => 'Resource Not Found'
						]
					);
				}else{
					http_response_code( 200 );
					echo json_encode(
						[
							'status'  => 200,
							'message' => $result[0]
						]
					);
				}
			}catch(Exception $e){
				http_response_code( 500 );
				echo json_encode(
					[
						'status'  => 500,
						'message' => 'Internal Server Error'
					]
				);
				die();
			}
		}
	}

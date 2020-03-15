<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 10-Mar-20
	 * Time: 9:45 PM
	 */
	
	class PostRequest {
		
		private static $validPaths = ['entities'];
		
		public function __construct() {
			
			$requestedPath = explode( '/', $_SERVER['REQUEST_URI'] );
			
			array_shift( $requestedPath );
			array_shift( $requestedPath );
			
			if ( in_array( $requestedPath[0], self::$validPaths ) && count( $requestedPath ) == 1 ) {
				$this->insertData();
			} else {
				http_response_code( 404 );
				die();
			}
			
		}
		
		public function insertData() {
			try {
				$data      = $_POST;
				$firstName = $data['first_name'];
				$lastName  = $data['last_name'];
				$age       = $data['age'];
				$height    = $data['height'];
				$telephone = $data['telephone'];
				$email     = $data['email'];
				$sql       = "INSERT INTO `entities`(`LastName`, `FirstName`, `Age`, `Height`, `Telephone`, `Email`) VALUES ('$lastName','$firstName','$age','$height','$telephone','$email');";
				
				$db     = new DbConnection();
				$result = $db->insertInDatabase( $sql );
				
				if($result){
					http_response_code( 200 );
					echo json_encode(
						[
							'status' => 200,
							'message' => 'success'
						]
					);
				}else{
					http_response_code( 500 );
					echo json_encode(
						[
							'status'  => 500,
							'message' => 'fail'
						]
					);
					die();
				}
				
			} catch( Exception $e ) {
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

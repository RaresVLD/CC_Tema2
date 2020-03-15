<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 11-Mar-20
	 * Time: 9:07 PM
	 */
	
	class PutRequest {
		
		private static $validPaths = [ 'entities' ];
		
		public function __construct() {
			
			$requestedPath = explode( '/', $_SERVER['REQUEST_URI'] );
			
			array_shift( $requestedPath );
			array_shift( $requestedPath );
			
			if ( in_array( $requestedPath[0], self::$validPaths ) && count( $requestedPath ) == 1 ) {
				$this->putData();
			} else {
				http_response_code( 404 );
				die();
			}
			
		}
		
		public function putData() {
			try {
				$data = $this->prepareData();
				
				$firstName = $data['first_name'];
				$lastName  = $data['last_name'];
				$age       = $data['age'];
				$height    = $data['height'];
				$telephone = $data['telephone'];
				$email     = $data['email'];
				
				$db       = new DbConnection();
				$checkSql = "SELECT Id FROM ENTITIES WHERE LastName like '$lastName' AND  FirstName like '$firstName' AND Age = $age AND Height = $height AND Telephone like '$telephone' AND Email like '$email'";
				
				$exists = $db->queryDatabase( $checkSql );
				if ( isset( $exists[0] ) && $exists[0]['Id'] ) {
					$id        = $exists[0]['Id'];
					$updateSql = "UPDATE `ENTITIES` SET `LastName`='$lastName',`FirstName`='$firstName',`Age`='$age',`Height`='$height',`Telephone`='$telephone',`Email`='$email' WHERE `Id` = $id";
					$result    = $db->updateRow( $updateSql );
					
					if ( $result ) {
						http_response_code( 200 );
						echo json_encode(
							[
								'status'  => 200,
								'message' => 'Updated!'
							]
						);
					} else {
						http_response_code( 500 );
						echo json_encode(
							[
								'status'  => 500,
								'message' => 'Internal Server Error'
							]
						);
					}
					
				} else {
					$insertSql = "INSERT INTO `entities`(`LastName`, `FirstName`, `Age`, `Height`, `Telephone`, `Email`) VALUES ('$lastName','$firstName','$age','$height','$telephone','$email');";
					$result    = $db->insertInDatabase( $insertSql );
					if ( $result ) {
						http_response_code( 200 );
						echo json_encode(
							[
								'status'  => 200,
								'message' => 'Inserted!'
							]
						);
					} else {
						http_response_code( 500 );
						echo json_encode(
							[
								'status'  => 500,
								'message' => 'Internal Server Error'
							]
						);
					}
				}
			} catch( Exception $e ) {
				http_response_code( 500 );
				echo json_encode(
					[
						'status'  => 500,
						'message' => 'Internal Server Error'
					]
				);
			}
		}
		
		public function prepareData() {
			
			parse_str( file_get_contents( "php://input" ), $_PUT );
			
			foreach ( $_PUT as $key => $value ) {
				unset( $_PUT[ $key ] );
				
				$_PUT[ str_replace( 'amp;', '', $key ) ] = $value;
			}
			
			return $_PUT;
		}
	}

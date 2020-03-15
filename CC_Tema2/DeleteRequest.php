<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 11-Mar-20
	 * Time: 8:52 PM
	 */
	
	class DeleteRequest {
		
		private static $validPaths = [ "entities" ];
		
		public function __construct(  ) {
			
			$requestedPath = explode( '/', $_SERVER['REQUEST_URI'] );
			array_shift( $requestedPath );
			array_shift( $requestedPath );
			
			if ( in_array( $requestedPath[0], self::$validPaths ) && count( $requestedPath ) == 2 ) {
				$this->deleteResource( $requestedPath[1] );
			} else {
				http_response_code( 404 );
				die();
			}
		}
		
		public function deleteResource( $id ) {
			try {
				$db     = new DbConnection();
				$sql    = "DELETE FROM ENTITIES WHERE Id = $id";
				$result = $db->deleteFromDatabase( $sql );
				
				if ( $result == false ) {
					http_response_code( 500 );
					echo json_encode(
						[
							'status'  => 500,
							'message' => 'Internal Server Error'
						]
					);
				} else {
					http_response_code( 200 );
					echo json_encode(
						[
							'status'  => 200,
							'message' => 'Entity deleted'
						]
					);
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

<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 10-Mar-20
	 * Time: 9:11 PM
	 */
	
	class DbConnection {
		
		private static $host     = 'localhost';
		private static $username = 'root';
		private static $pass     = 'svp2019';
		private static $db       = 'cc_tema2';
		
		public static function connect() {
			$conn = new mysqli( self::$host,
			                    self::$username,
			                    self::$pass,
			                    self::$db );
			mysqli_set_charset( $conn, 'utf8' );
			
			return $conn;
		}
		
		public function queryDatabase( $sql ) {
			$result = self::connect()->query( $sql );
			
			$return = [];
			
			if ( $result->num_rows == 0 ) {
				return false;
			}
			
			if ( $result->num_rows > 0 ) {
				while( $row = $result->fetch_assoc() ) {
					$return[] = $row;
				}
			}
			
			return $return;
		}
		
		public function insertInDatabase( $sql ) {
			$result = self::connect()->query( $sql );
			if ( $result ) {
				return true;
			}
			
			return false;
		}
		
		public function deleteFromDatabase( $sql ) {
			$result = self::connect()->query( $sql );
			if ( $result ) {
				return true;
			}
			
			return false;
		}
		
		public function updateRow( $sql ) {
			$result = self::connect()->query( $sql );
			if ( $result ) {
				return true;
			}
			
			return false;
		}
		
		public function createTables() {
			$this->queryDatabase( "
				CREATE TABLE Entities (
					    Id int NOT NULL AUTO_INCREMENT,
					    LastName varchar(255) NOT NULL,
					    FirstName varchar(255),
					    Age int,
					    Height int,
					    Telephone varchar(255),
					    Email varchar(255),
					    PRIMARY KEY (Id)
				);
			" );
		}
	}

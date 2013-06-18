<?php

	require_once("mysqliFunctions.php");


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts a single row into the instrument table.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$type: the name of the type of instrument
	 */
	function insert_instrument($mysqli, $type) {

		//Prepare insert statement:
          if(!($stmt = $mysqli->prepare("INSERT INTO instrument (type) VALUES (?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   
    
          //Bind variables:
          if(!($stmt->bind_param("s", $type))) {
               echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }   
    
          //Execute statement:
          if(!($stmt->execute())) {
               echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }   
          else {
               echo "<p>Added " . $stmt->affected_rows . " row(s) to instrument.</p>";
		}
		$stmt->close();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts a single row into the musician table.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$stage_name: musician's full stage name
	 * 		$first_name: musician's first name
	 *		$middle_name: musician's middle name
	 * 		$last_name: musician's last name
	 *		$born: year born
	 *		$died: year died
	 *		$hometown: musician's home town
	 *		$homestate: musician's home state
	 */
	function insert_musician($mysqli, $stage_name, $first_name, $middle_name, $last_name, $born, $died, $hometown, $homestate) {

		//Prepare insert statement:
          if(!($stmt = $mysqli->prepare("INSERT INTO musician (stage_name, first_name, middle_name, last_name, born, died, hometown, homestate) VALUES (?, ?, ?, ?, ?, ?, ?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   
    
          //Bind variables:
          if(!($stmt->bind_param("ssssiisi", $stage_name, $first_name, $middle_name, $last_name, $born, $died, $hometown, $homestate))) {
               echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }   
    
          //Execute statement:
          if(!($stmt->execute())) {
               echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }   
          else {
               echo "<p>Added " . $stmt->affected_rows . " row(s) to musician.</p>";
		}
		$stmt->close();
	}

	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts multiple rows into the musician_instrument table, specifying
	 *		which instruments a given musician played
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$musician_id: id for the musician in question
	 * 		$song_id: array of ids for the instruments played
	 */
	function insert_musician_instrument($mysqli, $musician_id, $instrument_ids) {

		if(!($stmt = $mysqli->prepare("INSERT INTO musician_instrument (musician_id, instrument_id) VALUES (?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   
		
		$count=0;
          foreach ($instrument_ids as $instrument_id) {
			$count++;

               //Bind variables:
               if(!($stmt->bind_param("ii", $musician_id, $instrument_id))) {
                    echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   

               if(!($stmt->execute())) {
                    echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   
  		}
		echo "<p>Added " . $count . " row(s) to musician_instrument.</p>";    
		$stmt->close();
	}


	function insert_record_label($mysqli, $name, $year_founded) {
		$sql = "INSERT INTO record_label (name, year_founded) VALUES (?, ?);";
		$stmt = prepareStmt($mysqli, $sql);

		if(!($stmt->bind_param("si", $name, $year_founded))) {
               echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
		}

          //Execute statement:
          if(!($stmt->execute())) {
               echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }
          else {
               echo "<p>Added " . $stmt->affected_rows . " row(s) to record_label.</p>";    
          }
		$stmt->close();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts a single row into the album table.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$title: title of the album
	 *		$year: year album was released
	 *		$record_label: record label that produced the album
	 */
	function insert_album($mysqli, $title, $year, $record_label) {

		if(!($stmt = $mysqli->prepare("INSERT INTO album (title, year, record_label) VALUES (?, ?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }
          
          //Bind variables:
          if(!($stmt->bind_param("sii", $title, $year, $record_label))) {
               echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }
          
          //Execute statement:
          if(!($stmt->execute())) {
               echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }
          else {
               echo "<p>Added " . $stmt->affected_rows . " row(s) to album.</p>";    
          }
		$stmt->close();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts multiple rows into the musician_album table, specifying
	 *		which musicians played on the specified album.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$musician_ids: array of ids for musicians who played on the album
	 * 		$album_id: id for the album in question
	 */
	function insert_musician_album($mysqli, $musician_ids, $album_id) {
		
		if(!($stmt = $mysqli->prepare("INSERT INTO musician_album (musician_id, album_id) VALUES (?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   
		
		$count=0;
          foreach ($musician_ids as $musician_id) {
			$count++;

               //Bind variables:
               if(!($stmt->bind_param("ii", $musician_id, $album_id))) {
                    echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   

               if(!($stmt->execute())) {
                    echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   
  		}
		echo "<p>Added " . $count . " row(s) to musician_album.</p>";    
		$stmt->close();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts a single row into the song table.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$title: title of the song
	 * 		$year_written: year the song was written
	 */
	function insert_song($mysqli, $title, $year_written) {
	
		if(!($stmt = $mysqli->prepare("INSERT INTO song (title, year_written) VALUES (?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }
          
          //Bind variables:
          if(!($stmt->bind_param("si", $title, $year_written))) {
               echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }
          
          //Execute statement:
          if(!($stmt->execute())) {
               echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }
          else {
               echo "<p>Added " . $stmt->affected_rows . " row(s) to song.</p>";    
          }
		$stmt->close();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts multiple rows into the musician_song table, specifying
	 *		which musicians wrote which songs.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$musician_ids: array of ids for musicians who played on the album
	 * 		$song_id: id for the song in question
	 */
	function insert_musician_song($mysqli, $musician_ids, $song_id) {
		
		if(!($stmt = $mysqli->prepare("INSERT INTO musician_song (musician_id, song_id) VALUES (?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   
		
		$count=0;
          foreach ($musician_ids as $musician_id) {
			$count++;

               //Bind variables:
               if(!($stmt->bind_param("ii", $musician_id, $song_id))) {
                    echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   

               if(!($stmt->execute())) {
                    echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   
  		}
		echo "<p>Added " . $count . " row(s) to musician_song.</p>";    
		$stmt->close();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts a single row into the song_version table.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$song: title of the song
	 * 		$year_written: year the song was written
	 */
	function insert_song_version($mysqli, $song_id, $album_id, $name, $lyrics) {
	
		if(!($stmt = $mysqli->prepare("INSERT INTO song_version (song_id, album_id, name, lyrics) VALUES (?, ?, ?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }
          
          //Bind variables:
          if(!($stmt->bind_param("iiss", $song_id, $album_id, $name, $lyrics))) {
               echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }
          
          //Execute statement:
          if(!($stmt->execute())) {
               echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }
          else {
               echo "<p>Added " . $stmt->affected_rows . " row(s) to song_version.</p>";    
          }
		$stmt->close();
	}

	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts multiple rows into the musician_song_version table, specifying
	 *		which musicians played in a given song version
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$musician_ids: Array of ids for musicians who played in the song_version
	 * 		$song_version_id: id of the song_version in question
	 */
	function insert_musician_song_version($mysqli, $musician_ids, $song_version_id) {
		
		if(!($stmt = $mysqli->prepare("INSERT INTO musician_song_version (musician_id, song_version_id) VALUES (?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   
		
		$count=0;
          foreach ($musician_ids as $musician_id) {
			$count++;

               //Bind variables:
               if(!($stmt->bind_param("ii", $musician_id, $song_version_id))) {
                    echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   

               if(!($stmt->execute())) {
                    echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   
  		}
		echo "<p>Added " . $count . " row(s) to musician_song_verion.</p>";    
		$stmt->close();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	 * Inserts multiple rows into the musician_influence table, specifying
	 *		which musicians influenced a given musician.
	 * Param: $mysqli: mysqli object for the folk_music database
	 *		$musician_id: id of the musician in question
	 * 		$influence_ids: array of ids for musicians who influenced the given musician
	 */
	function insert_musician_influence($mysqli, $musician_id, $influence_ids) {
		
		if(!($stmt = $mysqli->prepare("INSERT INTO musician_influence (musician_id, influence_id) VALUES (?, ?);"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   
		
		$count=0;
          foreach ($influence_ids as $influence_id) {
			$count++;

               //Bind variables:
               if(!($stmt->bind_param("ii", $musician_id, $influence_id))) {
                    echo "<p>Bind failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   

               if(!($stmt->execute())) {
                    echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
               }   
  		}
		echo "<p>Added " . $count . " row(s) to musician_influence.</p>";    
		$stmt->close();
	}


     /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
      * Returns the maximum ID from the specified table.  Useful for getting
      *        the ID of the last row added to a table.
      * Param: $mysqli: mysqli object for the folk_music database
      *        $table: name of the table from which to get the max id
      */
     function getMaxID($mysqli, $table) {

          if(!($stmt = $mysqli->prepare("SELECT MAX(id) FROM " . $table . " ;"))) {
               echo "<p>Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "</p>";
          }   

          if(!($stmt->execute())) {
               echo "<p>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</p>";
          }   

          if(!$stmt->bind_result($max_id)) {
               echo "<p>Bind failed: (" . $stmt->connect_errno . ") " . $stmt->connect_error . "</p>";
          }   
          $stmt->fetch();
          $stmt->close();

          return $max_id;
     }   

?>


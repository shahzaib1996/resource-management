<!DOCTYPE html>
<html>
<head>
	<title>MULTIPLE</title>
</head>
<body>

	<form action="" method="POST" enctype="multipart/form-data">
		<input type="file" name="userfile[]" multiple="" />
		<input type="submit" name="submit" value="Upload" >

	</form>

	<?php
	include_once('connect.php');


	$phpFileUploadErrors = array(
		0 => 'There is no error, the file uploaded with success',
		1 => 'The uploaded file exceeds the upload_max filesize directive in php.ini',
		2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		3 => 'The uploade file was only partially uploaded',
		4 => 'No file was uploaded',
		6 => 'Missing a temporary folder',
		7 => 'Failed to write file to desk',
		8 => 'A PHP extension stopped the file upload',
	);





	if(isset($_FILES['userfile'])) {
		$checkError = false;
		$strattach = "";
		$file_array = reArrayFiles($_FILES['userfile']);
		// pre_r($file_array);

		for ($i=0; $i <count($file_array) ; $i++) { 

			if($file_array[$i]['error']) {
				echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']].' <br>';
				$checkError = true;
				break;
			} 
			else {
				$extensions = array('pdf', 'docx', 'doc', 'txt');
				$file_ext = explode('.',$file_array[$i]['name']);
				$file_ext = end($file_ext);


				if(!in_array($file_ext, $extensions)) {
					echo "{$file_array[$i]['name']} - Invalid File Extension! F<br>";

				} 
				else {
					move_uploaded_file($file_array[$i]['tmp_name'], "files/".$file_array[$i]['name']);
					echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']]." S<br> ";

					$filename = $file_array[$i]['name'];
					$filepath = "files/".$file_array[$i]['name'];

					if(!($checkError)) {
						$sql = "INSERT INTO attachments (filename, filepath)
						VALUES ('$filename', '$filepath')";

						if (mysqli_query($con, $sql)) {
							$msg = "<div class='nNote nSuccess'><p>Success! File Saved.</p></div>";
						} else {
							$msg = "<div class='nNote nFailure'><p>Error! File Not Saved.</p></div>";
						}

						$sqlfe = "SELECT * from attachments ORDER BY aid DESC";

						if ($re=mysqli_query($con,$sqlfe))
						{

							while ($row=mysqli_fetch_row($re))
							{
								echo $strattach."<br>";
								break;
							}

							mysqli_free_result($re);
						}


					}


					$checkError = false;
				}


			}


		}
	}





	function reArrayFiles( $file_post ) {
		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for( $i=0; $i<$file_count; $i++ ) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_ary;

	}



	function pre_r($array) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	?>

</body>
</html>
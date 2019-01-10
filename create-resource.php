<?php
include_once('connect.php');
session_start();

if ( !( isset( $_SESSION['username'] ) ) ) {
	header("Location: login.php");
}

include('class.pdf2text.php');

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title>Resource Management</title>

	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<!--[if IE]> <link href="css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>

	<script type="text/javascript" src="js/plugins/forms/ui.spinner.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.mousewheel.js"></script>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

	<script type="text/javascript" src="js/plugins/charts/excanvas.min.js"></script>
	<script type="text/javascript" src="js/plugins/charts/jquery.flot.js"></script>
	<script type="text/javascript" src="js/plugins/charts/jquery.flot.orderBars.js"></script>
	<script type="text/javascript" src="js/plugins/charts/jquery.flot.pie.js"></script>
	<script type="text/javascript" src="js/plugins/charts/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="js/plugins/charts/jquery.sparkline.min.js"></script>

	<script type="text/javascript" src="js/plugins/tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="js/plugins/tables/jquery.sortable.js"></script>
	<script type="text/javascript" src="js/plugins/tables/jquery.resizable.js"></script>

	<script type="text/javascript" src="js/plugins/forms/autogrowtextarea.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.uniform.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.inputlimiter.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.autotab.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.chosen.min.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.dualListBox.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.cleditor.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.ibutton.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.validationEngine-en.js"></script>
	<script type="text/javascript" src="js/plugins/forms/jquery.validationEngine.js"></script>

	<script type="text/javascript" src="js/plugins/uploader/plupload.js"></script>
	<script type="text/javascript" src="js/plugins/uploader/plupload.html4.js"></script>
	<script type="text/javascript" src="js/plugins/uploader/plupload.html5.js"></script>
	<script type="text/javascript" src="js/plugins/uploader/jquery.plupload.queue.js"></script>

	<script type="text/javascript" src="js/plugins/wizards/jquery.form.wizard.js"></script>
	<script type="text/javascript" src="js/plugins/wizards/jquery.validate.js"></script>
	<script type="text/javascript" src="js/plugins/wizards/jquery.form.js"></script>

	<script type="text/javascript" src="js/plugins/ui/jquery.collapsible.min.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.breadcrumbs.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.tipsy.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.progress.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.timeentry.min.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.colorpicker.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.jgrowl.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.fancybox.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.fileTree.js"></script>
	<script type="text/javascript" src="js/plugins/ui/jquery.sourcerer.js"></script>

	<script type="text/javascript" src="js/plugins/others/jquery.fullcalendar.js"></script>
	<script type="text/javascript" src="js/plugins/others/jquery.elfinder.js"></script>

	<script type="text/javascript" src="js/plugins/ui/jquery.easytabs.min.js"></script>
	<script type="text/javascript" src="js/files/bootstrap.js"></script>
	<script type="text/javascript" src="js/files/functions.js"></script>

	<script type="text/javascript" src="js/charts/chart.js"></script>
	<script type="text/javascript" src="js/charts/hBar_side.js"></script>

</head>

<body>

	<!-- Top line begins -->
	<div id="top">
		<div class="wrapper">
			<a href="#" title="" class="logo"><img src="images/img_logo.png" style="height: 30px;" alt="" /></a>

			<!-- Right top nav -->
			<div class="topNav">
				<ul class="userNav">
					<li><a href="logout.php" title="" class="logout"></a></li>
					<li class="showTabletP"><a href="#" title="" class="sidebar"></a></li>
				</ul>
				<a title="" class="iButton"></a>
				<a title="" class="iTop"></a>

			</div>

			<!-- Responsive nav -->
			<ul class="altMenu">
				<li><a href="index.php" title="" class="exp" id="current">Dashboard</a>
					<ul>
						<?php if($_SESSION['type'] == '1') { ?>
						<li><a href="index.php" title="" class="this">Home</a></li>
						<li><a href="create-resource.php" title="">Create Resource</a></li>
						<li><a href="search.php" title="">View Resources</a></li>
						<li><a href="viewusers.php" title="">View Users</a></li>
						<li><a href="adduser.php" title="">Add New User</a></li>
						<?php } else if($_SESSION['type'] == '0') { ?>
						<li><a href="index.php" title="" class="this">Home</a></li>
						<li><a href="create-resource.php" title="">Create Resource</a></li>
						<li><a href="search.php" title="">View Resources</a></li>
						<?php } ?>
					</ul>
				</li>

			</ul>
			<div class="clear"></div>
		</div>
	</div>
	<!-- Top line ends -->


	<!-- Sidebar begins -->
	<div id="sidebar">
		<div class="mainNav">
			<div class="user">
				<a title="" class="leftUserDrop"><img src="images/ie_logo.png" alt="" width="60px" /></a><span><?php echo $_SESSION['username']; ?></span>
				<ul class="leftUser">
					<li><a href="profile.php" title="" class="sProfile">Profile Settings</a></li>

				</ul>
			</div>

			<!-- Responsive nav -->
			<div class="altNav">
				<div class="userSearch">
					<h4><?php echo $_SESSION['username']; ?></h4>
				</div>

				<!-- User nav -->
				<ul class="userNav">
					<li><a href="profile.php" title="" class="settings"></a></li>
					<li><a href="logout.php" title="" class="logout"></a></li>
				</ul>
			</div>

			<!-- Main nav -->
			<ul class="nav">
				<li><a href="index.php" title="" class="active"><img src="images/icons/mainnav/dashboard.png" alt="" /><span>Dashboard</span></a>
					<ul>
						<?php if($_SESSION['type'] == '1') { ?>
						<li><a href="index.php" title="" ><span class="icon-arrow-right-6"></span>Home</a></li>
						<li><a href="create-resource.php" title="" class="this"><span class="icon-arrow-right-6"></span>Create Resource</a></li>
						<li><a href="search.php" title=""><span class="icon-arrow-right-6"></span>View Resources</a></li>
						<li><a href="viewusers.php" title=""><span class="icon-arrow-right-6"></span>View Users</a></li>
						<li><a href="adduser.php" title=""><span class="icon-arrow-right-6"></span>Add New User</a></li>
						<?php } else if($_SESSION['type'] == '0') { ?>
						<li><a href="index.php" title=""><span class="icon-arrow-right-6"></span>Home</a></li>
						<li><a href="create-resource.php" title="" class="this"><span class="icon-arrow-right-6"></span>Create Resource</a></li>
						<li><a href="search.php" title=""><span class="icon-arrow-right-6"></span>View Resources</a></li>
						<?php } ?>
					</ul>
				</li>

			</ul>
		</div>

		<!-- Secondary nav -->
		<div class="secNav">
			<div class="secWrapper">


				<!-- Tabs container -->
				<div id="tab-container" class="tab-container">
					<ul class="iconsLine ic3 etabs">
						<li><a href="#general" title=""><span class="icos-fullscreen"></span></a></li>
						<li><a href="#alt1" title=""><span class="icos-user"></span></a></li>
						<li><a href="#alt2" title=""><span class="icos-archive"></span></a></li>
					</ul>


					<div id="general">
						<ul class="subNav">
							<?php if($_SESSION['type'] == '1') { ?>
							<li><a href="index.php" title=""><span class="icon-arrow-right-6"></span>Home</a></li>
							<li><a href="create-resource.php" title="" class="this"><span class="icon-arrow-right-6"></span>Create Resource</a></li>
							<li><a href="search.php" title=""><span class="icon-arrow-right-6"></span>View Resources</a></li>
							<li><a href="viewusers.php" title=""><span class="icon-arrow-right-6"></span>View Users</a></li>
							<li><a href="adduser.php" title=""><span class="icon-arrow-right-6"></span>Add New User</a></li>
							<?php } else if($_SESSION['type'] == '0') { ?>
							<li><a href="index.php" title=""><span class="icon-arrow-right-6"></span>Home</a></li>
							<li><a href="create-resource.php" title="" class="this"><span class="icon-arrow-right-6"></span>Create Resource</a></li>
							<li><a href="search.php" title=""><span class="icon-arrow-right-6"></span>View Resources</a></li>
							<?php } ?>
						</ul>
					</div>


				</div>



			</div> 
			<div class="clear"></div>
		</div>
	</div>
	<!-- Sidebar ends -->


	<!-- Content begins -->
	<div id="content">
		<div class="contentTop">
			<span class="pageTitle"><span class="icon-screen"></span>Create Resource</span>

			<div class="clear"></div>
		</div>

		<!-- Breadcrumbs line -->
		<div class="breadLine">
			<div class="bc">
				<ul id="breadcrumbs" class="breadcrumbs">
					<li><a href="index.php">Dashboard</a></li>
					
					<li class="current"><a href="create-resource.php" title="">Create Resource</a></li>
				</ul>
			</div>

			<div class="breadLinks">

				<div class="clear"></div>
			</div>
		</div>

		<!-- Main content -->
		<div class="wrapper">

			<?php

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



			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				if (isset($_POST['submit'])) {

					$numfile = count(array_filter($_FILES['userfile']['name']));

					if( $numfile == 0 ) {

						$level = $_POST['level'];
						$subject = $_POST['subject'];
						$course = $_POST['course'];
						$module = $_POST['module'];
						$moduletitle = $_POST['moduletitle'];
						$lesson = $_POST['lesson'];
						$lessontitle = $_POST['lessontitle'];
						$mainidea = $_POST['mainidea'];
						$vocabulary = $_POST['vocabulary'];
						$keyconcept = $_POST['keyconcept'];
						$attach = "";

						$create_date = date("Y-m-d H:i:s");

						// $sqlwa = "INSERT INTO tab_resources (level, subject, course, module, module_title, lesson, lesson_title, main_idea, vocabulary, key_concept, attachments, created_date)
						// VALUES ('$level', '$subject', '$course', '$module', '$moduletitle', '$lesson', '$lessontitle', '$mainidea', '$vocabulary', '$keyconcept', '$attach','$create_date')";

						// if (mysqli_query($con, $sqlwa)) {
						// 	echo "<div class='nNote nSuccess'><p> Success! No File Attached! </p></div>";
						// 	echo "<div class='nNote nSuccess'><p> Success! Resource Submitted. </p></div>";
						// } else {
						// 	echo "<div class='nNote nFailure'><p> Failed! Resource Submission. </p></div>";
						// }

						

						$stmt = $mysqli->prepare("INSERT INTO tab_resources (level, subject, course, module, module_title, lesson, lesson_title, main_idea, vocabulary, key_concept, attachments, created_date)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$stmt->bind_Param("ssssssssssss", $level,$subject,$course,$module,$moduletitle,$lesson,$lessontitle,$mainidea,$vocabulary,$keyconcept,$attach,$create_date);
						

						if($stmt->execute()) {
							echo "<div class='nNote nSuccess'><p> Success! No File Attached! </p></div>";
							echo "<div class='nNote nSuccess'><p> Success! Resource Submitted. </p></div>";
						} else {
							echo "<div class='nNote nFailure'><p> Failed! Resource Submission. </p></div>";
						}


					} 
					else if( isset($_FILES['userfile']) ) {

						$level = $_POST['level'];
						$subject = $_POST['subject'];
						$course = $_POST['course'];
						$module = $_POST['module'];
						$moduletitle = $_POST['moduletitle'];
						$lesson = $_POST['lesson'];
						$lessontitle = $_POST['lessontitle'];
						$mainidea = $_POST['mainidea'];
						$vocabulary = $_POST['vocabulary'];
						$keyconcept = $_POST['keyconcept'];

						$checkError = false;
						$strattach = "";
						$file_array = reArrayFiles($_FILES['userfile']);
						// pre_r($file_array);

						for ($i=0; $i <count($file_array) ; $i++) { 

							

							if($file_array[$i]['error']) {

								echo "<div class='nNote nFailure'><p> ".$file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']]." </p></div>";

								echo "<div class='nNote nFailure'><p> FAILED! Resource Submission.  </p></div>";

								$checkError = true;
								break;

							} 
							else {
								$extensions = array('pdf', 'docx', 'doc', 'txt');
								$file_ext = explode('.',$file_array[$i]['name']);
								$file_ext = end($file_ext);


								if(!in_array($file_ext, $extensions)) {
									echo "<div class='nNote nSuccess'><p> {$file_array[$i]['name']} - Invalid File Extension! </p></div>";

								} 
								else {
									move_uploaded_file($file_array[$i]['tmp_name'], "files/".$file_array[$i]['name']);
									echo "<div class='nNote nSuccess'><p> ".$file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']]." </p></div>";

									$filename = $file_array[$i]['name'];
									$filepath = "files/".$file_array[$i]['name'];


									$a = new PDF2Text();
									$a->setFilename($filepath);
									$a->decodePDF();
									$contents = $a->output(); 

									$contents = str_replace(' ', '', $contents);


									if(!($checkError)) {


										$stmtt = $mysqli->prepare("INSERT INTO attachments (filename, filepath, contents)
										VALUES (?, ?, ?)");
										$stmtt->bind_Param("sss", $filename, $filepath, $contents);


										// $sql = "INSERT INTO attachments (filename, filepath, contents)
										// VALUES ('$filename', '$filepath', )";

										if ($stmtt->execute()) {
											// echo "<div class='nNote nSuccess'><p>Success! File Saved.</p></div>";

										} else {
											echo "<div class='nNote nFailure'><p> ".$file_array[$i]['name']." - Failed to save in database. </p></div>";
										}

										$sqlfe = "SELECT * from attachments ORDER BY aid DESC";

										if ($re=mysqli_query($con,$sqlfe))
										{

											while ($row=mysqli_fetch_row($re))
											{
												$strattach = $strattach.$row[0].",";
												break;
											}
											mysqli_free_result($re);
										}


									}


									$checkError = false;
								}


							}


							


						}


						$created_date = date("Y-m-d H:i:s");
						
						$stmt = $mysqli->prepare("INSERT INTO tab_resources (level, subject, course, module, module_title, lesson, lesson_title, main_idea, vocabulary, key_concept, attachments, created_date)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$stmt->bind_Param("ssssssssssss", $level,$subject,$course,$module,$moduletitle,$lesson,$lessontitle,$mainidea,$vocabulary,$keyconcept,$strattach,$created_date);
						

						if($stmt->execute()) {
							
							echo "<div class='nNote nSuccess'><p> Success! Resource Submitted. </p></div>";
						} else {
							echo "<div class='nNote nFailure'><p> Failed! Resource Submission. </p></div>";
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



			function IsFileUploaded($field_name)
			{
				if(count($_FILES) > 0)
				{
					if(empty($_FILES[$field_name]['name']))
					{
						return false;
					}
					if(!is_uploaded_file($_FILES[$field_name]['tmp_name']))
					{
						return false;
					}
					return true;
				}
				else
				{
					return false;
				}
			}

			?>


			<form action="" method="POST" class="main" enctype="multipart/form-data" name="resource_form" onsubmit="return checkDD();">
				<fieldset>
					<div class="widget fluid">
						<div class="whead"><h6>Create Resource Form</h6><div class="clear"></div></div>

						<div class="formRow">
							<div class="grid3"><label>Level</label></div>
							<div class="grid9 noSearch">
								<select name="level" class="select" style="width: 100% !important;">
									<option value="none">none</option>
									<option value="kindergarten">Kindergarten</option>
									<option value="primary">Primary</option>
									<option value="secondary">Secondary</option>
									<option value="higher">Higher</option>
								</select>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Subject</label></div>
							<div class="grid9 noSearch">
								<select name="subject" class="select" style="width: 100% !important;">
									<option value="none">none</option>
									<option value="english">English</option>
									<option value="science">Science</option>
									<option value="mathematics">Mathematics</option>
									<option value="social studies">Social Studies</option>
									<option value="ICT">ICT</option>
									<option value="health/PE">Health/PE</option>
									<option value="art">Art</option>
									<option value="other">Other</option>

								</select>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Course</label></div>
							<div class="grid9"><input type="text" name="course" required /></div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Module</label></div>
							<div class="grid9"><input type="text" name="module" required /></div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Module Title</label></div>
							<div class="grid9"><input type="text" name="moduletitle" required /></div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Lesson</label></div>
							<div class="grid9"><input type="text" name="lesson" required /></div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Lesson Title</label></div>
							<div class="grid9"><input type="text" name="lessontitle" required /></div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Main Idea</label></div>
							<div class="grid9"><textarea rows="4" cols="" name="mainidea" required ></textarea> <p style="color:red;"> use '&lt;br&gt;' tag to break line</p> </div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Vocabulary</label></div>
							<div class="grid9"><input type="text" name="vocabulary" required /></div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<div class="grid3"><label>Key Concept</label></div>
							<div class="grid9"><input type="text" name="keyconcept" required /></div>
							<div class="clear"></div>
						</div>

						<div class="formRow" style="border: 0px !important;">
							<div class="grid3"><label>Attachments</label></div>
							<div class="grid9" >

								<input type="file" name="userfile[]" multiple style="" />


							</div>

							<div class="clear"></div>
						</div>

						


						<div class="formRow" style="border: 0px !important;margin-top: -20px;">
							<div class="grid3"><label></label></div>
							<div class="grid9"><input type="submit" name="submit" value="Submit" class="buttonL bGreen" style="width: 200px;float:;height:40px;" /></div>
							<div class="clear"></div>
						</div>

					</div>
				</fieldset>
			</form>


			<script type="text/javascript">
				
				function checkDD() {
					var level = document.forms["resource_form"]["level"]; 
					var subject = document.forms["resource_form"]["subject"];

					if (level.value == "none")                                  
					{ 
						window.alert("Please select the Level."); 
						level.focus(); 
						return false; 
					} else if (subject.value == "none") { 
						window.alert("Please select the Subject."); 
						subject.focus(); 
						return false; 
					} else {
						return true;
					}
					

				}


			</script>


		</div>
		<!-- Main content ends -->

	</div>
	<!-- Content ends -->

</body>
</html>

<?php
include_once('connect.php');
session_start();

if ( !( isset( $_SESSION['username'] ) ) ) {
	header("Location: login.php");
} else if($_SESSION['type'] == 0) {
    header("Location: index.php");
}

include('class.pdf2text.php');

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

$msg ="";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {

        $numfile = count(array_filter($_FILES['usernew']['name']));

        if( $numfile == 0 ) {

            $ureid = $_POST['resourceid'];
            $ulevel = $_POST['level'];
            $usubject = $_POST['subject'];
            $ucourse = $_POST['course'];
            $umodule = $_POST['module'];
            $umoduletitle = $_POST['moduletitle'];
            $ulesson = $_POST['lesson'];
            $ulessontitle = $_POST['lessontitle'];
            $umainidea = $_POST['mainidea'];
            $uvocabulary = $_POST['vocabulary'];
            $ukeyconcept = $_POST['keyconcept'];

            $strattach = "";

            if(isset($_POST['usersaved'])) {
                $usersaved = $_POST['usersaved'];
                for ($i=0; $i < sizeof($usersaved) ; $i++) { 
                    $strattach = $strattach.$usersaved[$i].",";
                }
                
            }




            $stmt = $mysqli->prepare("UPDATE tab_resources SET level=?, subject=?, course=?, module=?, module_title=?, lesson=?, lesson_title=?, main_idea=?, vocabulary=?, key_concept=?, attachments=?  WHERE id=? ");
            $stmt->bind_Param("sssssssssssi", $ulevel,$usubject,$ucourse,$umodule,$umoduletitle,$ulesson,$ulessontitle,$umainidea,$uvocabulary,$ukeyconcept,$strattach,$ureid);


            if($stmt->execute()) {
                $msg = $msg."<div class='nNote nSuccess'><p>Success! Resource updated.</p></div>";

                if(isset($_POST['delatt'])) {
                    $delatt = $_POST['delatt'];
                    for($i=0; $i<sizeof($delatt); $i++) {

                       $did = $delatt[$i];

                       $sq = "DELETE FROM attachments WHERE aid='$did' ";

                        if (mysqli_query($con, $sq)) {
                          
                        } else { }

                  }

              }


          } else {
            $msg = $msg."<div class='nNote nFailure'><p>Error! Resource failed to updated.</p></div>";
        }



    } else if($numfile > 0) {

        $ureid = $_POST['resourceid'];
        $ulevel = $_POST['level'];
        $usubject = $_POST['subject'];
        $ucourse = $_POST['course'];
        $umodule = $_POST['module'];
        $umoduletitle = $_POST['moduletitle'];
        $ulesson = $_POST['lesson'];
        $ulessontitle = $_POST['lessontitle'];
        $umainidea = $_POST['mainidea'];
        $uvocabulary = $_POST['vocabulary'];
        $ukeyconcept = $_POST['keyconcept'];

        $strattach = "";

        if(isset($_POST['usersaved'])) {
            $usersaved = $_POST['usersaved'];
            for ($i=0; $i < sizeof($usersaved) ; $i++) { 
                $strattach = $strattach.$usersaved[$i].",";
            }

        }

        $checkError = false;

        $file_array = reArrayFiles($_FILES['usernew']);
            // pre_r($file_array);

        for ($i=0; $i <count($file_array) ; $i++) { 



            if($file_array[$i]['error']) {

                $msg = $msg."<div class='nNote nFailure'><p> ".$file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']]." </p></div>";

                $msg = $msg."<div class='nNote nFailure'><p> FAILED! Resource Submission.  </p></div>";

                $checkError = true;
                break;

            } 
            else {
                $extensions = array('pdf', 'docx', 'doc', 'txt');
                $file_ext = explode('.',$file_array[$i]['name']);
                $file_ext = end($file_ext);


                if(!in_array($file_ext, $extensions)) {
                    $msg = $msg."<div class='nNote nSuccess'><p> {$file_array[$i]['name']} - Invalid File Extension! </p></div>";

                } 
                else {
                    move_uploaded_file($file_array[$i]['tmp_name'], "files/".$file_array[$i]['name']);
                    $msg = $msg."<div class='nNote nSuccess'><p> ".$file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']]." </p></div>";

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
                            $msg = $msg."<div class='nNote nFailure'><p> ".$file_array[$i]['name']." - Failed to save in database. </p></div>";
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




        $stmt = $mysqli->prepare("UPDATE tab_resources SET level=?, subject=?, course=?, module=?, module_title=?, lesson=?, lesson_title=?, main_idea=?, vocabulary=?, key_concept=?, attachments=?  WHERE id=? ");
        $stmt->bind_Param("sssssssssssi", $ulevel,$usubject,$ucourse,$umodule,$umoduletitle,$ulesson,$ulessontitle,$umainidea,$uvocabulary,$ukeyconcept,$strattach,$ureid);


        if($stmt->execute()) {
            $msg = $msg."<div class='nNote nSuccess'><p>Success! Resource updated.</p></div>";
        } else {
            $msg = $msg."<div class='nNote nFailure'><p>Error! Resource failed to updated.</p></div>";
        }




    }


        // $ureid = $_POST['resourceid'];
        // $ulevel = $_POST['level'];
        // $usubject = $_POST['subject'];
        // $ucourse = $_POST['course'];
        // $umodule = $_POST['module'];
        // $umoduletitle = $_POST['moduletitle'];
        // $ulesson = $_POST['lesson'];
        // $ulessontitle = $_POST['lessontitle'];
        // $umainidea = $_POST['mainidea'];
        // $uvocabulary = $_POST['vocabulary'];
        // $ukeyconcept = $_POST['keyconcept'];

    /*NEW*/
        // $stmt = $mysqli->prepare("UPDATE tab_resources SET level=?, subject=?, course=?, module=?, module_title=?, lesson=?, lesson_title=?, main_idea=?, vocabulary=?, key_concept=?  WHERE id=? ");
        // $stmt->bind_Param("ssssssssssi", $ulevel,$usubject,$ucourse,$umodule,$umoduletitle,$ulesson,$ulessontitle,$umainidea,$uvocabulary,$ukeyconcept,$ureid);


        // if($stmt->execute()) {
        //     $msg = "<div class='nNote nSuccess'><p>Success! Resource updated.</p></div>";
        // } else {
        //     $msg = "<div class='nNote nFailure'><p>Error! Resource failed to updated.</p></div>";
        // }

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








if(isset($_GET['rid'])) {
    $rid = $_GET['rid'];
    $level = "";
    $subject = "";
    $course = "";
    $module = "";
    $moduletitle = "";
    $lesson = "";
    $lessontitle = "";
    $mainidea = "";
    $vocabulary = "";
    $keyconcept = "";
    $attach = "";

    $sql="SELECT * FROM tab_resources where id='$rid' ";

    if($result=mysqli_query($con,$sql)) {
        $row=mysqli_fetch_assoc($result);

        $level = $row['level'];
        $subject = $row['subject'];
        $course = $row['course'];
        $module = $row['module'];
        $moduletitle = $row['module_title'];
        $lesson = $row['lesson'];
        $lessontitle = $row['lesson_title'];
        $mainidea = $row['main_idea'];
        $vocabulary = $row['vocabulary'];
        $keyconcept = $row['key_concept'];
        $attach = $row['attachments'];
        $created = $row['created_date'];

    }


}
else {
    header("Location: search.php");
}







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
                        <li><a href="create-resource.php" title=""><span class="icon-arrow-right-6"></span>Create Resource</a></li>
                        <li><a href="search.php" title=""><span class="icon-arrow-right-6"></span>View Resources</a></li>
                        <li><a href="viewusers.php" title=""><span class="icon-arrow-right-6"></span>View Users</a></li>
                        <li><a href="adduser.php" title="" ><span class="icon-arrow-right-6"></span>Add New User</a></li>
                        <?php } else if($_SESSION['type'] == '0') { ?>
                        <li><a href="index.php" title=""><span class="icon-arrow-right-6"></span>Home</a></li>
                        <li><a href="create-resource.php" title=""><span class="icon-arrow-right-6"></span>Create Resource</a></li>
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
                            <li><a href="create-resource.php" title=""><span class="icon-arrow-right-6"></span>Create Resource</a></li>
                            <li><a href="search.php" title=""><span class="icon-arrow-right-6"></span>View Resources</a></li>
                            <li><a href="viewusers.php" title=""><span class="icon-arrow-right-6"></span>View Users</a></li>
                            <li><a href="adduser.php" title="" ><span class="icon-arrow-right-6"></span>Add New User</a></li>
                            <?php } else if($_SESSION['type'] == '0') { ?>
                            <li><a href="index.php" title="" ><span class="icon-arrow-right-6"></span>Home</a></li>
                            <li><a href="create-resource.php" title=""><span class="icon-arrow-right-6"></span>Create Resource</a></li>
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
            <span class="pageTitle"><span class="icon-screen"></span>Edit Resource</span>

            <div class="clear"></div>
        </div>

        <!-- Breadcrumbs line -->
        <div class="breadLine">
            <div class="bc">
                <ul id="breadcrumbs" class="breadcrumbs">
                    <li><a href="index.php">Dashboard</a></li>

                </ul>
            </div>

            <div class="breadLinks">

               <div class="clear"></div>
           </div>
       </div>

       <!-- Main content -->
       <div class="wrapper">

        <?php
        echo $msg;
        ?>

        <form action="" method="POST" class="main" enctype="multipart/form-data" name="resource_form" id="resource_form" onsubmit="return checkDD();">
            <fieldset>
                <div class="widget fluid">
                    <div class="whead"><h6>Resource ID # <?php echo $rid; ?></h6><div class="clear"></div></div>

                    
                    <input type="hidden" name="resourceid" value="<?php echo $rid; ?>">

                    <div class="formRow">
                        <div class="grid3"><label>Level</label></div>
                        <div class="grid9">

                            <select name="level" class="select" id="level" style="width: 100% !important;height: 30px;border-color: #cdcdcd;color:#858585;">
                                <option value="none">none</option>
                                <option value="kindergarten" >Kindergarten</option>
                                <option value="primary" >Primary</option>
                                <option value="secondary" >Secondary</option>
                                <option value="higher" >Higher</option>
                            </select>

                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Subject</label></div>
                        <div class="grid9 noSearch">
                            <select name="subject" class="select" id="subject" style="width: 100% !important;height: 30px;border-color: #cdcdcd;color:#858585;">

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
                        <div class="grid9">
                            <input type="text" name="course" value="<?php echo $course; ?>" required />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Module</label></div>
                        <div class="grid9">
                            <input type="text" name="module" value="<?php echo $module; ?>" required />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Module Title</label></div>
                        <div class="grid9">
                            <input type="text" name="moduletitle" value="<?php echo $moduletitle; ?>" required />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Lesson</label></div>
                        <div class="grid9">
                            <input type="text" name="lesson" value="<?php echo $lesson; ?>" required />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Lesson Title</label></div>
                        <div class="grid9">
                            <input type="text" name="lessontitle" value="<?php echo $lessontitle; ?>" required />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Main Idea</label></div>
                        <div class="grid9">
                            <textarea rows="4" cols="" name="mainidea" required ><?php echo $mainidea; ?></textarea>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Vocabulary</label></div>
                        <div class="grid9">
                            <input type="text" name="vocabulary" value="<?php echo $vocabulary; ?>" required />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow">
                        <div class="grid3"><label>Key Concept</label></div>
                        <div class="grid9">
                            <input type="text" name="keyconcept" value="<?php echo $keyconcept; ?>" required />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="formRow" >
                        <div class="grid3"><label>Attachments</label></div>
                        <div class="grid9" >



                            <?php

                            $stratt = substr($attach, 0, -1);
                            $attarr =  explode(',',$stratt);

                            foreach ($attarr as $att) {

                                $sa="SELECT * FROM attachments where aid='$att' ";

                                if($re=mysqli_query($con,$sa)) {

                                    if($rw=mysqli_fetch_assoc($re)) {

                                    //Un Comment Below to make it downloadable
                                    // echo "<a href='files/".$rw['filename']."' download>".$rw['filename']."</a>";

                                    // echo "-".$rw['filename'];
                                        echo "<span> <input type='hidden' name='usersaved[]' value='".$rw['aid']."' > ".$rw['filename']." &nbsp;&nbsp;&nbsp;  <span class='iconb rvmatt' data-icon='&#xe136;' style='color:red;'></span> </span>";
                                    }
                                    else {
                                        echo "*no attachments*";
                                    }

                                }

                                echo "<br>";
                            }


                            ?>



                        </div>

                        
                        <div class="clear"></div>
                    </div>


                    <div class="formRow" style="border: 0px !important;">
                        <div class="grid3"><label>Add Attachments</label></div>
                        <div class="grid9">
                            <input type="file" name="usernew[]" multiple  />
                        </div>
                        <div class="clear"></div>
                    </div>
                    

                    <div class="formRow" style="border: 0px !important;margin-top: -20px;">
                        <div class="grid3"><label></label></div>
                        
                        <div class="grid4">
                            <input type="submit" name="submit" value="Update" class="buttonL bGreen" style="width: 200px;float:;height:40px;" />
                        </div>


                        <div class="clear"></div>
                    </div>



                </div>
            </fieldset>
        </form>


    </div>
    <!-- Main content ends -->

</div>
<!-- Content ends -->

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


    var lid = document.getElementById('level');
    var ltxt = "<?php echo $level; ?>";

    for (var i = 0; i < lid.options.length; i++) {

        if (lid.options[i].value === ltxt) {
            lid.options[i].selected = true;

            break;
        }

    }


    var sid = document.getElementById('subject');
    var stxt = "<?php echo $subject; ?>";

    for (var i = 0; i < sid.options.length; i++) {

        if (sid.options[i].value === stxt) {
            sid.options[i].selected = true;

            break;
        }

    }


    $(document).on("click", ".rvmatt", function() {

        ipt = jQuery('<input type="hidden" name="delatt[]">');
        ipt.val( $(this).parent().children(0).val() );
        jQuery('#resource_form').append(ipt);
        $(this).parent().remove(); 
    });

    // function testDD() {
    //     var eid = document.getElementById('level');
    //     var etxt = "<?php echo $level; ?>";

    //     for (var i = 0; i < eid.options.length; i++) {

    //         if (eid.options[i].value === etxt) {
    //             eid.options[i].selected = true;

    //             break;
    //         }

    //     }

    // }





</script>


</body>
</html>

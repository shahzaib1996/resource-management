<?php
include_once('connect.php');
session_start();

if ( !( isset( $_SESSION['username'] ) ) ) {
	header("Location: login.php");
} 

$msg ="";
$checkDel = "0";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete'])) {

        $delid = $_POST['delid'];
        $delatt = $_POST['delatt'];

        

        $sq = "DELETE FROM tab_resources WHERE id='$delid' ";

        // mysqli_query($con, $sq)

        if ( mysqli_query($con, $sq) ) {    
          $msg = "<div class='nNote nSuccess'><p>Success! Resource Deleted.</p></div>";
          $checkDel = "1";

          $stratt = substr($delatt, 0, -1);
          $attarr =  explode(',',$stratt);

          foreach ($attarr as $att) {

            $sa="DELETE FROM attachments where aid='$att' ";

            if(mysqli_query($con,$sa)) {

                // echo "DELETED".$att;
                echo "1";

            } else {
                echo "0";
                // echo "FAILED DELETED".$att;

            }

            
        }




    } 
    else {
      $msg = "<div class='nNote nFailure'><p>Error! Resource failed to Delete.</p></div>";
    }

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
    header("Location: login.php");
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
                            <li><a href="adduser.php" title=""><span class="icon-arrow-right-6"></span>Add New User</a></li>
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
            <span class="pageTitle"><span class="icon-screen"></span>View Resource</span>

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

        if($checkDel == "0") {

            ?>

            <form action="" method="POST" class="main" enctype="multipart/form-data" name="resource_form" onsubmit="return confirmDelete();">
                <fieldset>
                    <div class="widget fluid">
                        <div class="whead"><h6>Resource ID # <?php echo $rid; ?></h6><div class="clear"></div></div>



                        <div class="formRow">
                            <div class="grid3"><label>Level</label></div>
                            <div class="grid9" style="text-transform: capitalize;">
                                <?php echo $level; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Subject</label></div>
                            <div class="grid9" style="text-transform: capitalize;">
                                <?php echo $subject; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Course</label></div>
                            <div class="grid9">
                                <?php echo $course; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Module</label></div>
                            <div class="grid9">
                                <?php echo $module; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Module Title</label></div>
                            <div class="grid9">
                                <?php echo $moduletitle; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Lesson</label></div>
                            <div class="grid9">
                                <?php echo $lesson; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Lesson Title</label></div>
                            <div class="grid9">
                                <?php echo $lessontitle; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Main Idea</label></div>
                            <div class="grid9">
                                <?php echo $mainidea; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Vocabulary</label></div>
                            <div class="grid9">
                                <?php echo $vocabulary; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow">
                            <div class="grid3"><label>Key Concept</label></div>
                            <div class="grid9">
                                <?php echo $keyconcept; ?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="formRow" style="border: 0px !important;">
                            <div class="grid3"><label>Attachments</label></div>
                            <div class="grid9" >



                                <?php

                                $stratt = substr($attach, 0, -1);
                                $attarr =  explode(',',$stratt);

                                foreach ($attarr as $att) {

                                    $sa="SELECT * FROM attachments where aid='$att' ";

                                    if($re=mysqli_query($con,$sa)) {

                                        $rw=mysqli_fetch_assoc($re);

                                    //Un Comment Below to make it downloadable
                                    // echo "<a href='files/".$rw['filename']."' download>".$rw['filename']."</a>";

                                        if( $rw['filename'] != "") {

                                            echo "-".$rw['filename'];

                                            echo "<a href='files/".$rw['filename']."' target='pdf-frame' class='buttonS bGreen' style='font-size:12px;padding:2px;margin-left:20px;'> View </a> ";
                                            if($_SESSION['type'] == "1" ) {
                                                echo "<a href='files/".$rw['filename']."' class='buttonS bBlue' style='font-size:12px;padding:2px;margin-left:20px;' download> Download </a>";
                                            }
                                        } else {
                                            echo "*no attachments*";
                                        }

                                    }

                                    echo "<br><br>";
                                }

                                ?>



                            </div>

                            <div class="clear"></div>
                        </div>


                        <?php if($_SESSION['type'] == "1") { ?>

                        <div class="formRow" style="border: 0px !important;margin-top: -20px;">
                            <div class="grid3"><label></label></div>

                            <div class="grid4">
                                <a href="edit-resource.php?rid=<?php echo $_GET['rid']; ?>" >
                                    <input type="button" name="submit" value="Edit" class="buttonL bGreen" style="width: 200px;height:40px;" />
                                </a>
                            </div>

                            <div class="grid4">
                                <input type="hidden" name="delid" value="<?php echo $rid; ?>" />
                                <input type="hidden" name="delatt" value="<?php echo $attach; ?>" />
                                <input type="submit" name="delete" value="Delete" class="buttonL bRed" style="width: 200px;height:40px;" />
                            </div>

                            <div class="clear"></div>
                        </div>

                        <?php } ?>

                    </div>
                </fieldset>
            </form>


            <?php } ?>


            <script type="text/javascript">

                function confirmDelete()
                {
                   return confirm("Are you sure you want to delete this?");
               }



           </script>

       </div>
       <!-- Main content ends -->

   </div>
   <!-- Content ends -->



</body>
</html>

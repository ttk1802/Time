<?php
    include 'header.php';
    include 'sidebar.php';
    include 'includes/database.php';
    include 'includes/users.php';
    
    $database = new database();
    $db = $database->connect();
    $user = new user($db);
    
    if ($_SERVER['REQUEST_METHOD']== 'POST') {

        if (isset($_POST['edit_user_profile'])) {

            if (empty($_FILES['image_profile']['name'])) {
                $image_name = $_POST['old_image_profile'];
            }else{
                $target_file = "images/avatars/";
                $image_name = $_FILES['image_profile']['name'];
                move_uploaded_file($_FILES['image_profile']['tmp_name'],$target_file.$image_name);
            }
            
            $user->n_user_id = $_POST['user_id'];
            $user->v_fullname = $_POST['name'];
            $user->v_email = $_POST['email'];
            $user->v_username = $_POST['username'];
            $user->v_password = is_null($_POST['password'])?md5(($_POST['password'])):$_POST['old_password'];
            $user->v_phone = $_POST['phone'];
            $user->v_image = $image_name;
            $user->v_message = $_POST['about'];
            $user->d_date_updated = date("Y/m/d", time());
            $user->d_time_updated = date("h:i:s", time());
            var_dump($_POST['password']);

            if ($user->update()) {
                $flag = "Update successfull!";
            }

        }
    }
    
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Bootstrap Admin Template : Dream</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <link href="summernote/summernote.min.css" rel="stylesheet" />
</head>

<body>
    <div id="wrapper">
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            User Profile
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                <?php
                    if(isset($flag)){
                        ?>
                    <div class="panel-body"> 
						<div class="alert alert-success">
							<strong><?php echo $flag ?></strong> 
						</div>
					</div>

                <?php
                    }
                ?>
                </div>
                <!-- Add Category -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            Profile Page
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <?php 
                                        $result = $user->read();
                                        $row_user = $result->fetch();
                                    
                                    ?>
                                    <div class="col-lg-9">
                                        <form role="form" method="POST" action=""  enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label> Full Name</label>
                                                <input value="<?php echo $row_user['v_fullname'] ?>" class="form-control" placeholder="Enter Full Name" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label> Email</label>
                                                <input value="<?php echo $row_user['v_email'] ?>" class="form-control" placeholder="Enter Email" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label> Username</label>
                                                <input value="<?php echo $row_user['v_username'] ?>" class="form-control" placeholder="Enter Username" name="username">
                                            </div>
                                            <div class="form-group">
                                                <label> Password</label>
                                                <input type=""  class="form-control" placeholder="Enter Password" name="password">
                                               
                                            </div>
                                            <div class="form-group">
                                                <label> Phone Number</label>
                                                <input value="<?php echo $row_user['v_phone'] ?>" class="form-control" placeholder="Enter Phone" name="phone">
                                            </div>
                                            <div class="form-group">
                                                <label> Image Profie</label>
                                                <input  type="file" name="image_profile">
                                                <input type="hidden" name="old_image_profile" value="<?php echo $row_user['v_image'] ?>" >
                                                
                                            </div>
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea id="summernote_profile" name="about" class="form-control" rows="3">
                                                <?php echo $row_user['v_message'] ?>
                                                </textarea>
                                            </div>
                                            <input value="<?php echo $row_user['n_user_id'] ?>" type="hidden" name="user_id">
                                            <button name="edit_user_profile" type="submit" class="btn btn-success">Update Profile</button>
                                            <input type="hidden" name="old_password" value="<?php echo $row_user['v_password'] ?>" >
                                        </form>
                                    </div>
                                    <!-- /col 9 -->
                                    <div class="col-lg-3">
                                        <div class="panel panel-info">
                                            <div class="panel-heading" align="center">
                                                Image Profie
                                            </div>
                                            <div class="panel-body" align="center">
                                                <?php 
                                                    if(empty($row_user['v_image']))
                                                    {
                                                ?>
                                                        <img class="img-thumbnail" src="images/avatars/x4.jpg" alt="Vinhs" width="180px">
                                                <?php 
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <img class="img-thumbnail" src="<?php echo "images/avatars/".$row_user['v_image'] ?>" alt="Vinhs" width="180px">
                                                <?php            
                                                        }
                                                ?>
                                                
                                            </div>

                                        </div>    
                                    </div>
                                </div>
                            </div>
                        <!-- /.panel -->
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                    
                </div>
                
                <!-- /. ROW  -->
				<footer><p>&copy;2022</p></footer>
        </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>

    <script src="summernote/summernote.min.js"></script>
    <script >
        $('#summernote_profile').summernote({
            placeholder: 'About Me',
            height: 100
        });
    </script>


</body>

</html>
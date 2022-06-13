<?php
include 'header.php';
include 'sidebar.php';
    include 'includes/database.php';
    include 'includes/contacts.php';
    
    $database = new database();
    $db = $database->connect();
    $contact = new contact($db);
    
    if($_SERVER['REQUEST_METHOD']=='POST') {
        if ($_POST['form_name']=='delete_contact') {
            $id = $_POST['contact_id'];
            $contact->n_contact_id = $id;
            if ($contact->delete()) {
                $flag = "Delete contact successful!";
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
                        Contact
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Contact Page 
                                <?php   ?> 
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th> ID </th>
                                                <th> Fullname </th>
                                                <th> Email</th>
                                                <th> Phone </th>
                                                <th> Message </th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $result = $contact->read();
                                                $num = $result->rowCount();
                                                if ($num>0){
                                                    while($rows = $result->fetch()){
                                                        ?>
                                            <tr>
                                                <td> <?php echo $rows['n_contact_id']?> </td>
                                                <td> <?php echo $rows['v_fullname']?></td>
                                                <td> <?php echo $rows['v_email']?> </td>
                                                <td> <?php echo $rows['v_phone']?> </td>
                                                <td> <?php echo $rows['v_message']?> </td>
                                                
                                                <td>
                                                    <button  class="btn btn-info" ><i class=" fa "></i> View</button>
                                                    
                                                    <!-- DELETE -->
                                                    <button data-toggle="modal"  value="Delete" data-target="#delete_contact<?php echo $rows['n_contact_id'] ?>"
                                                     class="btn btn-danger" ><i class="fa fa-pencil"></i> Delete</button>
                                                         
                                                    
                                                        <!-- DELETE -->
                                                    <div class="modal fade" id="delete_contact<?php echo $rows['n_contact_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form  method="POST" action="">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Delete Contact</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                     Are you sure that you want to delete this Contact?
                                                                 </div>
                                                                <div class="modal-footer">
                                                                    
                                                                    <input type="hidden" name="form_name" value="delete_contact">
                                                                    <input type="hidden" name="contact_id" value="<?php echo $rows['n_contact_id']; ?>">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button name="delete" type="submit" class="btn btn-primary">Delete</button>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End  Kitchen Sink -->
                    </div>
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
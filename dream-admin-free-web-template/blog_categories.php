<?php
    include 'header.php';
    include 'sidebar.php';
    include 'includes/database.php';
    include 'includes/categories.php';

    $database = new database();
    $db = $database->connect();
    $category = new category($db);
    
    if($_SERVER['REQUEST_METHOD']=='POST') {
        if($_POST['form_name']=='edit_category') {
            $title = $_POST['category_title'];
            $meta_title = $_POST['category_meta_title'];
            $path = $_POST['category_path'];
            $id = $_POST['category_id'];

            $category->n_category_id = $id;
            $category->v_category_title = $title;
            $category->v_category_meta_title = $meta_title;
            $category->v_category_path = $path;
            $category->d_date_created = date("Y/m/d", time());
            $category->d_time_created = date("h:i:s a", time());
            if($category->update()){
                $flag = "Edit category successful!";
            }
            
        }
        if($_POST['form_name']=='add_category') {
            $title = $_POST['category_name'];
            $meta_title = $_POST['category_meta_title'];
            $path = $_POST['category_path'];
            
            $category->v_category_title = $title;
            $category->v_category_meta_title = $meta_title;
            $category->v_category_path = $path;
            $category->d_date_created = date("Y/m/d", time());
            $category->d_time_created = date("h:i:s a", time());
            if($category->create()){
                $flag = "Create category successful!";
            }
            
        }
        if ($_POST['form_name']=='delete_category') {
            $id = $_POST['category_id'];
            $category->n_category_id = $id;
            if ($category->delete()) {
                $flag = "Delete category successful!";
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
</head>

<body>
    <div id="wrapper">
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Blog Categories
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
                                All Categories
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="">
                                            <div class="form-group">
                                                <label>Category Title</label>
                                                <input class="form-control" placeholder="Enter Category Title" name="category_name">
                                            </div>
                                            <div class="form-group">
                                                <label>Category Meta Title</label>
                                                <input class="form-control" placeholder="Enter Category Meta Title" name="category_meta_title">
                                            </div>
                                            <div class="form-group">
                                                <label>Category Path</label>
                                                <input class="form-control" placeholder="Enter Category Path" name="category_path">
                                            </div>
                                            <input type="hidden" name="form_name" value="add_category">
                                            <button type="submit" class="btn btn-success">Add Category</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <!-- /.panel -->
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /Add Category -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                All Categories  
                                <?php   ?> 
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th> ID </th>
                                                <th> Name </th>
                                                <th> Meta Title </th>
                                                <th> Category Path </th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $result = $category->read();
                                                $num = $result->rowCount();
                                                if ($num>0){
                                                    while($rows = $result->fetch()){
                                                        ?>
                                            <tr>
                                                <td> <?php echo $rows['n_category_id'] ?> </td>
                                                <td> <?php echo $rows['v_category_title']?></td>
                                                <td> <?php echo $rows['v_category_meta_title']?> </td>
                                                <td> <?php echo $rows['v_category_path']?> </td>
                                                <td>
                                                    <button  class="btn btn-info"><i class=" fa "></i> View</button>
											            <!-- EDIT -->
                                                    <button data-toggle="modal"
                                                    data-target="#edit_category<?php echo $rows['n_category_id'] ?>" 
                                                    class="btn btn-primary" ><i class="fa fa-edit "></i> Edit</button>
                                                    <!-- DELETE -->
                                                    <button data-toggle="modal"  data-target="#delete_category<?php echo $rows['n_category_id'] ?>"
                                                     class="btn btn-danger" ><i class="fa fa-pencil"></i> Delete
                                                    </button>
                                                            <!-- EDIT -->
                                                    <div class="modal fade" id="edit_category<?php echo $rows['n_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
                                                                </div>
                                                                <form role="form" method="POST" action=" " name= "frm_edit">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Category Title</label>
                                                                        <input class="form-control" placeholder="Enter Category Title" name="category_title"
                                                                        value="<?php echo $rows['v_category_title']?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Category Meta Title</label>
                                                                        <input class="form-control" placeholder="Enter Category Meta Title" name="category_meta_title"
                                                                        value="<?php echo $rows['v_category_meta_title']?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Category Path</label>
                                                                        <input class="form-control" placeholder="Enter Category Path" name="category_path"
                                                                        value="<?php echo $rows['v_category_path']?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="form_name" value="edit_category">
                                                                        <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']?>">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    
                                                        <!-- DELETE -->
                                                    <div class="modal fade" id="delete_category<?php echo $rows['n_category_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form  method="POST" action="">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                     Are you sure that you want to delete this category?
                                                                 </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="form_name" value="delete_category">
                                                                    <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']; ?>">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Delete</button>
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


</body>

</html>
<?php 
include_once "../includes/connection.php";
include_once "../includes/functions.php";
session_start();
if(!isset($_GET['id'])){
	header("Location: page.php?message=Please+click+the+edit+button");
	exit();
}else{
	if(!isset($_SESSION['author_role'])){
		header("Location: login.php?message=Please+Login");
		exit();
	}else{
		if($_SESSION['author_role']!="admin"){
			echo "You cannot access this page";
		}else{
			$page_id = $_GET['id'];
			$sql = "SELECT * FROM page WHERE page_id='$page_id'";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result)<=0){
				//We dont have any page for this id
				header("Location: page.php?message=No+page+found");
				exit();
			}else{
				?>
			
			
			
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin Panel</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../style/bootstrap.min.css">
		<link rel="stylesheet" href="../style.css">
	</head>
	<body>
	
	 <nav class="navbar navbar-dark sticky-top bg-dark   shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
      
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="logout.php">Sign out</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <?php include_once "nav.inc.php"; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Page</h1>
            <h6>Howdy <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
          </div>
		
			<div id="admin-index-form">
			<?php
			if(isset($_GET['message'])){
				$msg = $_GET['message'];
				echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				'.$msg.'
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>';
			}
			?>
			<?php
				$post_id = $_GET['id'];
				$FormSql = "SELECT * FROM page WHERE page_id='$page_id'";
				$FormResult = mysqli_query($conn, $FormSql);
				while($FormRow=mysqli_fetch_assoc($FormResult)){
					
					$pageTitle = $FormRow['page_title'];
					$pageContent = $FormRow['page_content'];
				
			?>
				<form method="post" enctype="multipart/form-data">
					Page Title
					 <input type="text" name="page_title" class="form-control" placeholder="Post Title" value="<?php echo $pageTitle; ?>"><br>
					 
					
					
					Page Content
					<textarea name="page_content" class="form-control" id="exampleFormControlTextarea1" rows="9"><?php echo $pageContent ?></textarea><br>
					
					 
					 <button name="submit" type="submit" class="btn btn-primary">Update</button>
				</form>
				<?php } ?>
				<?php
					if(isset($_POST['submit'])){
						$page_title = mysqli_real_escape_string($conn, $_POST['page_title']);
						$page_content = mysqli_real_escape_string($conn, $_POST['page_content']);
					
						
						//checking if above fields are empty
						if(empty($page_title) OR empty($page_content)){
							echo '<script>window.location = "page.php?message=Empty+Fields";</script>';
							exit();
						}
						
						
							
							$sql = "UPDATE page SET page_title='$page_title', page_content='$page_content' WHERE page_id='$page_id'";
							if(mysqli_query($conn, $sql)){
								echo '<script>window.location = "page.php?message=Page+Updated";</script>';
							}else{
								echo '<script>window.location = "page.php?message=Error";</script>';
							}
						}
						
						
					
							
				?>
				
			</div>
        
          </div>
        </main>
      </div>
    </div>
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ey5ln3e6qq2sq6u5ka28g3yxtbiyj11zs8l6qyfegao3c0su"></script>

	<script>tinymce.init({ selector:'textarea' });</script>
	</body>
</html>
			
			
			
				<?php
			}
		}
	}
}
?>
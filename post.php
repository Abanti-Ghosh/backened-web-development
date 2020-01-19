<?php
include_once "includes/connection.php";
include_once "includes/functions.php";
if(!isset($_GET['id'])){
	header("Location: index.php?geterr");
}else{
	$id = mysqli_real_escape_string($conn, $_GET['id']);
	if(!is_numeric($id)){
		header("Location: index.php?numerror");
		exit();
	}else if(is_numeric($id)){
		$sql = "SELECT * FROM post WHERE post_id='$id'";
		$result = mysqli_query($conn, $sql);
		//Check if posts exits
		if(mysqli_num_rows($result)<=0){
			//no posts
			header("Location: index.php?noresult");
		}else if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_assoc($result)){
				$post_title = $row['post_title'];
				$post_content = $row['post_content'];
				$post_date = $row['post_date'];
				$post_image = $row['post_image'];
				$post_keywords = $row['post_keywords'];
				$post_author = $row['post_author'];
				$post_category = $row['post_category'];
				?>
				
				
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $post_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="style/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
	
		<!--NAVIGATION BAR HERE-->
		<?php include_once "includes/nav.php"; ?>
		<!--NAVIGATION BAR ENDS HERE-->
		
		
		
		<div class="container">
			<img style="width:100%;" src="<?php echo $post_image; ?>">
			<h1><?php echo $post_title; ?></h1>
			<hr>
			<h6>Posted On: <?php echo $post_date; ?> | By: <?php getAuthorName($post_author); ?></h6>
			<h4>Category: <a href="category.php?id=<?php echo $post_category; ?>"><?php getCategoryName($post_category); ?></a></h4>
			<!--here i cahanged <p>-->
			<p><?php echo $post_content; ?></p>
			
		</div>
		
	
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scroll.js"></script>
	</body>
</html>
				
				
				<?php
			}
		}
	}
}
?>
<?php 
include_once "../includes/connection.php";
include_once "../includes/functions.php";
session_start();
if(!isset($_GET['id'])){
	header("Location: page.php?message=Please+click+the+Delete+button");
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
				$page_id = $_GET['id'];
				$sql = "DELETE FROM `page` WHERE `page_id`='$page_id'";
				if(mysqli_query($conn, $sql)){
					header("Location: page.php?message=Page+Deleted");
					exit();
				}else{
					header("Location: page.php?message=Could+not+delete+your+page");
					exit();
				}
			}
		}
	}
}
?>
<?php
include_once "../includes/connection.php";
session_start();
if(!isset($_POST['submit'])){
	header("Location: page.php?message=Please+Submit+form");
	exit();
}else{
	if(!isset($_SESSION['author_role'])){
		header("Location: login.php");
	}else{
		if($_SESSION['author_role']!="admin"){
			echo "You can't access this page";
			exit();
		}else if($_SESSION['author_role']=="admin"){
			
			$page_title = $_POST['page_title'];
			$page_content = $_POST['page_content'];
			
			$sql = "INSERT INTO page (`page_title`, `page_content`) VALUES ('$page_title', '$page_content');";
			if(mysqli_query($conn, $sql)){
				header("Location: page.php?message=Added");
				exit();
			}else{
				header("Location: page.php?message=Error");
				exit();
			}
		}
	}
}
?>
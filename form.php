<?php
ob_start();
session_start();
require 'includes/connection.php';
require 'function.php';

if (isset($_GET['id'])) {
	$id = (int)$_GET['id'];
	if ($id <= 0) {
		redirect("/crud/");
	}
}

$action = 'Add';
$button = "<input type='submit' class='btn btn-success' name='submit' value='Add'>";
$data_emp = [];
$id_field = '';
if (isset($id)) {
	$action = 'Edit';
	$button = "<input type='submit' class='btn btn-primary' name='submit' value='Update'>";

	$query = "SELECT * FROM employee WHERE id={$id}";
	
	$result_edit_emp = $conn->query($query);
	
	if ($conn->affected_rows == 0) {
		redirect("/crud/");
	}
	if (isset($result_edit_emp) && $result_edit_emp->num_rows > 0) {
		$data_emp = $result_edit_emp->fetch_assoc();
	}

	$id_field = "<input type='hidden' name='id' value='{$id}'>";
}

$designation_arr = ['employee', 'manager'];

if (!empty($_SESSION['error_data'])) {
	$data_emp = $_SESSION['error_data'];
	unset($_SESSION['error_data']);
}

if (!empty($_SESSION['error_message'])) {
	$error_message = $_SESSION['error_message'];
	unset($_SESSION['error_message']);
}
require 'html/form.html.php';
?>
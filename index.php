<?php
ob_start();
session_start();
require 'includes/connection.php';
require 'function.php';

if (isset($_GET['delete'])) {	
	delete_employee($_GET['delete']);
	redirect("/crud");
}

// Start Pagination
// Find total emp
$result_total_emp = $conn->query("SELECT COUNT(*) as total_employee FROM employee");
$row = $result_total_emp->fetch_assoc();
$total_emp = $row['total_employee'];

$emp_per_page = 5;
$total_page = ceil($total_emp / $emp_per_page);

// for default 1st page
if (!isset($_GET['page'])) {
	$_GET['page'] = 1;
}

// Validate input
$_GET['page'] = (int) $_GET['page'];
if ($_GET['page'] <= 0 || $_GET['page'] > $total_page) {
	redirect("/crud");
}

if ($_GET['page'] == 1) {
	$offset = 0;
} else {
	$offset = ($_GET['page'] - 1) * $emp_per_page;
}

$query = "SELECT * 
FROM employee
ORDER BY id DESC
LIMIT $emp_per_page OFFSET $offset";
$result_get_emp = $conn->query($query);

$emp_count_in_a_page = 0;
$data_emp = [];
if (isset($result_get_emp) && $result_get_emp->num_rows > 0) {
	$emp_count_in_a_page = $result_get_emp->num_rows;
	while ($row = $result_get_emp->fetch_assoc()) {
		$data_emp[] = $row;
	}
}
require 'html/index.html.php';

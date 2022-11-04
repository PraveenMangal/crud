<?php
ob_start();
session_start();
require 'connection.php';
require "../function.php";

if (isset($_POST['submit'])) {
	
	$data['id'] = (isset($_POST['id'])) ? validate_id($_POST['id']) : null ;
	
	$data['first_name'] = (required($_POST['first_name'], 'first_name') ) ? (escape($_POST['first_name'])) : null;

	$data['last_name'] = (required($_POST['last_name'], 'last_name') ) ? (escape($_POST['last_name'])) : null;

	$data['email'] = (required($_POST['email'], 'email') && validate_email($_POST['email']) && !email_exists($_POST['email'], $data['id']) ) ? (escape($_POST['email'])) : null;

	$data['mobile'] = (required($_POST['mobile'], 'mobile') && validate_mobile($_POST['mobile'])) ? (escape($_POST['mobile'])) : null;

	$data['designation'] = (required($_POST['designation'], 'designation') ) ? (escape($_POST['designation'])) : null;

	$data['date_of_joining'] = (required($_POST['date_of_joining'], 'date_of_joining') && validate_date($_POST['date_of_joining'])) ? (escape($_POST['date_of_joining'])) : null;

	$data['salary_per_month'] = (required($_POST['salary_per_month'], 'salary_per_month') && validate_number($_POST['salary_per_month'])) ? (escape($_POST['salary_per_month'])) : null;


	if (!empty(validation_error())) {
		$_SESSION['failure'] = "Wrong Data";
		$_SESSION['error_message'] = validation_error();
		$_SESSION['error_data'] = $_POST;

		if ($_POST['submit'] == 'Add') {
			redirect('/crud/form.php');
		} else {
			redirect("/crud/form.php?id={$id}");
		}
	}
		
	add_update_employee($data);
	redirect("/crud");
}

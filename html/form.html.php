<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Employee Form</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
	<div class="container">

		<div class="row">
			<div class="col-xs-6">
				<a href="/crud/" class="btn btn-warning">Go Back</a>
			</div>

			<div class="col-xs-6">
				<h2><?= $action ?> Employee</h2>
			</div>
		</div>
		
		<?= printMessageIfExist(); ?>

		<form action="includes/action.php" method="post">

			<div class="form-group">
				<label>First Name</label>
				<input type="text" class="form-control" name="first_name" value="<?= $data_emp['first_name']??'' ?>" required>
				<span class="text-danger"><?= $error_message['first_name']??'' ?></span>
			</div>

			<div class="form-group">
				<label>Last Name</label>
				<input type="text" class="form-control" name="last_name" value="<?= $data_emp['last_name']??'' ?>" required>
				<span class="text-danger"><?= $error_message['last_name']??'' ?></span>
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="email" value="<?= $data_emp['email']??'' ?>" required>
				<span class="text-danger"><?= $error_message['email']??'' ?></span>
			</div>

			<div class="form-group">
				<label>Mobile</label>
				<input type="number" class="form-control" name="mobile" value="<?= $data_emp['mobile']??'' ?>" required>
				<span class="text-danger"><?= $error_message['mobile']??'' ?></span>
			</div>

			<div class="form-group">
				<label>Designation</label>
				<select class="form-control" name="designation" required>
					<option value="">--Select Designation--</option>

					<?php foreach ($designation_arr as $designation) : ?>
						<?php $selected = (!empty($data_emp['designation']) && $designation == $data_emp['designation']) ? "Selected" : ''; ?>

						<option value="<?= $designation ?>" <?= $selected ?>><?=
																																	ucfirst($designation)
																																	?></option>

					<?php endforeach; ?>
				</select>
				<span class="text-danger"><?= $error_message['designation']??'' ?></span>
			</div>

			<div class="form-group">
				<label>Date of Joining</label>
				<input type="date" class="form-control" name="date_of_joining" value="<?= $data_emp['date_of_joining']??'' ?>" required>
				<span class="text-danger"><?= $error_message['date_of_joining']??'' ?></span>
			</div>

			<div class="form-group">
				<label>Salary Per Month</label>
				<input type="number" class="form-control" name="salary_per_month" value="<?= $data_emp['salary_per_month']??'' ?>" required>
				<span class="text-danger"><?= $error_message['salary_per_month']??'' ?></span>
			</div>

			<div class="form-group">
				<?= $id_field ?>
				<?= $button ?>
			</div>

		</form>

	</div>
</body>

</html>
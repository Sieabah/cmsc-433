<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Computer Science Class List</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="/style.css">

		<script type="text/javascript" src="/classDictionary.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<a href="/">
						<img src="/img/umbclogo.png" />
					</a>
				</div>
			</div>
			<div class="row">
				<h1>Computer Science Undergraduate Course Advising</h1>
				<form action="/formProcess" id="classlist" method="POST">
					<h3>Please fill out your student information</h3>
					<div id="userinfo">
						<div class="col-xs-12 col-sm-6">
							<label for="name">Name: </label>
							<input class="form-control" type="text" name="name" id="name" required>

							<label for="email">Best Email: </label>
							<input class="form-control" type="email" name="email" id="email" required>
						</div>
						<div class="col-xs-12 col-sm-6">
							<label for="contactnum">Best Contact Number: </label>
							<input class="form-control" type="text" name="contactnum" id="connectnum" required pattern="\d{10}" title="Enter as 10 digit phone number.  No special characters">

							<label for="campusid">Best Campus ID: </label>
							<input class="form-control" type="text" name="campusid" id="campusid" required pattern="[a-zA-Z][a-zA-Z]\d{5}" title="Enter as format EX: AA12345">
						</div>
					</div>

					<h3>Then proceed by selecting which classes you have taken.</h3>
					<!-- class path tree -->
					<div id="classtree" class="col-xs-12 col-sm-7">
						<!-- computer science path trees -->
						<div id="compsci">
							<h4>Computer Science</h4>
							<em> Note: MATH 150 is a prereq for CMSC 201</em>
							<div class="col-xs-12">
								<!-- CMSC 200 level courses -->
								<?php

								$courses = [];
								$courses['cmsc'] = [];
								foreach($catalog as $class){
									if($class->department == 'cmsc')
										$courses['cmsc'][] = $class->number;
								}

								
								foreach($courses as $dept => $list): foreach($list as $class): ?>

									<label class='course' id="<?= $dept.$class; ?>label" for="<?= $dept.$class; ?>" onclick='labelOnClick(this)' onmouseover='labelOnMouseover(this)' >
										<?= strtoupper($dept); ?> <?= $class; ?>
									</label>
									<input type='checkbox' class='' name='course[]' id="<?= $dept.$class; ?>" value="<?= $dept.$class; ?>">

								<?php endforeach; endforeach; ?>
							</div>
						</div>

						<div id="math">
							<h4>MATH and STAT Courses</h4>
							<div class="col-xs-12">
								<?php
								$courses = ['math' => ['150', '151', '152', '221', '225', '251'], 'stat' => ['355']];

								foreach($courses as $dept => $list): foreach($list as $class): ?>

									<label class='course' id="<?= $dept.$class; ?>label" for="<?= $dept.$class; ?>" onclick='labelOnClick(this)' onmouseover='labelOnMouseover(this)' >
										<?= strtoupper($dept); ?> <?= $class; ?>
									</label>
									<input type='checkbox' class='' name='course[]' id="<?= $dept.$class; ?>" value="<?= $dept.$class; ?>">

								<?php endforeach; endforeach; ?>
							</div>
						</div>

						<!-- path trees for the suggested science courses -->
						<div id="sciences">
							<h4>Science Courses</h4>
							<div class="col-xs-12">
							<!-- chem101 -> chem102 -> chem102L -> GES110 -->
							<?php
								$courses = ['chem' => ['101', '102', '102L'], 'ges' => ['110']];

								foreach($courses as $dept => $list): foreach($list as $class): ?>

									<label class='course' id="<?= $dept.$class; ?>label" for="<?= $dept.$class; ?>" onclick='labelOnClick(this)' onmouseover='labelOnMouseover(this)' >
										<?= strtoupper($dept); ?> <?= $class; ?>
									</label>
									<input type='checkbox' class='' name='course[]' id="<?= $dept.$class; ?>" value="<?= $dept.$class; ?>">

								<?php endforeach; endforeach; ?>
							</div>
							<div id="path2">
							<!-- chem101 -> chem102 -> biol141 -> any lab -->
							</div>
							<div id="path3">
							<!-- biol 141 -> biol142 -> biol Lab -> phys121 -->
							</div>
							<div id="path4">
							<!-- phys121 -> phsy122 -> ges286 -->
							</div>
							<div id="path5">
							<!-- phys121 -> phys122 -> phys 122L -> math251  -->
							</div>
							<div id="path6">
							<!-- sci -> sci -> ges110/120 -> sci101L -->
							</div>
						</div>
					</div>
					<!-- Credit Counter -->
					<div id="credcounter" class="col-xs-12 col-sm-4">
						<div class="row">
							<div class="col-xs-12">
								<h3>Academic Record</h3>
								<table>
									<tr>
										<td>
											<strong>Credits Attempted</strong>
										</td>
										<td>
											<span id="takencredits">0</span>
										</td>
									</tr>
									<tr>
										<td>
											<strong>Writing Intensive:</strong>
										</td>
										<td>
											<span id="writingintensive">Not Taken</span>
										</td>
									</tr>
									<tr>
										<td>
											<strong>Required CS Classes:</strong>
										</td>
										<td>
											<span id="reqcs">201, 202, 203, 304, 313, 331, 341, 411, 421, 441, 447</span>
										</td>
									</tr>
								</table>
							</div>
							<div id="courseinfo" class="col-xs-12">
								<h3>Course Information</h3>
								<p>Hover over a course for more information.</p>
								<table>
									<tr>
										<td class="leftTable">
											<strong>Title:</strong>
										</td>
										<td>
											<span id="coursetitle"></span>
										</td>
									</tr>
									<tr>
										<td class="leftTable">
											<strong>Credits:</strong>
										</td>
										<td>
											<span id="coursecredits"></span>
										</td>
									</tr>
									<tr>
										<td class="leftTable">
											<strong>Description:</strong>
										</td>
										<td>
											<span id="coursedescription"></span>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<input class="btn btn-primary btn-lg pull-right" type="submit" id="submitbutton" value="SUBMIT">
				</form>
			</div>
		</div>
	</body>

	<script type="text/javascript"  src="/classList.js"></script>
</html>

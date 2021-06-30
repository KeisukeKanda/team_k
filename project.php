<?php

require("./dbset/dbset.php");
require_once 'funcs.php';
session_start();
$user_id = $_SESSION["user_id"];
$name= $_SESSION["name"];

?>


<!DOCTYPE HTML>
<html>
	<head>
		<title>ISEKAI</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/project.css">

	</head>
	<body>
        <?php include("component/header.php") ?>

		<!-- Wrapper -->


								<!-- Trip Proposal -->
					<section>
						<h1>Project Input Form</h1>
						<div>


								<form method="POST" action="project_insert.php" enctype="multipart/form-data">
									<div class="form">

										<div id="dragDropArea">
											<div class="drag-drop-inside">
												<p class="drag-drop-info">Project Photo <br>drag & drop</p>
												<p>
													<input name="project_img" id="project_img" type="file" accept="image/*" onChange="photoPreview(event)">
												</p>
												<div id="previewArea"></div>
											</div>
										</div>

										<div class="project-info">
										<div>
											<input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>" />
										</div>
										<div class="form_half">
											<div>
												<div class="title">Title</div>
												<input type="text" name="title" id="title" value="" />
											</div>
											<div>
												<div class="title">Category</div>
												<input type="text" name="category" id="category" value="" />
											</div>
										</div>
										<div class="form_half">
											<div>
												<div class="title">Country</div>
												<input type="text" name="country" id="country" value="" />
											</div>
											<div>
												<div class="title">Area</div>
												<input type="text" name="project_area" id="project_area" value="" />
											</div>
										</div>
										<div class="form_half">
											<div>
												<div class="title">Experience</div>
												<textarea name="experience" id="experience" cols="30" rows="10"></textarea>
											</div>
											<div>
												<div class="title">Thoughts</div>
												<textarea name="thoughts" id="thoughts" cols="30" rows="10"></textarea>
											</div>
										</div>
										<div class="form_half">
											<div>
												<div class="title">Tour Time</div>
												<input type="tour_time" name="tour_time" id="tour_time" value="1" />
											</div>
											<div>
												<div class="title">Price</div>
												<input type="price" name="price" id="price" value="1000" />
											</div>
										</div>
									</div>
									</div>

									<div class="nav_btn">
										<input type="submit" value="Propose" class="btn"/>
										<input type="reset" value="Clear" class="btn" />
									</div>
								</form>
						</div>


			<script>
				 var fileArea = document.getElementById('dragDropArea');
					var fileInput = document.getElementById('project_img');
					fileArea.addEventListener('dragover', function (evt) {
						evt.preventDefault();
						fileArea.classList.add('dragover');
					});
					fileArea.addEventListener('dragleave', function (evt) {
						evt.preventDefault();
						fileArea.classList.remove('dragover');
					});
					fileArea.addEventListener('drop', function (evt) {
						evt.preventDefault();
						fileArea.classList.remove('dragenter');
						var files = evt.dataTransfer.files;
						console.log("DRAG & DROP");
						console.table(files);
						fileInput.files = files;
						photoPreview('onChange', files[0]);
					});
					function photoPreview(event, f = null) {
						var file = f;
						if (file === null) {
							file = event.target.files[0];
						}
						var reader = new FileReader();
						var preview = document.getElementById("previewArea");
						var previewImage = document.getElementById("previewImage");
						console.log(reader);

						if (previewImage != null) {
							preview.removeChild(previewImage);
						}
						reader.onload = function (event) {
							var img = document.createElement("img");
							img.setAttribute("src", reader.result);
							img.setAttribute("id", "previewImage");
							preview.appendChild(img);

							console.log(reader.result);

						};
						reader.readAsDataURL(file);
					};
			</script>

    <?php include("component/footer.php") ?>

	</body>
</html>

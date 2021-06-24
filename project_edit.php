<?php

require("db_set/db.php");
require_once 'funcs.php';
session_start();
$user_id = $_SESSION["user_id"];
$name= $_SESSION["name"];

$project_id = filter_input( INPUT_GET, "id" );


// require_once 'funcs.php';
// sschk();
// $pdo = connectDB();
// $id = $_SESSION["id"];

$sql = 'SELECT * FROM project WHERE project_id = :project_id LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch();
?>


<!DOCTYPE HTML>
<html>
	<head>
		<title>teamk</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<style>
			#dragDropArea{
				background-color: #f4f4f4;
				margin: 10px;
				padding: 10px;
				border: #ddd dashed 5px;
				min-height: 200px;
				text-align: center;
			}
			#dragDropArea p{
					color: #999;
					font-weight: bold;
					font-size: 14px;
					font-size: 1.4em;
			}
			#dragDropArea .drag-drop-buttons{
					margin-top: 20px;
					font-size: 12px;
					font-size: 1.2em;
			}
			.drag-drop-buttons input{
					margin: auto;
			}
			#previewImage{
					width: 500px;
			}
		</style>
	</head>
	<body>

		<!-- Wrapper -->


								<!-- Trip Proposal -->
					<section>
						<h3>Project Edit Form</h3>
						<div>
							<section>
								<form method="POST" action="project_update.php" enctype="multipart/form-data">
									<div>
										<div>
											<input type="hidden" name="user_id" id="user_id" value="<?=$result["user_id"] ?>" />
										</div>
										<div>
											<label for="title">Title</label>
											<input type="text" name="title" id="title" value="<?=$result["title"] ?>" />
										</div>
										<div>
											<label for="category">Category</label>
											<input type="text" name="category" id="category" value="<?=$result["category"] ?>" />
										</div>
										<div>
											<label for="country">Country</label>
											<input type="text" name="country" id="country" value="<?=$result["country"] ?>" />
										</div>
										<div>
											<label for="project_area">Area</label>
											<input type="text" name="project_area" id="project_area" value="<?=$result["project_area"] ?>" />
										</div>
										<div>
											<label for="experience">Experience</label>
											<input type="text" name="experience" id="experience" value="<?=$result["experience"] ?>" />
										</div>
										<div>
											<label for="thoughts">Thoughts</label>
											<input type="text" name="thoughts" id="thoughts" value="<?=$result["thoughts"] ?>" />
										</div>
										<div>
											<label for="tour_time">Tour Time</label>
											<input type="text" name="tour_time" id="tour_time" value="<?=$result["tour_time"] ?>" />
										</div>
										<div>
											<label for="price">Price</label>
											<input type="text" name="price" id="price" value="<?=$result["price"] ?>" />
										</div>
										<div>
											<input type="hidden" name="project_id" id="project_id" value="<?=$result["project_id"] ?>" />
										</div>

											<div id="dragDropArea">
												<div class="drag-drop-inside">
													<p class="drag-drop-info">Project Photo <br>drag & drop</p>
													<p>
														<input name="project_img" id="project_img" type="file" accept="image/*" onChange="photoPreview(event)">
													</p>
													<div id="previewArea"></div>
												</div>
											</div>

									<ul class="actions">
										<li><input type="submit" value="Edit" /></li>
										<li><input type="reset" value="Clear" /></li>
									</ul>
								</form>
							</section>
						</div>
					</section>


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
	</body>
</html>

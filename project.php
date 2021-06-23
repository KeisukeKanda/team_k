<?php
// session_start();

require("db_set/db.php");

// require_once 'funcs.php';
// sschk();
// $pdo = connectDB();
// $id = $_SESSION["id"];

// $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':id', $id, PDO::PARAM_INT);
// $stmt->execute();
// $result = $stmt->fetch();
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
						<h3>Project Input Form</h3>
						<div>
							<section>
								<form method="POST" action="project_insert.php" enctype="multipart/form-data">
									<div>
										<div>
											<label for="user_id">User ID</label>
											<input type="text" name="user_id" id="user_id" value="1" />
										</div>
										<div>
											<label for="title">Title</label>
											<input type="text" name="title" id="title" value="aaa" />
										</div>
										<div>
											<label for="category">Category</label>
											<input type="text" name="category" id="category" value="aaa" />
										</div>
										<div>
											<label for="country">Country</label>
											<input type="text" name="country" id="country" value="aaa" />
										</div>
										<div>
											<label for="project_area">Area</label>
											<input type="text" name="project_area" id="project_area" value="aaa" />
										</div>
										<div>
											<label for="experience">Experience</label>
											<input type="experience" name="experience" id="experience" value="aaa" />
										</div>
										<div>
											<label for="thoughts">Thoughts</label>
											<input type="thoughts" name="thoughts" id="thoughts" value="aaa" />
										</div>
										<div>
											<label for="tour_time">Tour Time</label>
											<input type="tour_time" name="tour_time" id="tour_time" value="1" />
										</div>
										<div>
											<label for="price">Price</label>
											<input type="price" name="price" id="price" value="1000" />
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
										<li><input type="submit" value="Propose" /></li>
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

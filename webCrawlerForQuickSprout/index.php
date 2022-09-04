<!DOCTYPE html>
<html>

<head>
	<title>Web Crawling</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style type=”text/css”>
	a {
		text-decoration: none
	}
</style>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light ">
		<div class="container justify-content-center">
			<a style="font-family:fantasy" class="navbar-brand text-center lead" href="https://www.kompas.com/tag/hukum">
				Kompas.com

	</nav>

	<div class="container ">

		<div class="row">

			<?php
			$pages_to_crawl = 6; //dibatasi 5 halaman

			for ($p = 1; $p <= $pages_to_crawl; $p++) {
				$page_contents = file_get_contents('https://www.kompas.com/tag/hukum?sort=desc&page=' . $p . '/');

				if ($page_contents !== FALSE && !empty($page_contents)) {

					// Extract all articles
					$main_contents = explode('<div class="row article__wrap__grid--flex col-offset-fluid mt2">', $page_contents);

					// Each article
					$articles = explode('<div class="col-bs9-3">', $main_contents[1]);

					$ignore = explode('<div class="title clearfix">', $articles[0]);

					for ($i = 0; $i < 4; $i++) {
						// Extract main image
						$main_image = explode('<div class="article__asset"', $articles[$i]);
						$main_image = explode('<img src="', $main_image[1]);
						$main_image = explode('"', $main_image[1]);
						$main_image = trim($main_image[0]);

						// Extract post title along with it's link
						$title = explode('<div class="article__box"', $articles[$i]);
						$title = explode('<h3 class="article__title"', $title[1]);

						$slug = explode('<div class="article__lead"', $title[1]);

						$title = preg_replace('/>/i', ' ', $title[0]);
						$title = trim($title[0]);
						echo $title;

						$slug = trim($slug[0]);

						echo '
								<div class="col m-3">
									<div class="card" style="width: 18rem;">
										<img src="' . $main_image . '" class="card-img-top rounded mx-auto d-block" alt="' . $main_image . '">
										<div class="card-body">
											<h5 style="text-decoration: none" class="card-title lead">' . $slug . '</h5>				
										</div>
									</div>
									
								</div>
							';
					}
				}
			}
			?>
		</div>
	</div>
</body>

</html>
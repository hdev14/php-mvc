<?php

require '../bootstrap/bootstrap.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset=”UTF-8”>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
	<title>PHP - MVC</title>
</head>
<body>
	<div class="flex mb-4">
  		<div class="w-full bg-gray-500 h-12">
  			<?php 
  				require load(); 
  			?>
  		</div>
	</div>
</body>
</html>



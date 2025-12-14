<?php
// This file should bootstrap the Laravel application via public/index.php
// Do NOT require Blade templates directly. Require the front controller instead.

$front = __DIR__ . '/../public/index.php';
if (file_exists($front)) {
	require $front;
} else {
	http_response_code(500);
	echo "Bootstrap file not found: {$front}";
}

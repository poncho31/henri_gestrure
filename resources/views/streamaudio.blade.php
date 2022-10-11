header('Content-Type: audio/mpeg');
header('Content-length: ' . filesize('/path/to/your/file.mp3'));
print file_get_contents('/path/to/your/file.mp3');

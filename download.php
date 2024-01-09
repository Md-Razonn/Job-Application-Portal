<?php
if (isset($_GET["file"])) {
  $file = $_GET["file"];

  // Specify the directory where the files are stored
  $directory = "uploaded_pdf/";

  // Specify the file path
  $file_path = $directory . $file;

  if (file_exists($file_path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_path));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    ob_clean();
    flush();
    readfile($file_path);
    exit;
  } else {
    echo "File not found.";
  }
}
?>

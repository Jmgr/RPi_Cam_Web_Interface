<?php
  function camera_backend_running() {
    exec("pgrep -f '(^|/)([r]aspimjpeg|[r]aspimjpeg-picamera2)( |$)'", $pids, $rc);
    return ($rc == 0 && count($pids) > 0);
  }

  // send content
  $file_content = "";
  for($i=0; $i<30; $i++) {
    $file_content = file_get_contents("status_mjpeg.txt");
    if(trim($file_content) != "halted" && !camera_backend_running()) {
      $file_content = "halted";
      file_put_contents("status_mjpeg.txt", $file_content);
    }
    if($file_content != $_GET["last"]) break;
    usleep(100000);
  }
  touch("status_mjpeg.txt");
  echo $file_content;

?>

<?php
   define('BASE_DIR', dirname(__FILE__));
   require_once(BASE_DIR.'/config.php');

   function start_camera_backend() {
      shell_exec("sudo /usr/bin/raspimjpeg > /dev/null 2>&1 &");
   }

   function camera_backend_running() {
      exec("pgrep -f '(^|/)([r]aspimjpeg|[r]aspimjpeg-picamera2)( |$)'", $pids, $rc);
      return ($rc == 0 && count($pids) > 0);
   }

   if(isset($_GET["cmd"])) {
      $cmd = $_GET["cmd"];
      if(trim($cmd) == "ru 1") {
         if(!camera_backend_running()) {
            start_camera_backend();
            usleep(500000);
            exit;
         }
      }

      if(camera_backend_running()) {
         $pipe = fopen("FIFO","w");
         if($pipe !== false) {
            fwrite($pipe, $cmd . "\n");
            fclose($pipe);
         }
      } else {
         if(trim($cmd) == "ru 0") {
            file_put_contents("status_mjpeg.txt", "halted");
         }
      }
   }
?>

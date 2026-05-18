Web based interface for controlling the Raspberry Pi Camera, includes motion detection, time lapse, and image and video recording.
Current version 6.6.26
All information on this project can be found here: http://www.raspberrypi.org/forums/viewtopic.php?f=43&t=63276

The wiki page can be found here:

http://elinux.org/RPi-Cam-Web-Interface

This includes the installation instructions at the top and full technical details.
For latest change details see:

https://github.com/silvanmelchior/RPi_Cam_Web_Interface/commits/master
  
This version has updates for php7.3 / Buster. May need further changes for nginx

Modern camera stack note:
This fork replaces the legacy MMAL raspimjpeg binary at install time with
bin/raspimjpeg-picamera2, a Python compatibility daemon that uses Picamera2 /
libcamera while preserving the existing FIFO, status_mjpeg.txt, cam.jpg and
media file contracts used by the PHP interface.

Target test platform:
- Raspberry Pi OS based on Debian 13 / Trixie
- Raspberry Pi camera detected by libcamera, including OV5647 camera v1 modules
- Packages installed by install.sh include python3-picamera2, python3-pil,
  python3-numpy and ffmpeg

For OV5647 NoIR modules, set this in the installed raspimjpeg config or uconfig:

  tuning_file /usr/share/libcamera/ipa/rpi/vc4/ov5647_noir.json

Motion detection in the Picamera2 backend uses low-resolution luminance frame
differencing. For insects on a flower, a practical starting point is:

  motion_noise 1010
  motion_threshold 80
  motion_clip 3
  motion_initframes 4
  motion_startframes 2
  motion_stopframes 200
  motion_sample_interval 0.4

The existing Motion Settings UI is used by this detector: noise, threshold,
clipping, mask image, delay/start/stop frames, vector preview and .dat output
all map to the Picamera2 backend. Mask images use white pixels as active
detection areas and black pixels as ignored areas.

Do not run install.sh on a non-Raspberry Pi host unless you intentionally want
it to modify that system's web server, users, sudoers and /var/www setup.

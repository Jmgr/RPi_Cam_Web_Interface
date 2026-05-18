There are 2 ways of installing the software ./RPi_Cam_Web_Interface_Installer.sh and a set of dedicated scripts.

The ./RPi_Cam_Web_Interface_Installer.sh is the original scheme largely developed under Wheezy.

The dedicated scripts are a re-factoring to simplify the process and these work under Wheezy and Jessie.
Future changes will be made to these.

5 scripts are used instead of combining all together.
This avoids the overhead of a separate selection and makes it easier to run a particular function automatically.
So start and stop can just be run as separate activities.

The scripts are
install.sh main installation
update.sh check for updates and then run main installation
start.sh starts the software
stop.sh stops the software
remove.sh removes the software

The main installation always does the same thing to simplify its logic.
It gathers all user parameters first in one combined dialog and then always
applies the parameters as it goes through the process.
A q (quiet) parameter may be used to skip this and give an automatic install based on config.txt
All parameters are always in the config.txt file, a default version is created if one
doesn't exist and is then changed just once after the initial user dialog.
The installation always tries to upgrade the main software components and then functionally goes through
the configuration steps for each area like apache, motion start up.

Debug is turned on for the moment so it logs its activity to a file called install.txt

Modern Raspberry Pi camera stack
--------------------------------
This branch installs bin/raspimjpeg-picamera2 as /usr/bin/raspimjpeg. It is not
the old MMAL binary; it is a compatibility daemon for the existing web UI using
Picamera2/libcamera.

Before running the full installer on a Pi, verify the camera with:

  rpicam-hello --list-cameras
  rpicam-still -o /tmp/cam-test.jpg

Then run the normal installer on the Pi, not on a laptop:

  ./install.sh

The installer modifies packages, web server configuration, www-data groups,
sudoers, /var/www and startup files.

For an OV5647 NoIR camera, add this line to the installed raspimjpeg config or
uconfig before restarting:

  tuning_file /usr/share/libcamera/ipa/rpi/vc4/ov5647_noir.json

For insects on a flower, start motion detection with:

  motion_noise 1010
  motion_threshold 80
  motion_clip 3
  motion_initframes 4
  motion_startframes 2
  motion_stopframes 200
  motion_sample_interval 0.4

The Motion Settings page controls the Picamera2 detector. A mask image uses
white pixels as active detection areas and black pixels as ignored areas. Save
vectors writes lightweight samples to media/motion.dat.

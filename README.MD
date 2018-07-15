# WebGUI for sio2bsd

![Screenshot](https://user-images.githubusercontent.com/29672548/42733316-ae4edf4a-882f-11e8-9d9f-891accd25c0a.jpg "WebGUI (index.css.php) rendered by a chrome browser on windows")

## Background
When you are at an event and have limited space and even less time to do something usefull I often find myself taking shortcuts. Here's a shortcut I took in an hour or so, because I planned on attending an Home Computer event here in NL and wanted to do some coding on a 20 year old demo I couldn't get fixed.

Normally I am more of a CLI kinda GUY, but at an event I don't like leaving my laptop on a desk and keeping a shell open for no good reason. Besides that, more devices take up more space and I was not expecting to have much space available. In order to quickly swap disks at the event I wanted to have a simple webgui to swap disks on the less than a desk setup I brought along:
*  WRT54G router (DHCP server and WiFi access point)
*  Raspberry Pi
*  SIO2PC/10502PC Dual-USB (from Atari8Warez)
*  Phone and Tablet
*  Monitor
*  Miscellaneous stuff (power supplies, ethernet cables, etc).

I had already copied a few hundred ATR's to the Raspbery Pi's SD card (Demos, DOS, Atmas II, etc). So no more dragging along mountains of floppies that are badly- or mislabeled, but how to make the swapping of disks easy as Pi(e)? Well I had a credit card size linux server with me, so why not (ab-)use that some more...

## Installation
First install a webserver and my (web-) scripting language of choice (2nd):

    apt-get install -y mini-httpd php5-cgi
    mkdir -p /var/www/html && chown -R www-data: /var/www/
Then create a minimal version the mini-httpd config file:

    cat << EOF > /etc/mini-httpd.conf
    host=0.0.0.0
    port=80
    user=www-data
    nochroot
 
    # Where are the web files stored?
    data_dir=/var/www/html
    cgipat=**.php|**.cgi
    logfile=/var/log/mini-httpd.log
    pidfile=/var/run/mini-httpd.pid
 
    charset=iso-8859-1
    EOF
FIX the default settings in the .ini file of the php5-cgi package which is apache tailored and does not work with mini-httpd by default:

    sed -i 's/\;cgi\.force_redirect\ =\ 1/cgi\.force_redirect\ =\ 0/' /etc/php5/cgi/php.ini
Last modify `/etc/default/mini-httpd` to allow the service to start, enable the service in the default runlevels and start it manually for this session:

    cat << EOF > /etc/default/mini-httpd
    # Defaults for mini_httpd initscript
    # Author: Marvin Stark <marv@der-marv.de>

    # Start daemon?
    # 0 = no
    # 1 = yes
    START=1

    # Additional options that are passed to the Daemon.
    DAEMON_OPTS="-C /etc/mini-httpd.conf"
    EOF
    insserv -d mini-httpd
    service mini-httpd start
Now the web server is up and running, it is time to install the code to swap the floppies. First off, it all needs to reside in `/var/www/html`, as that's where the web server is looking for its files. The application can be installed like so: `git clone https://github.com/senorrossie/php-sio2bsd-web.git /var/www/html/ && chown -R www-data: /var/www/html`

## Dependencies
In order to talk SIO over the USB/Serial port, you need the [sio2bsd program](https://github.com/TheMontezuma/SIO2BSD). A precompiled version is available from the [Atari Age forum post](http://atariage.com/forums/topic/209010-sio2pi-raspberry-pi-as-a-floppy/) on the subject.

## Configuration
There already is a config file in the repo with some sane defaults (notice that I moved the sio2bsd executable to a directory in the default path (`/usr/bin`)). If you want to store the command someplace else, simply specify the full path for `$cfg["sio2bsd"]["cmd"]`, eg: `$cfg["sio2bsd"]["cmd"]="/usr/local/bin/sio2bsd";`
If you need warp speed or want to add other parameters to the sio2bsd command by default, put them in `$cfg["sio2bsd"]["param"]=""` and if you want to load a default disk in a drive, specify the full path to the ATR file here as well.

## Generate the list of ATR's
In order to update your list of images I created a separate script. As the Pi is not the fastest device on the planet and I/O is quite a heavy operation I decided to store the list with available ATR images on disk instead of having to create that list every time you load or update the page. You can run it from cron, or via the web server, whatever you prefer. Remember, that `gen_atrlist.php` needs to run at least once.

## Index
The main hack... Here is where the ~~icky~~magic part happens. There are two versions, one based on layout via css and one using tables. Create a symlink to the version you prefer:

     cd /var/www/html && ln -s index.css.php index.php
or

     cd /var/www/html && ln -s index.tables.php index.php

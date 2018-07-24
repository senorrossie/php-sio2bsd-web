# WebGUI for sio2bsd
The [old version](https://github.com/senorrossie/php-sio2bsd-web/releases/tag/v1.0 "old version") is no more.... Here is the new and improved version:
![Develop Screenshot](https://user-images.githubusercontent.com/29672548/43044813-bd58d67a-8dad-11e8-97cd-6f84b2c5a5ed.jpg 
"WebGUI (index.php) rendered by a chrome browser on windows")

## Background
What I hacked together in an hour sufficed for the moment. With all the new atari 8-bit stuff that is released, this hack needed some improvements to bring it into the modern atari 8-bit era, so to say.

Even though I am personally using this on a raspberry pi, any machine capable of running linux and/or sios2bd should work. Also any webserver capable of running php can be used. I tested this only on mini-httpd.

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

### Optional: The fandal archive
If you are not like me, and you do not have tons of .atr images lying around, perhaps a kickstart is needed. For example, let's have the Fandal collection available on your RasPi, so you can experience both modern and classic games, and even demos!

Fetch the complete archive in zip format (link is on the fandal webpage) and copy it to your pie, of feed the URL to wget on the RasPi itself. Unpack the archive to a directory you like, preferably in the basedir of the webserver (eg. `/var/www/html/fandal`) and don't forget to set the correct permissions(`chown -R www-data: /var/www/html/fandal`). And as a last step, you need to modify `.config.inc.php` (`$cfg["atr"]["path"]`) to match the location you selected.

## Dependencies
In order to talk SIO over the USB/Serial port, you need the [sio2bsd program](https://github.com/TheMontezuma/SIO2BSD). A precompiled version is available from the [Atari Age forum post](http://atariage.com/forums/topic/209010-sio2pi-raspberry-pi-as-a-floppy/) on the subject.

## Configuration
There already is a config file in the repo with some sane defaults (notice that I moved the sio2bsd executable to a directory in the default path (`/usr/bin`)). If you want to store the command someplace else, simply specify the full path for `$cfg["sio2bsd"]["cmd"]`, eg: `$cfg["sio2bsd"]["cmd"]="/usr/local/bin/sio2bsd";`
If you need warp speed or want to add other parameters to the sio2bsd command by default, put them in `$cfg["sio2bsd"]["param"]=""` and if you want to load a default disk in a drive, specify the full path to the ATR file here as well.

## SIO2BSD
The original [sio2bsd program](https://github.com/TheMontezuma/SIO2BSD) sets the permissions on the serial lockfile (/tmp/sio2bsd.*) fairly strict. This causes the webgui to fail to restart the program. I created a binary that sets the permissions a lot less strict. To install this, issue the following commands (note that you specify the same destination directory as you put in your config file):

    sudo cp sio2bsd /usr/bin
    sudo chown root:root /usr/bin/sio2bsd
    sudo chmod 4755 /usr/bin/sio2bsd
    sudo rm -rf /tmp/sio2b* 2>/dev/null
This will install the sio2bsd application to /usr/bin and makes it SETUID root.

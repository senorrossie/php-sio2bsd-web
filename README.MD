# WebGUI for sio2bsd
The [old version](https://github.com/senorrossie/php-sio2bsd-web/releases/tag/v1.0 "old version") is no more.... Here is the new and improved version:
![Develop Screenshot](https://user-images.githubusercontent.com/29672548/43044813-bd58d67a-8dad-11e8-97cd-6f84b2c5a5ed.jpg 
"WebGUI (index.php) rendered by a chrome browser on windows")

## Background
What I hacked together in an hour sufficed for the moment and has been in use for the last couple of years on occasion. With all the new atari 8-bit stuff that is released, I felt this hack needed some improvements to bring it into the modern atari 8-bit era.
Even though I am currently using this GUI with various Pie recipes (orange, banana and raspberry), know that any machine capable of running sios2bd, php and a web server should work.

## Dependencies
In order to talk SIO over the USB/Serial port, you need the [sio2bsd program](https://github.com/TheMontezuma/SIO2BSD). A precompiled version is available from the [Atari Age forum post](http://atariage.com/forums/topic/209010-sio2pi-raspberry-pi-as-a-floppy/) on the subject. Compiling the application yourself is easy as pie (on a debian based host):

    apt-get install build-essentials
    git clone https://github.com/TheMontezuma/SIO2BSD.git
    cd SIO2BSD
    make && make install
Will install a fresh binary into `/usr/local/bin`

## Configuration
There already is a config file in the repo with some sane defaults (notice that I moved the sio2bsd executable to a directory in the default path (`/usr/bin`)). If you want to store the command someplace else, simply specify the full path for `$cfg["sio2bsd"]["cmd"]`, eg: `$cfg["sio2bsd"]["cmd"]="/usr/local/bin/sio2bsd";`
If you need warp speed or want to add other parameters to the sio2bsd command by default, put them in `$cfg["sio2bsd"]["param"]=""` and if you want to load a default disk in a drive, specify the full path to the ATR file here as well.

## Usage
The `gen_pathtree.php` script gathers all files and directories below the folder you specified in `$cfg["atr"]["path"]`. If there is a `.png` image with the same filename as the `.atr`, it will be added to the html file generated by the `gen_slide.php` script.

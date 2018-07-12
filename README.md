#iOS Rotation Correction

v1.0, 12-Jul-2018  
<github.com/scrow/iosrotate>  
[Steve Crow](mailto:scrow@sdf.org)

This is a quick and dirty PHP script to "correct" the rotation of photos taken with an Apple iOS device.  The primary purpose is to correct orientation of images for upload to a blog or other system which does not read or honor EXIF orientation data.  [Randomly-selected article on the subject.](https://organicweb.com.au/20257/wordpress/iphone-photo/)

This script was written for my personal use on the [SDF Public Access Unix System](http://sdf.org) MetaArray.  It should work on most any *nix-ish system with ImageMagick and the necessary delegates for the image types you wish to convert.  The ability to execute commands with `shell_exec()` is required.

The source file is deleted immediately upon processing by 'convert' and the script cleans all old (> 2 minutes) output files.  File types are not changed and quality is set to a maximum.  Note that there will almost always still be some quality loss from using this script as images are re-saved in a compressed format.  This script supports a checkbox that forces the output to TIFF for maximum quality.

Users on cellular or public Wi-Fi may encounter additional (perhaps excessive) compression of the output image due to the widespread use of image compression proxies by these service providers.  This can be avoided by serving this page over HTTPS, from a local web server, or over an SSH tunnel to a remote server.

This script is clearly not meant for use in a public setting.  At a minimum the web page and its output folder should be secured with a password.  Output files are retained on the server until at least two minutes old.  The output folder could be kept clean with a periodic cron job.  You might consider ensuring directory listing is disabled in the output folder if this folder will be publicly accessible.  In many cases you can do this with an `.htaccess` file.

Since this is a personal project I do not intend to maintain this script long term but I welcome any feedback and might make some changes here and there.

## Installation

Copy `config.inc.php-example` to `config.inc.php` and populate the paths to the output folder on the web server.  Create the output folder and secure the installation.
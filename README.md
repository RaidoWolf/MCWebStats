MCWebStats
==========

Minecraft server/player statistics standalone web application suite.
Version 0.3 alpha

MCWebStats by Alexander Barber github.com/aebarber (Apache v2 License, see LICENSE)
PHP-GetUUID by cstdio github.com/cstdio (MIT License, see LICENSE)

stats.php - a form script that reads and displays stats of a given user (currently as formatted JSON).

This software now works with both pre-1.7.6 servers without the UUID system,
as well as newer 1.8+ UUID-based servers (thanks to cstdio's PHP-GetUUID)

DEPENDENCIES:
	- Web server (Apache2 recommended)
	- PHP5 (5.3+ recommended)
	- PHP5-curl (curl for PHP, package name php5-curl)

INSTALLATION
	- If you have not already, install a PHP-enabled web server. I recommend Apache2, but
others (such as nginx) are also options.
	- On debian systems, for example, this would be "sudo apt-get install apache2"
	- If you have not already, install PHP5.
	- On debian systems, for example, this would be "sudo apt-get install php5"
	- If you have not already, install PHP5-curl.
	- On debian systems, for example, this would be "sudo apt-get install php5-curl"
	- Upload the source to a web accessible directory.
	- Make sure all files have permissions 644 or -rw-r--r--.
	- Make sure all directories have permissions 755 or -rwxr-x-r-x.

Copyright Notice:
This software is provided with the Apache v2 license. For more information,
read "LICENSE" included in this source code.

Disclaimer:
This software is provided by the authors and contributors "as is,"
and any express or implied warranties, including, but not limited to,
the implied warranties of merchantability and fitness for a particular
purpose are disclaimed. In no event shall the authors or contributors
be liable for any direct, indirect, incidental, special, exemplary, or
consequential damages (including, but not limited to, procurement of
substitute goods or services, loss of use, data, or profits; or business
interruption) however caused and on any theory of liability, whether in
contract, strict liability, or tort (including negligence or otherwise)
arising in any way out of the use of this software, whether or not
advised of the possibility of any such damages. The authors and
contributors have no obligation to provide maintenance, support,
updates, modifications, or enhancements to this or any other software.

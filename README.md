/// LICENSE: WTFPL ( http://sam.zoy.org/wtfpl/COPYING ) ////////////

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 2, December 2004

 Copyright (C) 2004 Sam Hocevar <sam@hocevar.net>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.

////////////////////////////////////////////////////////////////////


Simple localhost Landing Page
------------------------------

Will problably switch this to XML and XSL to use as apache2 directory listing page.

Install:

1) Place index.php and .assets folder in root web directory.

2) Define path to VHOST directory in index.php, if capable (not by default on Windows).

3) Define path to FILE_DIR in index.php.

4) If you have phpinfo() already somewhere, define PHP_INFO. Or else:
+  cd /path/to/WEB_ROOT
+  touch phpinfo.php && sudo chmod 0640 phpinfo.php

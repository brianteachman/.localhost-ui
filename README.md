LICENSE: WTFPL ( http://sam.zoy.org/wtfpl/COPYING )

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 2, December 2004

 Copyright (C) 2004 Sam Hocevar <sam@hocevar.net>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.
  
***

Simple localhost Interface
==========================

A lightweight user interface for LAMP development. This is not finished software and as such it contains bugs, but, you know. :-)

So far, on Ubuntu, it provides links for quick access to:

+ the web root directory 
+ the VirtualHost directory found on Ubuntu flavored debian
+ phpMyAdmin, for MySQL needs
+ phpinfo()
+ local documentation
+ and a file handler

Install:

1. Place index.php, docs.php, and the .localhost folder in root web directory.
2. In /.localhost/runtime.inc.php, configure any constants that need configuring.
3. As is, this app depends on [php_error](http://phperror.net/) and [php-markdown](http://michelf.com/projects/php-markdown/). So, download and place both php_error.php and markdown.php into the /.localhost/vendor directory.

------------------------------------------------------------------------------------
> Note: In the future this will problably switch this to XML and XSL to use as apache2 directory listing page.


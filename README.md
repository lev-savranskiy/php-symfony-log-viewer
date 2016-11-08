## Symfony / Apache   Local Log Viewer

_Description_

Simple php file shows last 10 lines or Full  symfony and apache logs on a single page.

_Setup_

put file logs.php in Symfony's folder `/web/` 

Update logs.php  $p1 (apache logs path), $p2 (Symfony  logs path) variables  if dynamic resolving fails.

Example

`$p1 = "C:/xampp/apache/logs/error.log"`

`$p2 = "C:/Myproject/app/logs/prod.log"`

_Usage_

Go to project domain in browser 

Example
http://localhost/logs.php

_Result_

![ symfony / apache Local Log Viewer](https://raw.githubusercontent.com/lev-savranskiy/php-symfony-log-viewer/master/symfony-log-viewer.jpg)

_Author_
http://wap7.ru/folio/

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-01-13 01:11:40 --> 404 Page Not Found: /index
ERROR - 2023-01-13 02:24:51 --> 404 Page Not Found: /index
ERROR - 2023-01-13 09:05:17 --> 404 Page Not Found: /index
ERROR - 2023-01-13 13:24:57 --> 404 Page Not Found: /index
ERROR - 2023-01-13 15:20:20 --> 404 Page Not Found: /index
ERROR - 2023-01-13 15:20:20 --> 404 Page Not Found: /index
ERROR - 2023-01-13 15:20:20 --> 404 Page Not Found: /index
ERROR - 2023-01-13 15:20:20 --> 404 Page Not Found: /index
ERROR - 2023-01-13 15:38:54 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:01:16 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:01:18 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:03:24 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:03:34 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:17:15 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:18:51 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:19:25 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:19:56 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:56:35 --> 404 Page Not Found: /index
ERROR - 2023-01-13 16:56:36 --> 404 Page Not Found: /index
ERROR - 2023-01-13 17:43:20 --> 404 Page Not Found: /index
ERROR - 2023-01-13 17:43:35 --> 404 Page Not Found: /index
ERROR - 2023-01-13 19:10:27 --> 404 Page Not Found: /index
ERROR - 2023-01-13 19:50:15 --> 404 Page Not Found: /index
ERROR - 2023-01-13 20:45:38 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:05:47 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:05:48 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:05:58 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:06:06 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:10:18 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:16:20 --> Severity: Warning --> file_get_contents(https://maps.googleapis.com/maps/api/geocode/json?latlng=,&amp;sensor=false&amp;key=AIzaSyA5rd78xx-syTi-8XsW0JF3B6nMMG-tI1I): failed to open stream: HTTP request failed! HTTP/1.0 400 Bad Request
 /home/emqsdmzwimle/public_html/application/modules/api/controllers/Auth.php 342
ERROR - 2023-01-13 23:16:20 --> Severity: Notice --> Trying to get property 'status' of non-object /home/emqsdmzwimle/public_html/application/modules/api/controllers/Auth.php 347
ERROR - 2023-01-13 23:17:07 --> Severity: Warning --> file_get_contents(https://maps.googleapis.com/maps/api/geocode/json?latlng=,&amp;sensor=false&amp;key=AIzaSyA5rd78xx-syTi-8XsW0JF3B6nMMG-tI1I): failed to open stream: HTTP request failed! HTTP/1.0 400 Bad Request
 /home/emqsdmzwimle/public_html/application/modules/api/controllers/Auth.php 342
ERROR - 2023-01-13 23:17:07 --> Severity: Notice --> Trying to get property 'status' of non-object /home/emqsdmzwimle/public_html/application/modules/api/controllers/Auth.php 347
ERROR - 2023-01-13 23:50:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        co' at line 1 - Invalid query: SELECT `u`.`user_id`, `u`.`name`, `u`.`email`, `u`.`latitude`, `u`.`longitude`, (((acos(sin((*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        cos((`latitude`*pi()/180)) * cos(((-

        `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 

        as distance
FROM `users` `u`
WHERE `utype` = 2
AND `is_online` = 1
HAVING `distance` < 5000
ORDER BY `distance` asc
ERROR - 2023-01-13 23:50:48 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:50:49 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:52:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        co' at line 1 - Invalid query: SELECT `u`.`user_id`, `u`.`name`, `u`.`email`, `u`.`latitude`, `u`.`longitude`, (((acos(sin((*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        cos((`latitude`*pi()/180)) * cos(((-

        `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 

        as distance
FROM `users` `u`
WHERE `utype` = 2
AND `is_online` = 1
HAVING `distance` < 5000
ORDER BY `distance` asc
ERROR - 2023-01-13 23:52:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        co' at line 1 - Invalid query: SELECT `u`.`user_id`, `u`.`name`, `u`.`email`, `u`.`latitude`, `u`.`longitude`, (((acos(sin((*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        cos((`latitude`*pi()/180)) * cos(((-

        `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 

        as distance
FROM `users` `u`
WHERE `utype` = 2
AND `is_online` = 1
HAVING `distance` < 5000
ORDER BY `distance` asc
ERROR - 2023-01-13 23:52:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        co' at line 1 - Invalid query: SELECT `u`.`user_id`, `u`.`name`, `u`.`email`, `u`.`latitude`, `u`.`longitude`, (((acos(sin((*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        cos((`latitude`*pi()/180)) * cos(((-

        `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 

        as distance
FROM `users` `u`
WHERE `utype` = 2
AND `is_online` = 1
HAVING `distance` < 5000
ORDER BY `distance` asc
ERROR - 2023-01-13 23:52:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        co' at line 1 - Invalid query: SELECT `u`.`user_id`, `u`.`name`, `u`.`email`, `u`.`latitude`, `u`.`longitude`, (((acos(sin((*pi()/180)) *

        sin((`latitude`*pi()/180))+cos((*pi()/180)) *

        cos((`latitude`*pi()/180)) * cos(((-

        `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 

        as distance
FROM `users` `u`
WHERE `utype` = 2
AND `is_online` = 1
HAVING `distance` < 5000
ORDER BY `distance` asc
ERROR - 2023-01-13 23:53:17 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:53:17 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:54:01 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:54:08 --> 404 Page Not Found: /index
ERROR - 2023-01-13 23:57:28 --> 404 Page Not Found: /index

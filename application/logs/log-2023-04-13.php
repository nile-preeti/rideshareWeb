<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-04-13 00:26:16 --> 404 Page Not Found: /index
ERROR - 2023-04-13 01:07:02 --> 404 Page Not Found: /index
ERROR - 2023-04-13 01:07:27 --> 404 Page Not Found: /index
ERROR - 2023-04-13 01:07:29 --> 404 Page Not Found: /index
ERROR - 2023-04-13 01:08:00 --> 404 Page Not Found: /index
ERROR - 2023-04-13 01:08:01 --> 404 Page Not Found: /index
ERROR - 2023-04-13 02:31:04 --> 404 Page Not Found: /index
ERROR - 2023-04-13 02:31:05 --> 404 Page Not Found: /index
ERROR - 2023-04-13 04:01:58 --> 404 Page Not Found: /index
ERROR - 2023-04-13 04:01:59 --> 404 Page Not Found: /index
ERROR - 2023-04-13 04:20:45 --> 404 Page Not Found: /index
ERROR - 2023-04-13 04:20:48 --> 404 Page Not Found: /index
ERROR - 2023-04-13 04:20:49 --> 404 Page Not Found: /index
ERROR - 2023-04-13 04:20:52 --> 404 Page Not Found: /index
ERROR - 2023-04-13 04:29:43 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:31:46 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:31:50 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:34:47 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:34:48 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:40:29 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:40:29 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:59:58 --> 404 Page Not Found: /index
ERROR - 2023-04-13 05:59:59 --> 404 Page Not Found: /index
ERROR - 2023-04-13 06:06:44 --> 404 Page Not Found: /index
ERROR - 2023-04-13 06:06:49 --> Query error: Unknown column 'ph.date' in 'where clause' - Invalid query: SELECT *, (select (
            CASE WHEN DAYNAME(time)='Sunday' THEN sum(amount-(amount*(rate_chart.sunday/100)))
            WHEN DAYNAME(time)='Monday' THEN sum(amount-(amount*(rate_chart.monday/100)))
            WHEN DAYNAME(time)='Tuesday' THEN sum(amount-(amount*(rate_chart.tuesday/100)))
            WHEN DAYNAME(time)='Wednesday' THEN sum(amount-(amount*(rate_chart.wednesday/100)))
            WHEN DAYNAME(time)='Thursday' THEN sum(amount-(amount*(rate_chart.thursday/100)))
            WHEN DAYNAME(time)='Friday' THEN sum(amount-(amount*(rate_chart.friday/100)))
            WHEN DAYNAME(time)='Saturday' THEN sum(amount-(amount*(rate_chart.saturday/100)))           
            END) as amount FROM rides left join rate_chart on 1=1 WHERE driver_id=users.user_id AND `status` = 'COMPLETED' GROUP BY driver_id) as earning_amount
FROM `users`
WHERE DATE_FORMAT(ph.date,'%Y/%m/%d') >= '2023/04/11'
AND DATE_FORMAT(ph.date,'%Y/%m/%d') <= '2023/04/21'
AND `utype` = 2
ORDER BY `user_id` DESC
ERROR - 2023-04-13 06:06:49 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:01:27 --> Query error: Column 'status' in where clause is ambiguous - Invalid query: SELECT `b`.`brand_name`, `m`.`brand_id`, `m`.`model_name`, `m`.`status`, `m`.`id`
FROM `models` `m`
LEFT JOIN `brands` `b` ON `b`.`id`=`m`.`brand_id`
WHERE `status` = '1'
ORDER BY `m`.`id` DESC
ERROR - 2023-04-13 07:01:28 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:01:35 --> Query error: Column 'status' in where clause is ambiguous - Invalid query: SELECT `b`.`brand_name`, `m`.`brand_id`, `m`.`model_name`, `m`.`status`, `m`.`id`
FROM `models` `m`
LEFT JOIN `brands` `b` ON `b`.`id`=`m`.`brand_id`
WHERE `status` = '1'
ORDER BY `m`.`id` DESC
ERROR - 2023-04-13 07:03:22 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:03:23 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:03:29 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:05:07 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:05:16 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:08:26 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:08:35 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:08:53 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:34:42 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:35:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/emqsdmzwimle/public_html/application/third_party/PHPExcel/Classes/PHPExcel/Calculation.php:3169) /home/emqsdmzwimle/public_html/application/modules/admin/controllers/Export.php 93
ERROR - 2023-04-13 07:35:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/emqsdmzwimle/public_html/application/third_party/PHPExcel/Classes/PHPExcel/Calculation.php:3169) /home/emqsdmzwimle/public_html/application/modules/admin/controllers/Export.php 95
ERROR - 2023-04-13 07:35:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/emqsdmzwimle/public_html/application/third_party/PHPExcel/Classes/PHPExcel/Calculation.php:3169) /home/emqsdmzwimle/public_html/application/modules/admin/controllers/Export.php 97
ERROR - 2023-04-13 07:35:48 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:36:31 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:36:36 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:36:40 --> 404 Page Not Found: /index
ERROR - 2023-04-13 07:39:00 --> 404 Page Not Found: /index
ERROR - 2023-04-13 08:36:21 --> 404 Page Not Found: /index
ERROR - 2023-04-13 08:36:21 --> 404 Page Not Found: /index
ERROR - 2023-04-13 08:50:45 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/emqsdmzwimle/public_html/application/third_party/PHPExcel/Classes/PHPExcel/Calculation.php:3169) /home/emqsdmzwimle/public_html/application/modules/admin/controllers/Export.php 93
ERROR - 2023-04-13 08:50:45 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/emqsdmzwimle/public_html/application/third_party/PHPExcel/Classes/PHPExcel/Calculation.php:3169) /home/emqsdmzwimle/public_html/application/modules/admin/controllers/Export.php 95
ERROR - 2023-04-13 08:50:45 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/emqsdmzwimle/public_html/application/third_party/PHPExcel/Classes/PHPExcel/Calculation.php:3169) /home/emqsdmzwimle/public_html/application/modules/admin/controllers/Export.php 97
ERROR - 2023-04-13 08:50:45 --> 404 Page Not Found: /index
ERROR - 2023-04-13 09:04:07 --> 404 Page Not Found: /index
ERROR - 2023-04-13 09:47:23 --> 404 Page Not Found: /index
ERROR - 2023-04-13 09:47:24 --> 404 Page Not Found: /index
ERROR - 2023-04-13 09:47:25 --> 404 Page Not Found: /index
ERROR - 2023-04-13 09:47:26 --> 404 Page Not Found: /index
ERROR - 2023-04-13 09:59:01 --> 404 Page Not Found: /index
ERROR - 2023-04-13 09:59:02 --> 404 Page Not Found: /index
ERROR - 2023-04-13 11:22:02 --> 404 Page Not Found: /index
ERROR - 2023-04-13 11:22:13 --> 404 Page Not Found: /index
ERROR - 2023-04-13 11:22:40 --> 404 Page Not Found: /index
ERROR - 2023-04-13 11:22:55 --> 404 Page Not Found: ../modules/admin/controllers/Admin/controller
ERROR - 2023-04-13 11:23:07 --> 404 Page Not Found: /index
ERROR - 2023-04-13 11:23:31 --> 404 Page Not Found: /index
ERROR - 2023-04-13 11:23:54 --> 404 Page Not Found: /index
ERROR - 2023-04-13 13:08:59 --> 404 Page Not Found: /index
ERROR - 2023-04-13 13:09:00 --> 404 Page Not Found: /index
ERROR - 2023-04-13 15:49:51 --> 404 Page Not Found: /index
ERROR - 2023-04-13 17:33:29 --> 404 Page Not Found: /index
ERROR - 2023-04-13 17:33:34 --> 404 Page Not Found: /index
ERROR - 2023-04-13 18:25:37 --> 404 Page Not Found: /index
ERROR - 2023-04-13 18:25:41 --> 404 Page Not Found: /index
ERROR - 2023-04-13 18:26:43 --> 404 Page Not Found: /index
ERROR - 2023-04-13 19:32:11 --> 404 Page Not Found: /index
ERROR - 2023-04-13 19:32:11 --> 404 Page Not Found: /index
ERROR - 2023-04-13 19:46:46 --> 404 Page Not Found: /index
ERROR - 2023-04-13 21:48:46 --> 404 Page Not Found: /index
ERROR - 2023-04-13 22:11:23 --> 404 Page Not Found: /index
ERROR - 2023-04-13 22:43:34 --> 404 Page Not Found: /index

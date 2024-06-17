SELECT IFNULL(CONCAT("https://www.niletechinnovations.com/projects/ocory/uploads/profile_image/", `u`.`user_id`, "/", u.avatar), " ") as profile_pic, IFNULL(CONCAT("https://www.niletechinnovations.com/projects/ocory/uploads/car_pic/", `u`.`user_id`, "/", u.car_pic), " ") as car_pic, `u`.`user_id`, `u`.`name`, `u`.`email`, `u`.`vehicle_no`, `u`.`latitude`, `u`.`longitude`, `u`.`vehicle_info`, (((acos(sin((28.5355161*pi()/180)) *
      sin((`latitude`*pi()/180))+cos((28.5355161*pi()/180)) *
      cos((`latitude`*pi()/180)) * cos(((77.3910265-
      `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 
      as distance, `u`.`mobile`, `u`.`user_id` as `driver_id`, (select COUNT(driver_id) from rides where driver_id=u.user_id and status="COMPLETED" group by driver_id limit 1) as total_driver_ride, (select SUM(rating) from feedback where driver_id=u.user_id group by driver_id limit 1) as total_rating, 2 as `is_destination_ride`
FROM `users` `u`
INNER JOIN `vehicle_detail` `vd` ON `vd`.`user_id`=`u`.`user_id`
WHERE `u`.`utype` = 2
AND `u`.`is_online` = 1
AND `vd`.`status` = 1
AND `vehicle_type_id` = 1
HAVING `distance` <= 300000
ORDER BY `distance` asc
 LIMIT 3
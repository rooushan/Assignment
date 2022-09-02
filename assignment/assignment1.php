<?php
/* Author: Roushan
Date: 02-09-22
Version: 1.0
Description: This file consists of php code to get a response from API and store it in DB.
Run this file every 10 sec using Cron Job.


Note: The data we are getting for price, accessibility are in float so the actual table structure should be as below.
However we should also include ID column as primary key as well.
CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activity` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `participants` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `key` varchar(100) DEFAULT NULL,
  `accessibility` float DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
*/
include('connection.php');
$url = "http://www.boredapi.com/api/activity";
//Initialise the Curl
$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	if (curl_errno($ch)) { // If curl exicution fails print error
		$error_msg = curl_error($ch);
		echo $error_msg;
		die;
	}else{
		$result = json_decode($response,true);
	}
curl_close($ch); //Close Curl connection

//Check if response is not empty
if(!empty($result)){
		//converting results into query format
		$columns = implode(", ",array_keys($result));
		$escaped_values = array_map(array($conn, 'real_escape_string'), array_values($result));
		$values  = implode("', '", $escaped_values);
		$values = "'".$values."'";

		//Create SQL query
		$sql = "INSERT INTO `activities` (`activity`, `type`, `participants`, `price`, `link`, `key`, `accessibility`) VALUES (".$values.") ";
		//If query exicuted successfully print success message or print error message
		if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
		} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		}
}
?>




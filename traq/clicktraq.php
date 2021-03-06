<?php
/**
 * ClickTraq
 *
 * @author Carl Saggs
 * @license MIT
 */

// Set script to stay running, then close the connection so we don't keep the browser waiting
ignore_user_abort(true); 
header("Content-Length: 0");
header("Connection: close");
flush();

// Get config
include("../config/config.php");

// Get raw input since we basically just dumped a JSON string in to the post request
$request = json_decode(file_get_contents('php://input'));

// Die if unable to read data
if(!$request) die();

// Connect to DB
try {
    $db = new PDO($config['dsn'], $config['user'], $config['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
	die("DB error.");
}



// Shovel it in to DB
$q = $db->prepare("INSERT INTO page_profiles (webpage, time, screen_resolution, platform, user_agent, total_clicks, visit_duration, clicks) VALUES (?,?,?,?,?,?,?,?)");
$q->execute(array(
	$request->webpage,
	time(),
	$request->screen_resolution,
	$request->platform,
	$request->user_agent,
	$request->total_clicks,
	$request->visit_duration,
	json_encode($request->clicks)
));





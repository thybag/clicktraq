<?php

//http://codeflow.org/entries/2013/feb/04/high-performance-js-heatmaps/
$request_body = file_get_contents('php://input');

$config = array(
	'dsn' 	=> 'mysql:dbname=clicktraq;host=localhost',
	'user' 	=> '',
	'password' 	=> ''
);

// Connect to DB
try {
    $db = new PDO($config['dsn'], $config['user'], $config['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
	die("DB error.");
}
// read JSON response
$request = json_decode($request_body);

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


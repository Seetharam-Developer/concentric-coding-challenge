<?php

include_once 'Request.php';
include_once 'Router.php';
include_once 'Db.php';
header('Content-Type: application/json');
date_default_timezone_set("America/New_York");

$router = new Router(new Request);

$router->post('/jobs', function($request) {
  $db = new Db();
  $jobId=$db->insertJob($request->getBody());
  return json_encode(array('jobId'=>$jobId));
});

$router->get('/jobs/next', function($request) {
  $db = new Db();
  return json_encode($db->getNextJob());
});

$router->delete('/jobs/next', function($request) {
  $db = new Db();
  $db->deleteNextJob();
});

$router->patch('/jobs/next', function($request) {
  $db = new Db();
  return json_encode($db->processNextJob($request->getBody()));
});

/**
 * REGEX for matching /jobs/{id}
 * \/jobs\/[0-9]{1,6}
 * */

$re = "/\/jobs\/[0-9]{1,6}$/ms";
$str = $_SERVER['REDIRECT_URL'];
if(preg_match($re, $str) && strcmp("DELETE",$_SERVER["REQUEST_METHOD"])==0){
  $db = new Db();
  $db->deleteProcessingJobById(explode("/",$str)[2]);
}

?>


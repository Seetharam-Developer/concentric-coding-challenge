<?php

/**
 * Puts a job back in the queue if not processed within 30 seconds
 */
include_once 'Db.php';
date_default_timezone_set("America/New_York");
$db = new Db();
$db->restoreFailedProcessingJobs();
?>
<?php
class Db{

    private $db = array(
        'server' => 'localhost',
        'username' => 'jobs_user',
        'password' => 'QikNlB0d1NBrv1iX',
        'dbname' => 'jobs_db',
        'port' => 3306
    );
    private $conn;

    /**
     * Initiate a new DB connection and store in the class variable $conn
     */
    function __construct()
    {
        $this->conn = new mysqli($this->db['server'], $this->db['username'], $this->db['password'],$this->db['dbname']);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    /**
     * Inserts into jobs_queue database with /jobs/ post request
     * return the new jobId, else return -1 if failed
     */
     function insertJob($data){
        $sql= "INSERT INTO `jobs_queue`
         (`submitterId`, `priority`, `name`) 
         VALUES 
         (".$data['submitterId'].",".$data['priority'].",'".$data['name']."')";
         
        if($this->conn->query($sql) == TRUE){
            return $this->conn->insert_id;
        }else {
            return -1;
          }
    }

    /**
     * Fetches the next job with the lowest priority
     * incase of tie, the oldest entry is returned
     */
     function getNextJob(){
        $sql = "SELECT * FROM jobs_db.jobs_queue where status='waiting' order by priority ASC LIMIT 1";
        $result = $this->conn->query($sql);
        if($result->num_rows>0){
            $row = $result->fetch_assoc();
            return array('jobId'=>$row['jobId'],
                            'submitterId' => $row['submitterId'],
                            'priority' => $row['priority'],
                            'name' => $row['name']);
        }else {
            return -1;
          }
    }

    /**
     * Removes the next job in the queue with the lowest priority
     * incase of tie, removes the oldest entry
     */
    function deleteNextJob(){
        $nextjobId=$this->getNextJob()['jobId'];
        $sql = "DELETE FROM jobs_db.jobs_queue WHERE jobId = $nextjobId AND status='waiting'";
        $result = $this->conn->query($sql);
    }

    /**
     * Stage 3: updates the next waiting job status to processing with latest timestamp
    */
    function processNextJob($payload){
        if(strcmp('{"status":"processing"}',$payload)==0){
            $nextJob = $this->getNextJob();
            $nextJobId = $nextJob['jobId'];
            $currenttimestamp = date("Y-m-d H:i:s");
            $sql= "UPDATE jobs_db.jobs_queue SET status='processing', lastUpdated='$currenttimestamp' WHERE jobId=$nextJobId";
            $result = $this->conn->query($sql);
            return $nextJob;   
        }
    }

    /**
     * Delete a processing job by Id
     */
    function deleteProcessingJobById($id){
        $sql = "DELETE FROM jobs_db.jobs_queue WHERE jobId = $id AND status='processing'";
        $result = $this->conn->query($sql);
    }

    /**
     * Update the status of processing jobs to waiting if last updated was more than 30 seconds 
     * to the current timestamp
     */
    function restoreFailedProcessingJobs(){
        echo 'Restoring any failed processing jobs';
        $currenttime = strtotime(date("Y-m-d H:i:s"));
        $currenttimestamp = date("Y-m-d H:i:s");
        $timeout = date("Y-m-d H:i:s", strtotime("-30 Seconds", $currenttime));
        $sql = "UPDATE jobs_db.jobs_queue SET status='waiting', lastUpdated='$currenttimestamp' 
                WHERE lastUpdated < '$timeout' AND status='processing'";
        $result = $this->conn->query($sql);
        return $result;
    }

}

?>
<?php
Class Database
{
    private $user ;
    private $host;
    private $pass ;
    private $db;

    public function __construct()
    {

        $this->user = "PZJpDxgsGWEAiKdn";
        $this->host = "remote.fizzmod.com";
        $this->pass = "HGT3AhyoGiPbyhUslYQl9";
        $this->db   = "db_PZJpDxgsGWEAiKdn";
    }
    /**
     *
     * Method to connect database
     */
    public function connect()
    {
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        return $link;
    }

}

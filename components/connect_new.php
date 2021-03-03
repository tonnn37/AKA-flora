<?php

//--------------
class Crud
{
    public $connect;
    private $host = "localhost";
    private $username = 'root';
    private $password = '';
    private     $database = 'db_ntk';
    function __construct()
    {
        $this->database_connect();
    }
    public function database_connect()
    {
        $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }
    public function execute_query($query)
    {
        return mysqli_query($this->connect, $query);
    }
    /* function upload_file($file)
    {
        if (isset($file)) {
            $extension = explode('.', $file["name"]);
            $new_name = rand() . '.' . $extension[1];
            $destination = './image/' . $new_name;
            copy($file['tmp_name'], $destination);
            //copy($file['tmp_name'], "./bbgun/image/" . $new_name);
            return $new_name;
        }
    } */
}

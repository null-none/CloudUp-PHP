<?php
class CloudUp
{
    private $user;
    private $passwd;
    private $error;
    private $key;
    
    const UPLOAD_URL = 'https://api.cloudup.com/1/';
    
    public function setKey($user, $passwd)
    {
        $this->key = "Content-Type: application/x-www-form-urlencoded \r\n" . "Authorization: Basic " .base64_encode("$user:$passwd");
    }
    
    public function getError()
    {
        return $this->error;
    }
    
    public function createStream($name)
    {
        try {
            $context = stream_context_create(array(
                'http' => array(
                    'method' => "POST",
                    'header' => $this->key,
                    'content' => "title=$name"
                )
            ));
            $data    = file_get_contents(self::UPLOAD_URL."streams", false, $context);
            return (array) json_decode($data);
        }
        catch (Exception $e) {
            $this->setError($e->getMessage());
        }
    }
    
    public function addItem($filename, $stream_id, $title)
    {
        try {
            $context = stream_context_create(array(
                'http' => array(
                    'method' => "POST",
                    'header' => $this->key,
                    'content' => "filename=$filename&stream_id=$stream_id&title=$title"
                )
            ));
            $data = file_get_contents(self::UPLOAD_URL."/items", false, $context);
            return (array) json_decode($data);
        }
        catch (Exception $e) {
            $this->setError($e->getMessage());
        }
    }
    
    public function getItems($stream_id)
    {
        try {
            $context = stream_context_create(array(
                'http' => array(
                    'method' => "GET",
                    'header' => $this->key
                )
            ));
            $data    = file_get_contents(self::UPLOAD_URL."/streams/$stream_id/items", false, $context);
            return (array) json_decode($data);
        }
        catch (Exception $e) {
            $this->setError($e->getMessage());
        }
    }

    private function setError($error)
    {
        $this->error = $error;
    }
}

$user = 'user';
$passwd = 'pass';
$cloud = new CloudUp;
$cloud->setKey($user, $passwd);
$result = $cloud->createStream('browserling');
$stream_id = $result['id'];
$filename = 'browserling.jpg';
$cloud->addItem($filename, $stream_id, 'browserling');
$result = $cloud->getItems($stream_id);
print_r($result);
?>

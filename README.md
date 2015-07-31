# CloudUp-PHP
Class for use Cloudup API.

``` php
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
```

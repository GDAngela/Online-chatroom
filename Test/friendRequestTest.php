<?php
use PHPUnit\Framework\TestCase;
function httpPost($url,$params)
{
  $postData = '';
  //create name value pairs seperated by &
  foreach($params as $k => $v)
  {
    $postData .= $k . '='.$v.'&';
  }
  $postData = rtrim($postData, '&');

  $ch = curl_init();

  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_POST, count($postData));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

  $output=curl_exec($ch);

  curl_close($ch);
  return $output;

}

class chatTest extends TestCase
{
  public function testAddAlreadyFriend(){
    $params = array(
      "type"=>"add",
      "sendFrom"=>"myuser1",
      "sendTo"=>"myuser3"
    );
    $result=httpPost("http://localhost/chatroom/friendRequest.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"err":2}')!==false);
  }

  public function testAddExistingRequest(){
    $params = array(
      "type"=>"add",
      "sendFrom"=>"myuser1",
      "sendTo"=>"myuser2"
    );
    $result=httpPost("http://localhost/chatroom/friendRequest.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"err":2}')!==false);
  }

  public function testAccept(){
    $params = array(
      "type"=>"accept",
      "sendFrom"=>"myuser1",
      "sendTo"=>"myuser2"
    );
    $result=httpPost("http://localhost/chatroom/friendRequest.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"err":0}')!==false);
  }

  public function testgetList(){
    $params = array(
      "type"=>"getList",
      "username"=>"myuser3"
    );
    $result=httpPost("http://localhost/chatroom/friendRequest.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"request":["myuser1"],"requestId":[2]}')!==false);
  }





}

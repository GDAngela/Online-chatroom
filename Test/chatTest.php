<?php
use PHPUnit\Framework\TestCase;

//Citation:this function is from http://hayageek.com/php-curl-post-get/
function httpPost($url,$params)
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
  public function testKeyWord(){
    $params = array(
      "word"=>"kk"
    );
    $result=httpPost("http://localhost/chatroom/chat.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"User":"User1","Id":8,"Text":"kkk","Time":"2016-11-03 01:20:28"}')!==false);
  }

  public function testHistory(){
    $params = array(
      "action"=>"history"
    );
    $result=httpPost("http://localhost/chatroom/chat.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"User":"User1","Id":"1","Text":"cds","Time":"2016-11-03 00:29:51"},{"User":"User1","Id":"2","Text":"qq","Time":"2016-11-03 00:48:17"},{"User":"User1","Id":"3","Text":"ooo","Time":"2016-11-03 00:54:31"},{"User":"User1","Id":"4","Text":"eee","Time":"2016-11-03 00:55:35"},{"User":"User1","Id":"5","Text":"rrrrr","Time":"2016-11-03 00:58:55"},{"User":"User1","Id":"6","Text":"dddd","Time":"2016-11-03 01:20:08"},{"User":"User1","Id":"7","Text":"wwwww","Time":"2016-11-03 01:20:15"},{"User":"User1","Id":"8","Text":"kkk","Time":"2016-11-03 01:20:28"},{"User":"User1","Id":"9","Text":"bbbbbbbbbbbbb","Time":"2016-11-03 01:20:43"},{"User":"User1","Id":"10","Text":"rrrrr","Time":"2016-11-03 01:20:55"},{"User":"User1","Id":"11","Text":"jjj","Time":"2016-11-03 01:37:56"}')!==false);
  }

  public function testInsertMessage(){
    $params = array(
      "message"=>"haha"
    );
    httpPost("http://localhost/chatroom/chat.php",$params);
    $params1 = array(
      "action"=>"history"
    );
    $result=httpPost("http://localhost/chatroom/chat.php",$params1);
    $this->assertEquals(true,strpos($result,'"Text":"haha"')!==false);
  }
  public function testEmptyMessage(){
    $params = array(
      "message"=>""
    );
    httpPost("http://localhost/chatroom/chat.php",$params);
    $params1 = array(
      "action"=>"history"
    );
    $result=httpPost("http://localhost/chatroom/chat.php",$params1);
    $this->assertEquals(true,strpos($result,'"Text":""')==false);
  }



}

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
  public function testRightUserandPassword(){
    $params = array(
      "type"=>"login",
      "username1"=>"user1",
      "password1"=>"111"
    );
    $result=httpPost("http://localhost/chatroom/loginSignup.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"err":0,"username":"user1","contacts":["user2","user3","user4"]}')!==false);
  }

  public function testincorrectpassword(){
    $params = array(
      "type"=>"login",
      "username1"=>"user1",
      "password1"=>"112"
    );
    $result=httpPost("http://localhost/chatroom/loginSignup.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'"err":1')!==false);
  }

  public function testNoUser(){
    $params = array(
      "type"=>"login",
      "username1"=>"user11",
      "password1"=>"112"
    );
    $result=httpPost("http://localhost/chatroom/loginSignup.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'"err":2')!==false);
  }

  public function testEmptyFeild(){
    $params = array(
      "type"=>"login",
      "username1"=>"",
      "password1"=>"112"
    );
    $result=httpPost("http://localhost/chatroom/loginSignup.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'"err":-1')!==false);
  }

  public function testDuplicateSignUp(){
    $params = array(
      "type"=>"signin",
      "username2"=>"UUAA",
      "password2"=>"u"
    );
    $result=httpPost("http://localhost/chatroom/loginSignup.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'"err":1')!==false);
  }

  public function testEmptySignUp(){
    $params = array(
      "type"=>"signin",
      "username2"=>"",
      "password2"=>"u"
    );
    $result=httpPost("http://localhost/chatroom/loginSignup.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'"err":-1')!==false);
  }





}

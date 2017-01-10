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
  public function testRecentChatroom(){
    $params = array(
      "username"=>"user1",
    );
    $result=httpPost("http://localhost/chatroom/recentChatroom.php",$params);
    //echo $result;
    $this->assertEquals(true,strpos($result,'{"chatroomId":[4,2,3,1],"chatwith":[["user5"],["user3"],["user4"],["user2"]]}')!==false);
  }
}

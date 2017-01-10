<?php
$con = mysqli_connect("localhost","root","","Chatroom");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function clean_data($data){
  $data=trim($data);
  //Convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities:
  $data=htmlspecialchars($data);
  return $data;
}

function encodeData($sql){
  //transfer information in resulting table into $comments
  //citation:http://stackoverflow.com/questions/750648/select-from-in-mysqli

  $meta = $sql->result_metadata();
  while ($field = $meta->fetch_field()) {
    $parameters[] = &$row[$field->name];
  }
  call_user_func_array(array($sql, 'bind_result'), $parameters);
  $data = array();
  while ($sql->fetch()) {
    foreach($row as $key => $val) {
      $x[$key] = $val;
    }
    $data[] = $x;
  }
  return $data;
}

//select most
if(!empty($_POST['username'])){
  $username=$_POST['username'];
  $data['chatroomId']=array();
  $data['chatwith']=array();
  $list=array();
  $sql=mysqli_prepare($con,"SELECT * FROM Messages WHERE Username=? ORDER BY Time DESC");
  mysqli_stmt_bind_param($sql,"s",$username);
  mysqli_stmt_execute($sql);
  $result=encodeData($sql);
  mysqli_stmt_close($sql);

  if(count($result)!=0){
    foreach ($result as $row) {
      array_push($list,$row['ChatroomId']);
    }
  }
  //get rid of duplicate
  $list=array_unique($list);

  //only get value
  $list=array_values($list);

  //get min
  $numberOfChatroom=min(count($list),5);
  //find out who are in each chatroom

  for ($x = 0; $x <$numberOfChatroom; $x++) {
    array_push($data['chatroomId'],$list[$x]);
    $sql=mysqli_prepare($con,"SELECT * FROM UserInChatroom WHERE ChatroomId=?");
    mysqli_stmt_bind_param($sql,"i",$list[$x]);
    mysqli_stmt_execute($sql);
    $res=encodeData($sql);
    if(count($res)!=0){
      $temparray=array();
      foreach ($res as $row) {
        if($row['Username']!=$username){
          array_push($temparray,$row['Username']);
        }
      }
    }
    $data['chatwith'][$x]=$temparray;
  }

  $con->close();

  echo json_encode($data);

}

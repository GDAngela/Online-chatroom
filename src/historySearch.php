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


//get history
if(!empty($_POST['type']) && $_POST['type']=="history"){
  $chatroomId=$_POST['chatRoomId'];
  $data['username']=array();
  $data['message']=array();
  $data['time']=array();
  $sql=mysqli_prepare($con,"SELECT * FROM Messages WHERE ChatroomId=? ORDER BY Time ASC");
  mysqli_stmt_bind_param($sql,"i",$chatroomId);
  mysqli_stmt_execute($sql);
  $result=encodeData($sql);
  mysqli_stmt_close($sql);
  if(count($result)!=0){
    foreach ($result as $row) {
      array_push($data['username'],$row['Username']);
      array_push($data['message'],$row['Text']);
      array_push($data['time'],$row['Time']);
    }
  }


  echo json_encode($data);
  $con->close();
}


//search key word
if(!empty($_POST['type']) && $_POST['type']=="search"){
  $chatroomId=$_POST['chatRoomId'];
  $word=clean_data($_POST['key']);
  $data['err']=-1;
  if($word!=""){
    $data['err']=0;
    $data['username']=array();
    $data['message']=array();
    $data['time']=array();

    $param = "%{$word}%";
    $sql=mysqli_prepare($con,"SELECT * FROM Messages WHERE ChatroomId=? AND Text LIKE ?");
    mysqli_stmt_bind_param($sql,"is",$chatroomId,$param);
    mysqli_stmt_execute($sql);
    $result=encodeData($sql);
    mysqli_stmt_close($sql);

    if(count($result)!=0){
      foreach ($result as $row) {
        array_push($data['username'],$row['Username']);
        array_push($data['message'],$row['Text']);
        array_push($data['time'],$row['Time']);
      }
    }
    $con->close();
  }
  echo json_encode($data);
}

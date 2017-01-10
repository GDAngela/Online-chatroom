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


//insert into database
if(!empty($_POST['message']) && !empty($_POST['currentUser']) && !empty($_POST['chatroom'])){
  // get message
  $message=$_POST['message'];
  $message=clean_data($message);
  $currentuser=$_POST['currentUser'];
  $roomnumber=$_POST['chatroom'];
  if($message!="" && $roomnumber!=0){
  //prepared statement
    $sql=mysqli_prepare($con,"INSERT INTO Messages (Username,ChatroomId, Text) VALUES (?,?,?)");
    mysqli_stmt_bind_param($sql,"sis",$currentuser,$roomnumber,$message);
    $result=mysqli_stmt_execute($sql);
    mysqli_stmt_close($sql);
    //$con->close();
    echo json_encode($result); 
  }
}


?>

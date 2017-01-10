<?php
$con = mysqli_connect("localhost","root","","Chatroom");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
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

if(!empty($_POST['currentUser']) && !empty($_POST['chatwith'])){
  $currentuser=$_POST['currentUser'];
  $chatwith=$_POST['chatwith'];
  $data[0]=-1;
  //select chatrooms with currentuser
  $sql=mysqli_prepare($con,"SELECT ChatroomId FROM UserInChatroom WHERE Username IN (?, ?) GROUP BY ChatroomId HAVING COUNT(*) = 2");
  mysqli_stmt_bind_param($sql,"ss",$currentuser,$chatwith);
  mysqli_stmt_execute($sql);
  $result1=encodeData($sql);
  mysqli_stmt_close($sql);

  if(count($result1)==0){
    //calculate chatroom id
    $sql=mysqli_prepare($con,"SELECT COUNT(*) FROM Chatrooms");
    mysqli_stmt_execute($sql);
    $number=encodeData($sql)[0]['COUNT(*)']+1;
    mysqli_stmt_close($sql);
    $chatroomfile="chat"."$number".".txt";
    //insert new chatroom
    $sql1=mysqli_prepare($con,"INSERT INTO Chatrooms (ChatroomId,Name,NumberOfUser) VALUES (?,?,?)");
    $NumberOfUser=2;
    mysqli_stmt_bind_param($sql1,"isi",$number,$chatroomfile,$NumberOfUser);
    mysqli_stmt_execute($sql1);
    mysqli_stmt_close($sql1);
    //insert 2 new relation into UserInChatroom
    $sql2=mysqli_prepare($con,"INSERT INTO UserInChatroom (Username,ChatroomId) VALUES (?,?)");
    mysqli_stmt_bind_param($sql2,"si",$currentuser,$number);
    mysqli_stmt_execute($sql2);

    mysqli_stmt_bind_param($sql2,"si",$chatwith,$number);
    mysqli_stmt_execute($sql2);
    mysqli_stmt_close($sql2);

    $data[0]=$number;


  }else{
    foreach($result1 as $row) {
      $roomId=$row['ChatroomId'];
      $sql=mysqli_prepare($con,"SELECT NumberOfUser FROM Chatrooms Where ChatroomId=?");
      mysqli_stmt_bind_param($sql,"i",$roomId);
      mysqli_stmt_execute($sql);
      $result=encodeData($sql);
      mysqli_stmt_close($sql);
      //check if this chat room only has those two users
      if($result[0]['NumberOfUser']==2){
        $data[0]=$roomId;
        break;
      }
    }
  }

  echo json_encode($data);
  $con->close();

}

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

if(!empty($_POST['type']) && $_POST['type']=="getFriendList"){
  $username=$_POST['username'];
  $data=array();
  $data['friendList']=array();
  if($username!=""){
    //get friend list
    $sql=mysqli_prepare($con,"SELECT* FROM Friendship WHERE Username1=?");
    mysqli_stmt_bind_param($sql,"s",$username);
    mysqli_stmt_execute($sql);
    $result=encodeData($sql);
    mysqli_stmt_close($sql);


    if(count($result)!=0){
      foreach ($result as $row) {
        array_push($data['friendList'],$row['Username2']);
      }
    }

    $con->close();
  }
  echo json_encode($data);

}

//get list of people in current chatroom
if(!empty($_POST['type']) && $_POST['type']=="getPeopleInRoom"){
  $roomId=$_POST['roomId'];
  $data=array();
  $data['peopleInCurrentRoom']=array();
  $sql=mysqli_prepare($con,"SELECT * FROM UserInChatroom WHERE ChatroomId=?");
  mysqli_stmt_bind_param($sql,"i",$roomId);
  mysqli_stmt_execute($sql);
  $res=encodeData($sql);
  if(count($res)!=0){
    foreach ($res as $row) {
        array_push($data['peopleInCurrentRoom'],$row['Username']);

    }
    $con->close();
  }
  echo json_encode($data);

}

//add new friends to current chatroom update userinchatroom and insert newchatroom
if(!empty($_POST['type']) && $_POST['type']=="addMoreFriends"){
  $list=$_POST['friendlist'];
  $currentchatroom=$_POST['roomId'];
  $data=array();
  //get who's in current room
  $sql=mysqli_prepare($con,"SELECT * FROM UserInChatroom WHERE ChatroomId=?");
  mysqli_stmt_bind_param($sql,"i",$currentchatroom);
  mysqli_stmt_execute($sql);
  $res=encodeData($sql);
  if(count($res)!=0){
    foreach ($res as $row) {
        array_push($list,$row['Username']);

    }
  }

  //calculate chatroom id
  $sql=mysqli_prepare($con,"SELECT COUNT(*) FROM Chatrooms");
  mysqli_stmt_execute($sql);
  $number=encodeData($sql)[0]['COUNT(*)']+1;
  mysqli_stmt_close($sql);
  $chatroomfile="chat"."$number".".txt";
  //insert new chatroom
  $sql1=mysqli_prepare($con,"INSERT INTO Chatrooms (ChatroomId,Name,NumberOfUser) VALUES (?,?,?)");
  $NumberOfUser=count($list);
  mysqli_stmt_bind_param($sql1,"isi",$number,$chatroomfile,$NumberOfUser);
  mysqli_stmt_execute($sql1);
  mysqli_stmt_close($sql1);

  foreach ($list as $row) {
    //insert  new relation into UserInChatroom
    $sql2=mysqli_prepare($con,"INSERT INTO UserInChatroom (Username,ChatroomId) VALUES (?,?)");
    mysqli_stmt_bind_param($sql2,"si",$row,$number);
    mysqli_stmt_execute($sql2);
    mysqli_stmt_close($sql2);
  }

  $data['list']=$list;
  $data['roomId']=$number;
  echo json_encode($data);
}

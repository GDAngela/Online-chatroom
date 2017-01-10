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

//insert friendrequest request into database
if(!empty($_POST['type']) && $_POST['type']=="add"){
  // get message
  $sendFrom=$_POST['sendFrom'];
  $sendTo=clean_data($_POST['sendTo']);
  $result['err']=-1;
  if($sendTo!="" && $sendFrom!=$sendTo){

    //check if request exists
    $sql=mysqli_prepare($con,"SELECT * FROM Friendrequest WHERE sendFrom=? AND sendTo=?");
    mysqli_stmt_bind_param($sql,"ss",$sendFrom,$sendTo);
    mysqli_stmt_execute($sql);
    $result1=encodeData($sql);
    mysqli_stmt_close($sql);
    //other direction
    $sql=mysqli_prepare($con,"SELECT * FROM Friendrequest WHERE sendFrom=? AND sendTo=?");
    mysqli_stmt_bind_param($sql,"ss",$sendTo,$sendFrom);
    mysqli_stmt_execute($sql);
    $result2=encodeData($sql);
    mysqli_stmt_close($sql);

    //check if they are already friend
    $sql=mysqli_prepare($con,"SELECT * FROM Friendship WHERE Username1=? AND Username2=?");
    mysqli_stmt_bind_param($sql,"ss",$sendTo,$sendFrom);
    mysqli_stmt_execute($sql);
    $result3=encodeData($sql);
    mysqli_stmt_close($sql);


    if(count($result1)==0 && count($result2)==0 && count($result3)==0){
      //insert
      $result['err']=0;
      $sql=mysqli_prepare($con,"INSERT INTO Friendrequest (sendFrom,sendTo) VALUES (?,?)");
      mysqli_stmt_bind_param($sql,"ss",$sendFrom,$sendTo);
      $success=mysqli_stmt_execute($sql);
      mysqli_stmt_close($sql);
      $con->close();
    }else{
      //existing request
      $result['err']=2;
    }
  }
  echo json_encode($result);
}

//accepted or rejeccted request delete from table
if(!empty($_POST['type']) && ($_POST['type']=="accept" || $_POST['type']=="reject")){
  $sendFrom=$_POST['sendFrom'];
  $sendTo=$_POST['sendTo'];
  $data['err']=0;
  //DELETING FROM TABLE
  $sql=mysqli_prepare($con,"DELETE FROM Friendrequest WHERE sendFrom=? AND sendTo=?");
  mysqli_stmt_bind_param($sql,"ss",$sendFrom,$sendTo);
  $success1=mysqli_stmt_execute($sql);
  mysqli_stmt_close($sql);
  if($success1==False){
    $data['err']=1;
  }

  if($_POST['type']=="accept"){
    //if accept add two rows to friendship
    $sql=mysqli_prepare($con,"INSERT INTO Friendship (Username1,Username2) VALUES (?,?)");
    mysqli_stmt_bind_param($sql,"ss",$sendFrom,$sendTo);
    $success2=mysqli_stmt_execute($sql);
    mysqli_stmt_close($sql);
    if($success1==False){
      $data['err']=2;
    }

    $sql=mysqli_prepare($con,"INSERT INTO Friendship (Username1,Username2) VALUES (?,?)");
    mysqli_stmt_bind_param($sql,"ss",$sendTo,$sendFrom);
    $success3=mysqli_stmt_execute($sql);
    mysqli_stmt_close($sql);
    if($success1==False){
      $data['err']=3;
    }
  }
  $con->close();
  echo json_encode($data);

}



//get list of request
if(!empty($_POST['type']) && $_POST['type']=="getList" && !empty($_POST['username'])){
  $username=$_POST['username'];
  $data=array();
  $data['request']=array();
  $data['requestId']=array();
  $sql=mysqli_prepare($con,"SELECT * FROM Friendrequest WHERE sendTo=?");
  mysqli_stmt_bind_param($sql,"s",$username);
  mysqli_stmt_execute($sql);
  $result=encodeData($sql);
  mysqli_stmt_close($sql);

  if(count($result)!=0){
    foreach ($result as $row) {
      array_push($data['request'],$row['sendFrom']);
      array_push($data['requestId'],$row['requestId']);
    }
  }
  $con->close();
  echo json_encode($data);

}

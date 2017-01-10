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



if($_POST['type']=='login'){
  $username=clean_data($_POST['username1']);
  $password=$_POST['password1'];
  $data=array();
  //username is empty
  $data['err']=-1;
  $data['username']="";
  $data['contacts']=array();
  $data['online']=array();
  if($username!=""){
    //username is not empty and username ,password matches
    $data['err']=0;
    //find password to database
    $sql=mysqli_prepare($con,"SELECT Password FROM Users WHERE Username=?");
    mysqli_stmt_bind_param($sql,"s",$username);
    mysqli_stmt_execute($sql);
    $result=encodeData($sql);
    mysqli_stmt_close($sql);

    //check password
    if(count($result)!=0){
      if(strcmp ($result[0]['Password'],$password)!=0){
        //wrong password
        $data['err']=1;
      }else{
        //set it online
        $sql=mysqli_prepare($con,"UPDATE Users SET Status='on' WHERE Username=?");
        mysqli_stmt_bind_param($sql,"s",$username);
        mysqli_stmt_execute($sql);
        mysqli_stmt_close($sql);


        //get all contact
        $sql=mysqli_prepare($con,"SELECT* FROM Friendship WHERE Username1=?");
        mysqli_stmt_bind_param($sql,"s",$username);
        mysqli_stmt_execute($sql);
        $result=encodeData($sql);
        mysqli_stmt_close($sql);
        if(count($result)!=0){
          foreach ($result as $row) {
            array_push($data['contacts'],$row['Username2']);
          }
        }

        //check who's online--------------------------------------------
        foreach($data['contacts'] as $user){
          $sql=mysqli_prepare($con,"SELECT* FROM Users WHERE Username=?");
          mysqli_stmt_bind_param($sql,"s",$user);
          mysqli_stmt_execute($sql);
          $result=encodeData($sql);
          if($result[0]['Status']=="on"){
            array_push($data['online'],$user);
          }
        }
      }

    }else{
      //no such user
      $data['err']=2;
    }
    $data['username']=$username;


    $con->close();
  }

  echo json_encode($data);
}

if($_POST['type']=='signin'){
  $username=clean_data($_POST['username2']);
  $password=htmlspecialchars($_POST['password2']);
  $status="on";
  $data=array();
  $data['err']=-1;
  $data['username']="";

  if($username!="" && $password!=""){
    //both are non empty
    $data['err']=0;
    //insert to database
    $sql=mysqli_prepare($con,"INSERT INTO Users (Username,password,Status) VALUES (?,?,?)");
    mysqli_stmt_bind_param($sql,"sss",$username,$password,$status);
    $success=mysqli_stmt_execute($sql);
    mysqli_stmt_close($sql);
    $con->close();
    if($success==False){
      $data['err']=1;
    }
    $data['username']=$username;
  }
  echo json_encode($data);
}


//when users goes offline set status to off--------------------------------
if($_POST['type']=='offline'){
  $username=clean_data($_POST['username']);
  $sql=mysqli_prepare($con,"UPDATE Users SET Status='off' WHERE Username=?");
  mysqli_stmt_bind_param($sql,"s",$username);
  mysqli_stmt_execute($sql);
  mysqli_stmt_close($sql);

}

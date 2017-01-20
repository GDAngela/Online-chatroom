<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Chatroom</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <!-- http://bootdey.com/snippets/view/chat-room   chatroom styling -->
  <div class="container-fluid">
    <div class="jumbotron">
      <h1> Chatroom</h1>
    </div>
  </div>

  <!-- http://bootsnipp.com/snippets/featured/login-amp-signup-forms-in-panel  login signup styling -->
  <!--sign in  sign up box dispear after sign in or sign up-->
  <div id="signuploginbox" class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

      <div class="panel panel-info" >
        <div class="panel-heading">
          <div class="panel-title">Sign In</div>
        </div>

        <div style="padding-top:30px" class="panel-body" >

          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

          <div id="loginalert" style="display:none" class="alert alert-danger">

          </div>

          <form id="loginform" class="form-horizontal" role="form">

            <div style="margin-bottom: 25px" class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input id="username1" type="text" class="form-control" name="username1" value="" placeholder="username or email">
            </div>

            <div style="margin-bottom: 25px" class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input id="password1" type="password" class="form-control" name="password1" placeholder="password">
            </div>


            <div style="margin-top:10px" class="form-group">
              <div class="col-sm-12 controls">
                <a id="btn-login" onClick="userLogIn()"  href="#" class="btn btn-success">Login  </a>
              </div>
            </div>


            <div class="form-group">
              <div class="col-md-12 control">
                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                  Don't have an account!
                  <!--switch to sign up box -->
                  <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                    Sign Up Here
                  </a>
                </div>
              </div>
            </div>
          </form>



        </div>
      </div>
    </div>
    <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
      <div class="panel panel-info">
        <div class="panel-heading">
          <div class="panel-title">Sign Up</div>
          <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
        </div>
        <div class="panel-body" >

          <div id="signupalert" style="display:none" class="alert alert-danger">

          </div>
          <form id="signupform" class="form-horizontal" role="form">


            <div class="form-group">
              <label for="username" class="col-md-3 control-label">Username</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="username2" name="username2" placeholder="Username">
              </div>
            </div>


            <div class="form-group">
              <label for="password" class="col-md-3 control-label">Password</label>
              <div class="col-md-9">
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Password">
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-offset-3 col-md-9">
                <!--switch to log in box box -->
                <button id="btn-signup" type="button" onClick="userSignUp()" class="btn btn-info"><i class="icon-hand-right"></i> Sign Up</button>
              </div>
            </div>
          </form>
        </div>


      </div>
    </div>

  </div>

  <!--chat box container only show after sign in or sign up -->
  <div id="chatBox" style="display:none"; class="container bootstrap snippet">
    <div class="row">
      <div class="col-md-4 bg-white ">


        <div class="panel-footer">
          <form action="#" class="form-horizontal">
            <div class="form-group has-feedback no-margin">
              <input class="form-control" type="text" id="friendRequestName" name="friendRequestName" value="" placeholder="Enter friend's username">
              <button type="button" class="btn btn-success no-rounded" onclick="addFriend()">Add friend</button>
            </div>
          </form>
        </div>

        <!-- navigation bar -->
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <ul class="nav navbar-nav">
              <li id="contactbar" class="myBar active"><a href="#">Contacts</a></li>
              <li id="chatroombar" class="myBar"><a href="#">Chatroom</a></li>
              <li id="friendRequestbar" class="myBar"><a href="#">Friendrequest</a></li>
            </ul>
         </div>
       </nav>

        <ul class="friend-list" id="contactlist" >

        </ul>

        <ul class="friend-list" id="chatroomlist" style="display:none">
          <p>chatroom</p>
        </ul>

        <div class="table-responsive" id="friendRequestlist" style="display:none">
          <table class="table user-list">
            <thead>
              <tr>
                <th><span>User</span></th>
                <th>&nbsp;</th>
              <tr>
            </thead>
            <tbody id="requestlist">

            </tbody>
          </table>
        </div>

        <div id="friendNotification">

        </div>

      </div>
      <div class="col-md-8 bg-white ">
        <!-- key word search and history-->
        <nav class="navbar navbar-default"  id="navMenu" style="display:none">
          <div class="container-fluid">
            <ul class="nav navbar-nav">
            <button id="historyButton" type="button" class="btn btn-info btn-lg" onclick="historyOnclick()">History</button>


            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" id="searchkey" name="searchkey" value="" placeholder="Search">
              </div>
              <button id="searchButton" type="button" class="btn btn-default" onclick="searchKeyOnClick()">Submit</button>
            </form>

            <!-- button for add more friend to chatroom -->
              <button id="addMore" type="button" class="btn btn-info btn-lg" onclick="addMore()">Add More</button>

            <!-- -->

            <form  enctype="multipart/form-data">
              <input type="file"  name="fileToUpload" id="fileToUpload">
            </form>
            <button id="Upload" type="button" class="btn btn-info btn-lg" onclick="uploadFile()">Upload</button>
            <img id="output_image"/>
          </ul>
         </div>
       </nav>

       <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">

           <!-- Modal content-->
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title" id="modalType">History</h4>
             </div>
             <div class="modal-body" id="historySearchContent">
             </div>
           </div>

         </div>
       </div>

       <div class="modal fade" id="addMoreModal" role="dialog">
         <div class="modal-dialog">

           <!-- Modal content-->
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title" id="modalType">Options</h4>
             </div>
             <div class="modal-body">

               <div class="form-group"  id="addMoreList">

              </div>
              <button type="button" class="btn btn-success no-rounded" onclick="submitAdd()">Add</button>

             </div>
           </div>

         </div>
       </div>


        <div class="chat-message">
          <ul class="chat" id="chatContent">
          </ul>
        </div>
        <div class="chat-box bg-white">
          <div class="input-group">
            <input class="form-control border no-shadow no-rounded" id="message" name="message" value="" placeholder="Type your message here">
            <span class="input-group-btn">
              <button class="btn btn-success no-rounded" onclick="sendMessage()" type="button">Send</button>
            </span>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script>
  var username="";
  var currentChatroomId=0;
  var map={};
  //create a new WebSocket object.
  var wsUrl = "ws://localhost:9000/server.php";
  var websocket = new WebSocket(wsUrl);
  websocket.binaryType = "arraybuffer";
  //menu item and corrsponding list div id
  var map={"contactbar":"contactlist","chatroombar":"chatroomlist","friendRequestbar":"friendRequestlist"};
  //assign each request item a unique number as id for deleting
  var requestNumber=0;



//*update onbeforeunload
  $(document).ready(function(){
     // connection is open
     websocket.onopen = function(ev) {
       //notify user
       alert("connected");
     }
     //get message from server
     receiveData();
     //error occur
     websocket.onerror	= function(event){
       console.log("Error Occurred");
     };
     //close connection

 	   websocket.onclose = function(event){
       console.log("Connection Closed");

     };

     //notifiy who's offline before the window closes
     window.onbeforeunload = function(e) {
       //set status offline in database
       $.ajax({
         type: "POST",
         url: "logInSignUp.php",
         data: { type:"offline",username: username}
       }).success(function(response){
       })


       //notify other clients user is offline
       var msg={ type:"offline",currentUser: username};
       websocket.send(JSON.stringify(msg));

     };

     //select one list find chatroomid
     contactsOnClick();

     //select chatroom find chatroomid
     chatroomOnclick();

     //change the menu
     navigationOnclick();

     //accept friendrequest onclick
     acceptOnClick();
     //reject friendrequest onclick
     rejectOnclick();

  });



//*upload file
function uploadFile(){
  var file = document.getElementById('fileToUpload').files[0];
  var reader = new FileReader();
  var rawData = new ArrayBuffer();

  reader.loadend = function() {

  }
  reader.onload = function(e) {
    rawData = e.target.result;
    var output = document.getElementById('output_image');
    output.src = rawData;
    var msg={ type:"usermsg",message: rawData ,currentUser: username, chatroom:currentChatroomId};
    websocket.send(JSON.stringify(msg));
    alert("the File has been transferred.")
  }

  reader.readAsBinaryString(file);
}




//*helper to find if an element is in array
function contains(a, obj) {
    for (var i = 0; i < a.length; i++) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}


//* after selected more friends into chatroom send data back to backend add friendships create new chatroom
function submitAdd(){
  $('#addMoreModal').modal('hide');
  //get all content of checklist
  var checkboxes = document.getElementsByName("mycheck");
  var checkboxesChecked = [];
  for (var i=0; i<checkboxes.length; i++) {
     // pick the ones that got selected
     if (checkboxes[i].checked) {
        checkboxesChecked.push(checkboxes[i].value);
        //console.log(checkboxes[i].value);
     }
  }

  $.ajax({
    type: "POST",
    url: "addMore.php",
    data: { type:"addMoreFriends",friendlist: checkboxesChecked, roomId:currentChatroomId}
  }).success(function(response){
    console.log(response);

    var data= $.parseJSON(response);
    var chatwithlist=data['list'];
    var roomId=data['roomId'];
    var chatroomname="With ";
    for (i = 0; i < chatwithlist.length; i++){
      if(chatwithlist[i]!=username){
        chatroomname+=chatwithlist[i]+" ";
      }
    }

    //add to chatroomlist div
    var newElement = document.createElement('li');
    //formated new message
    newElement.innerHTML =
    "<li class='bounceInDown chatroom' id='"+roomId+"'>"+
    "<a href='#' class='clearfix'>"+
    "<img src='http://bootdey.com/img/Content/user_1.jpg' alt='' class='img-circle'>"+
    "<div class='friend-name'>"+
    "<strong>"+chatroomname+"</strong>"+
    "</div>"+
    "<div class='last-message text-muted'>Hello, Are you there?</div>"+
    "</a>"+
    "</li>"
    //append new message
    document.getElementById("chatroomlist").appendChild(newElement);


  })
}

//*chatroom add more friends :get friendlist and list of people in current chatroom and show menu
function addMore(){
  var friendlist=[];
  var peopleInCurrentRoom=[];
  if(username!="" && currentChatroomId!=0){
    $.ajax({
      type: "POST",
      url: "addMore.php",
      data: { type:"getFriendList",username: username}
    }).success(function(response){
      var data = $.parseJSON(response);
      friendlist=data['friendList'];
      console.log(friendlist);
      $.ajax({
        type: "POST",
        url: "addMore.php",
        data: { type:"getPeopleInRoom",roomId: currentChatroomId}
      }).success(function(response){
        var data2 = $.parseJSON(response);
        peopleInCurrentRoom=data2['peopleInCurrentRoom'];
        console.log(peopleInCurrentRoom);

        //list of friend who are not in current chatroom
        var list=[];
        //console.log(friendlist.length);
        for (i = 0; i<friendlist.length; i++){
          var flag=true;
          for (j = 0; j<peopleInCurrentRoom.length; j++){
            if(peopleInCurrentRoom[j]==friendlist[i]){
              flag=false;
              break;
            }
          }
          if(flag==true){
            list.push(friendlist[i]);
          }
        }

        //clean old modal
        $("#addMoreList").empty();
        //append new checklist
        for (i = 0; i<list.length; i++){
          var newElement = document.createElement('div');
          newElement.innerHTML="<div><input name='mycheck' type='checkbox'id='"+list[i]+"' value='"+list[i]+"'> "+list[i]+"</div>";
          document.getElementById("addMoreList").appendChild(newElement);
        }
        //show the modal
        $("#addMoreModal").modal();


      })

    })

  }
}


//*chatroom onclick
function chatroomOnclick(){
  $( "body" ).on( "click", ".chatroom", function(event) {
    var id =$(this).attr('id');
    //inactive all chatroom
    var x=document.getElementsByClassName("bounceInDown chatroom");
    for (var i = 0; i < x.length; i++) {
      x[i].className = 'bounceInDown chatroom';
    }
    //activate the one that has been chosen
    document.getElementById(id).className +=" active";


    var chatroomId = id.replace ( /[^\d.]/g, '' );
    currentChatroomId=chatroomId;
    $('#chatContent').empty();
    document.getElementById("navMenu").style.display ='block';
    console.log("123" + currentChatroomId);
    console.log(map[currentChatroomId]);
    //hide new message alert-------------------------------------------------------
    $("#newmessage"+currentChatroomId).empty();

    //display new message if there is one
    if(map[currentChatroomId].length!=0){
      for (var i = 0; i < map[currentChatroomId].length; i++){
        console.log("here"+map[currentChatroomId][i]);
        var newElement = document.createElement('li');
        //formated new message
        newElement.innerHTML =
        "<li class='left clearfix'>"+
          "<span class='chat-img pull-left'>"+
            "<img src='http://bootdey.com/img/Content/user_3.jpg' alt='User Avatar'>"+
          "</span>"+
          "<div class='chat-body clearfix'>"+
            "<p>"+
              map[currentChatroomId][i]+
            "</p>"+
          "</div>"+
        "</li>"
        //append new message
        document.getElementById("chatContent").appendChild(newElement);
      }
      //reset array
      map[currentChatroomId]=[];
    }
  });
}

//history button
function historyOnclick(){
  console.log(currentChatroomId);
  if(currentChatroomId!=0){
    $.ajax({
      type: "POST",
      url: "historySearch.php",
      data: { type:"history", chatRoomId:currentChatroomId}
    }).success(function(response) {
      console.log(response);
      $("#historySearchContent").empty();
      $("#modalType").text("History");
      var data = $.parseJSON(response);
      var userList=data['username'];
      var messageList=data['message'];
      var timeList=data['time'];
      if(userList.length!=0){
        for (i = 0; i < userList.length; i++){
          var newElement = document.createElement('p');
          newElement.innerHTML="<p>Send from "+userList[i]+" at "+timeList[i]+" : "+messageList[i]+"</p>";
          document.getElementById("historySearchContent").appendChild(newElement);
        }
      }

    })

    $("#myModal").modal();
  }
}

//search key onclick
function searchKeyOnClick(){
  console.log(currentChatroomId);
  var Key=$("#searchkey").val();
  if(currentChatroomId!=0){
    $.ajax({
      type: "POST",
      url: "historySearch.php",
      data: { type:"search", chatRoomId:currentChatroomId ,key:Key}
    }).success(function(response) {
      console.log(response);
      //clean text from last query
      $("#historySearchContent").empty();
      //change the modal heading to search result
      $("#modalType").text("Search Result");
      //clean the search text field
      $("#searchKey").val('');
      var data = $.parseJSON(response);
      var userList=data['username'];
      var messageList=data['message'];
      var timeList=data['time'];
      if(userList.length!=0){
        for (i = 0; i < userList.length; i++){
          var newElement = document.createElement('p');
          newElement.innerHTML="<p>Send from "+userList[i]+" at "+timeList[i]+" : "+messageList[i]+"</p>";
          document.getElementById("historySearchContent").appendChild(newElement);
        }
      }

    })

    $("#myModal").modal();
  }
}

//each contact
function contactsOnClick(){
  $( "body" ).on( "click", ".contacts", function(event) {
    var currFriend =$(this).attr('id');
    //inactive all contact
    var x=document.getElementsByClassName("bounceInDown contacts");
    for (var i = 0; i < x.length; i++) {
      x[i].className = 'bounceInDown contacts';
    }
    //activate the one that has been chosen
    document.getElementById(currFriend).className +=" active";
    $.ajax({
      type: "POST",
      url: "Createchatroom.php",
      data: { currentUser: username, chatwith:currFriend}
    }).success(function(response) {
      var data = $.parseJSON(response);
      //set currentchatroom
      currentChatroomId=data[0];
      //clear chat window
      $('#chatContent').empty();
      console.log(currentChatroomId);



    })
    document.getElementById("navMenu").style.display ='block';
  });
}

//onclick for navigation bar
function navigationOnclick(){
  $( "body" ).on( "click", ".myBar", function(event) {
    var currBar =$(this).attr('id');
    //set all color the same and set all list hidden
    document.getElementById("contactbar").className ="myBar";
    document.getElementById("contactlist").style.display = 'none';

    document.getElementById("chatroombar").className ="myBar";
    document.getElementById("chatroomlist").style.display = 'none';

    document.getElementById("friendRequestbar").className ="myBar";
    document.getElementById("friendRequestlist").style.display = 'none';

    //highlight selected bar and show the selected list
    document.getElementById(currBar).className +=" active";
    if(currBar=="chatroombar"){
      getChatroomList();
    }
    document.getElementById(map[currBar]).style.display = 'block';
    console.log(currBar);
  });
}

//*get chatrooms that current user is in
function getChatroomList(){
  $.ajax({
    type: "POST",
    url: "getChatroom.php",
    data: { username: username}
  }).success(function(response){
      console.log(response);

    $('#chatroomlist').empty();

    var data = $.parseJSON(response);
    var chatroomlist=data['chatroomId'];
    var chatwithlist=data['chatwith'];
    if(chatroomlist.length!=0){
      for (i = 0; i < chatroomlist.length; i++){
        //create array for each chatroom for storing incoming message
        map[chatroomlist[i]]=[];
        //name the chatroom by people who are in the chatroom
        var chatroomname="With ";
        for (j = 0; j < chatwithlist[i].length; j++){
          chatroomname+=chatwithlist[i][j]+" ";
        }
        //add to chatroomlist div
        var newElement = document.createElement('li');
        //formated new message
        newElement.innerHTML =
        "<li class='bounceInDown chatroom' id='"+chatroomlist[i]+"'>"+
        "<a href='#' class='clearfix'>"+
        "<img src='http://bootdey.com/img/Content/user_1.jpg' alt='' class='img-circle'>"+
        "<div class='friend-name'>"+
        "<strong>"+chatroomname+"</strong>"+
        "</div>"+
        "<div class='last-message text-muted'>Hello, Are you there?</div>"+
        "<div id='newmessage"+chatroomlist[i]+"'></div>"+
        "</a>"+
        "</li>"
        //append new message
        document.getElementById("chatroomlist").appendChild(newElement);

      }
      console.log("map is "+map[chatroomlist[i]]);
    }

  })
}


//request list
function getRequestList(){
  $.ajax({
    type: "POST",
    url: "friendRequest.php",
    data: { type:"getList",username: username}
  }).success(function(response){
    console.log(response);

    var data = $.parseJSON(response);
    var request=data['request'];
    var requestId=data['requestId'];
    if(request.length!=0){
      for (i = 0; i < request.length; i++){
        var newElement = document.createElement('tr');
        requestNumber+=1;
        //formated new message
        newElement.innerHTML ="<tr>"+
                                "<td>"+
                                  "<img src='http://bootdey.com/img/Content/user_1.jpg' alt=''>"+
                                    "<a href='#' class='user-link'>"+request[i]+"</a>"+
                                "</td>"+
                                "<td style='width: 40%;'>"+
                                  "<a href='#' class='table-link accept' id='accept"+requestNumber+"' val='"+request[i]+"'>"+
                                    "<span class='fa-stack'>"+
                                      "<i class='fa fa-square fa-stack-2x'></i>"+
                                      "<i class='fa fa-check-circle-o fa-stack-1x fa-inverse'></i>"+
                                    "</span>"+
                                  "</a>"+
                                  "<a href='#' class='table-link reject' id='reject"+requestNumber+"' val='"+request[i]+"'>"+
                                    "<span class='fa-stack'>"+
                                      "<i class='fa fa-square fa-stack-2x'></i>"+
                                      "<i class='fa fa-times-circle-o fa-stack-1x fa-inverse'></i>"+
                                    "</span>"+
                                  "</a>"+
                                "</td>"+
                              "</tr>";
        //set id for this item
        newElement.setAttribute("id", "item"+requestNumber);
        //append new message
        document.getElementById("requestlist").appendChild(newElement);
      }
    }

  })
}

//send friend request
function addFriend(){
  var sendto=$('#friendRequestName').val();
  $.ajax({
    type: "POST",
    url: "friendRequest.php",
    data: { type:"add",sendFrom: username, sendTo: sendto}
  }).success(function(response) {
    $('#friendRequestName').val('');
    console.log(response);
    var data = $.parseJSON(response);
    if(data['err']==0){
      //convert and send data to server
      var msg={ type:"friendRequest",sendFrom: username, sendTo: sendto};
      websocket.send(JSON.stringify(msg));
    }

  })
}

//accept onclick
function acceptOnClick(){
  $( "body" ).on( "click", ".accept", function(event) {
    //get id in the form of "accept"+id
    var itemid =$(this).attr('id');
    console.log("item is "+itemid);
    //it's accpped+id  extract id
    var requestId = itemid.replace ( /[^\d.]/g, '' );
    console.log(requestId);
    //remove this item by id
    $("#item"+requestId).remove();
    //console.log(requestId);
    var sendfrom=$(this).attr('val');

    $.ajax({
      type: "POST",
      url: "friendRequest.php",
      data: { type:"accept",sendFrom:sendfrom,sendTo:username}
    }).success(function(response) {
      console.log("accept");
      console.log(response);
      var newElement = document.createElement('li');
      //add newly accepted friend to contact list
      newElement.innerHTML =
      "<li class='bounceInDown contacts' id='"+sendfrom+"'>"+
      "<a href='#' class='clearfix'>"+
      "<img src='http://bootdey.com/img/Content/user_1.jpg' alt='' class='img-circle'>"+
      "<div class='friend-name'>"+
      "<strong>"+sendfrom+"</strong>"+
      "</div>"+
      "<div class='last-message text-muted'>Online</div>"+
      "</a>"+
      "</li>"
      //append new message
      document.getElementById("contactlist").appendChild(newElement);

      //add new friend to sendFrom
      var msg={ type:"accept",sendFrom: sendfrom, sendTo: username};
      websocket.send(JSON.stringify(msg));
    })

  });
}

//reject onclick
function rejectOnclick(){
  $( "body" ).on( "click", ".reject", function(event) {
    //get id in the form of "reject"+id
    var itemid =$(this).attr('id');
    console.log("item is "+itemid);
    //it's reject+id  extract id
    var requestId = itemid.replace ( /[^\d.]/g, '' );
    console.log(requestId);
    //remove this item by id
    $("#item"+requestId).remove();
    //console.log(requestId);
    var sendfrom=$(this).attr('val');

    $.ajax({
      type: "POST",
      url: "friendRequest.php",
      data: { type:"reject",sendFrom:sendfrom,sendTo:username}
    }).success(function(response) {
      console.log("reject");
      console.log(response);
    })

  });
}

//* onclick for log in add online feature
  function userLogIn(){

    var userName=$('#username1').val();
    var passWord=$('#password1').val();

    $.ajax({
      type: "POST",
      url: "logInSignUp.php",
      data: { type:"login" ,username1: userName, password1: passWord}
    }).success(function(response) {
      //hide alert
      document.getElementById("loginalert").style.display = 'none';
      console.log("here"+response);

      var data = $.parseJSON(response);
      //success
      if(data['err']==0){
        username=data['username'];
        $('#loginbox').hide();
        $('#chatBox').show();
        $('#textarea').show();
        console.log(username);
        console.log(data['contacts']);
        var contacts=data['contacts'];
        var onlinelist=data['online'];
        //show list of contacts
        if(contacts.length!=0){
          for (i = 0; i < contacts.length; i++){
            //get status-----------------------------------------------
            var status="";
            if(contains(onlinelist,contacts[i])){
              status="Online";
            }else{
              status="Offline";
            }
            var newElement = document.createElement('li');
            //formated new message
            newElement.innerHTML =
            "<li class='bounceInDown contacts' id='"+contacts[i]+"'>"+
            "<a href='#' class='clearfix'>"+
            "<img src='http://bootdey.com/img/Content/user_1.jpg' alt='' class='img-circle'>"+
            "<div class='friend-name'>"+
            "<strong>"+contacts[i]+"</strong>"+
            "</div>"+
            "<div id='status"+contacts[i]+"' class='last-message text-muted'>"+status+"</div>"+
            "</a>"+
            "</li>"
            //append new message
            document.getElementById("contactlist").appendChild(newElement);
          }
        }

        //notify other client
        var msg={ type:"online",currentUser: username};
        websocket.send(JSON.stringify(msg));

        //get friend request list
        getRequestList();

        //get chatroom list
        getChatroomList();
      }else{
        //failed
        //clean div and apend new alert
        $('#loginalert').empty();
        var newElement = document.createElement('p');

        $("#username1").val('');
        $("#password1").val('');
        if (data['err']==1) {
          //alert("Wrong password");
          newElement.innerHTML="<p>"+"Wrong password!"+"</p>"
        }else if (data['err']==2) {
          //alert("No such username");
          newElement.innerHTML="<p>"+"No such username!"+"</p>"
        }else{
          //alert("All feilds need to be filled");
          newElement.innerHTML="<p>"+"All feilds need to be filled!"+"</p>"
        }
        //append append alert
        document.getElementById("loginalert").appendChild(newElement);
        document.getElementById("loginalert").style.display = 'block';
      }
    })

  }

//onclick for sign up
  function userSignUp(){
    var userName=$('#username2').val();
    var passWord=$('#password2').val();

    $.ajax({
      type: "POST",
      url: "logInSignUp.php",
      data: { type:"signin" ,username2: userName, password2: passWord}
    }).success(function(response) {
      console.log(response);
      //hide alert
      document.getElementById("signupalert").style.display = 'none';
      var data = $.parseJSON(response);
      //successflly add new user
      if(data['err']==0){
        //hide sign up show chat box
          username=data['username'];
          console.log(username);
          $('#signupbox').hide();
          $('#chatBox').show();
        //get friend request list
          getRequestList();
          getChatroomList();

      }else {
        //failed
        $('#signupalert').empty();
        var newElement = document.createElement('p');
        $("#username2").val('');
        $("#password2").val('');
        if (data['err']==1) {
          //alert("Choose another username");
          newElement.innerHTML="<p>"+"Choose another username!"+"</p>"
        }else{
          //alert("All feilds need to be filled");
          newElement.innerHTML="<p>"+"All feilds need to be filled!"+"</p>"
        }
        //append append alert
        document.getElementById("signupalert").appendChild(newElement);
        document.getElementById("signupalert").style.display = 'block';

      }

    })

  }

  //send Message to back end add online status
  function sendMessage(){
    hasSent=true;
    var message=$('#message').val();
    if(currentChatroomId!=0){
      $.ajax({
        type: "POST",
        url: "chat.php",
        data: { message: message ,currentUser: username, chatroom:currentChatroomId}
      }).success(function(response) {
        console.log(response);
      })

      //convert and send data to server
      var msg={ type:"usermsg",message: message ,currentUser: username, chatroom:currentChatroomId};
      websocket.send(JSON.stringify(msg));
    }
    else{
      alert("chose a chat room");
    }
    $("#message").val('');
  }

  //*websocket receive data from server
  function receiveData(){
    //#### Message received from server?
    websocket.onmessage = function(event) {
      console.log(event.data);
      var result=$.parseJSON(event.data);
      var type=result.type;
		  if(type == 'usermsg')
		  {
        //message is for current chatroom
        if(result.chatroomid==currentChatroomId && result.message!=""){
          var myusername=result.name;
          var message=result.message;

          var newElement = document.createElement('li');
          //formated new message
          newElement.innerHTML =
          "<li class='left clearfix'>"+
            "<span class='chat-img pull-left'>"+
              "<img src='http://bootdey.com/img/Content/user_3.jpg' alt='User Avatar'>"+
            "</span>"+
            "<div class='chat-body clearfix'>"+
              "<p>"+
                message+
              "</p>"+
            "</div>"+
          "</li>"
          //append new message
          document.getElementById("chatContent").appendChild(newElement);
        }else{
          //-------------------------------------------------------
          var message=result.message;
          map[result.chatroomid].push(message);
          console.log(map[result.chatroomid]);
          console.log(map[result.chatroomid].length);

          //add new message alert
          var newElement = document.createElement('div');
          //formated new message
          newElement.innerHTML ="<div><small class='chat-alert label label-danger'>"+map[result.chatroomid].length+"</small></div>";
          //append new message
          document.getElementById("newmessage"+result.chatroomid).appendChild(newElement);

        }
		  }
      if(type == 'friendRequest'){
        console.log("send from  "+result.sendFrom+" to "+result.sendTo);
        var sendTo=result.sendTo;
        //if it is send to me
        if(sendTo== username){
          console.log("here");
          var sendFrom=result.sendFrom;
          //show notification
          var newElement = document.createElement('div');
          newElement.innerHTML="<div class='alert alert-success'>"+
                                  "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                                  "<span class='glyphicon glyphicon-ok'></span>"+
                                  "<strong>Success Message</strong>"+
                                  "<hr class='message-inner-separator'>"+
                                  "<p>You have a new friend request!</p>"+
                                "</div>";
          //append new message
          document.getElementById("friendNotification").appendChild(newElement);

          //add to request list
          var newElement1 = document.createElement('tr');
          requestNumber+=1;
          console.log(requestNumber);
          //formated new message
          newElement1.innerHTML ="<tr>"+
                                  "<td>"+
                                    "<img src='http://bootdey.com/img/Content/user_1.jpg' alt=''>"+
                                      "<a href='#' class='user-link'>"+sendFrom+"</a>"+
                                  "</td>"+
                                  "<td style='width: 40%;'>"+
                                    "<a href='#' class='table-link accept' id='accept"+requestNumber+"' val='"+sendFrom+"'>"+
                                      "<span class='fa-stack'>"+
                                        "<i class='fa fa-square fa-stack-2x'></i>"+
                                        "<i class='fa fa-check-circle-o fa-stack-1x fa-inverse'></i>"+
                                      "</span>"+
                                    "</a>"+
                                    "<a href='#' class='table-link reject' id='reject"+requestNumber+"' val='"+sendFrom+"'>"+
                                      "<span class='fa-stack'>"+
                                        "<i class='fa fa-square fa-stack-2x'></i>"+
                                        "<i class='fa fa-times-circle-o fa-stack-1x fa-inverse'></i>"+
                                      "</span>"+
                                    "</a>"+
                                  "</td>"+
                                "</tr>";

          newElement1.setAttribute("id", "item"+requestNumber);
          //append new message
          document.getElementById("requestlist").appendChild(newElement1);
        }
      }
		  if(type == 'system')
		  {
			  console.log(result.message);
		  }
      if(type =='accept'){
        //if this user is accepted
        console.log("accepted in receive message");
        console.log("send from "+result.sendFrom);
        console.log("send to "+result.sendTo);
        if(result.sendFrom==username){
          //console.log("i got acccepted from "+result.sendTo);
          var newElement = document.createElement('li');
          //add newly accepted friend to contact list
          newElement.innerHTML =
          "<li class='bounceInDown contacts' id='"+result.sendTo+"'>"+
          "<a href='#' class='clearfix'>"+
          "<img src='http://bootdey.com/img/Content/user_1.jpg' alt='' class='img-circle'>"+
          "<div class='friend-name'>"+
          "<strong>"+result.sendTo+"</strong>"+
          "</div>"+
          "<div id='status"+result.sendTo+"' id=class='last-message text-muted'>Online</div>"+
          "</a>"+
          "</li>"
          //append new message
          document.getElementById("contactlist").appendChild(newElement);
        }
      }
      if(type=='online' && result.name!=username){
        var name=result.name;
        console.log(name+" on line");
        document.getElementById("status"+name).textContent="Online";
      }
      if(type=='offline' && result.name!=username){
        var name=result.name;
        console.log(name+" off line");
        document.getElementById("status"+name).textContent="Offline";
      }


    };

  }

  </script>

</body>
</html>

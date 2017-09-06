CREATE TABLE Messages
(
Username varchar(255) NOT NULL,
ChatroomId int NOT NULL,
Id int NOT NULL AUTO_INCREMENT,
Text varchar(255) NOT NULL,
Time timestamp NOT NULL default CURRENT_TIMESTAMP,
PRIMARY KEY (Id)
);


CREATE TABLE Users
(
UserId int NOT NULL AUTO_INCREMENT,
Username varchar(255) NOT NULL UNIQUE,
Password varchar(255) NOT NULL,
Status varchar(255) NOT NULL,
PRIMARY KEY (UserId)
);

CREATE TABLE Chatrooms
(
ChatroomId int NOT NULL UNIQUE,
Name varchar(255) NOT NULL,
NumberOfUser int NOT NULL,
PRIMARY KEY (ChatroomId)
);

CREATE TABLE Friendship
(
  Username1 varchar(255) NOT NULL REFERENCES Users (Username),
  Username2 varchar(255) NOT NULL REFERENCES Users (Username),
  PRIMARY KEY (Username1,Username2)
);

CREATE TABLE UserInChatroom
(
  Username varchar(255) NOT NULL REFERENCES Users (Username),
  ChatroomId int NOT NULL REFERENCES Chatrooms (ChatroomId),
  PRIMARY KEY (Username,ChatroomId)
);

CREATE TABLE Friendrequest
(
  requestId int NOT NULL AUTO_INCREMENT,
  sendFrom varchar(255) NOT NULL REFERENCES Users (Username),
  sendTo varchar(255) NOT NULL REFERENCES Users (Username),
  PRIMARY KEY (requestId,sendFrom,sendTo)
);

PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS agent;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS link_departments;
DROP TABLE IF EXISTS statuses;
DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS hashtags;
DROP TABLE IF EXISTS link_hashtags;
DROP TABLE IF EXISTS faq;
DROP TABLE IF EXISTS document;
DROP TABLE IF EXISTS link_documents;
DROP TABLE IF EXISTS comment;

CREATE TABLE User (
  'UserId' int(11) NOT NULL,
  'username' varchar(255) NOT NULL,
  'name' varchar(255) NOT NULL,
  'password' varchar(255) NOT NULL,
  'email' varchar(255) NOT NULL,
  'image_url' varchar(255) NOT NULL DEFAULT '../images/default_user.png',
  PRIMARY KEY ('UserId')
);

CREATE TABLE Client(
  'client_id' int(11) NOT NULL,
  'client_username' varchar(255) NOT NULL,
  FOREIGN KEY ('client_id') REFERENCES 'User' ('UserId')
  PRIMARY KEY ('client_id')
);

CREATE TABLE Agent(
  'agent_id' int(11) NOT NULL,
  'agent_username' varchar(255) NOT NULL,
  FOREIGN KEY ('agent_id') REFERENCES 'User' ('UserId')
  PRIMARY KEY ('agent_id')
);

CREATE TABLE Admin(
  'admin_id' int(11) NOT NULL,
  'admin_username' varchar(255) NOT NULL,
  FOREIGN KEY ('admin_id') REFERENCES 'User' ('UserId')
  PRIMARY KEY ('admin_id')
);

CREATE TABLE Department (
  'id' int(11) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Link_departments(
  'department_id' int(11) NOT NULL,
  'UserId' varchar(255) NOT NULL,
  FOREIGN KEY ('department_id') REFERENCES 'department' ('id'),
  FOREIGN KEY ('UserId') REFERENCES 'User' ('UserId')
);

CREATE TABLE Statuses(
  'id' int(11) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Ticket (
  'id' int(11) NOT NULL,
  'author_username' varchar(255) NOT NULL,
  'department_id' int(11) NOT NULL,
  'agent_username' varchar(255) NOT NULL,
  'subject' varchar(255) NOT NULL,
  'content' text NOT NULL,
  'status' int(11) NOT NULL,
  'date' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  'priority' int(1) DEFAULT 0,
  PRIMARY KEY ('id'),
  FOREIGN KEY ('status') REFERENCES 'statuses' ('id')
);

CREATE TABLE Hashtags(
  'id' int(11) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Link_hashtags(
  'ticket_id' int(11) NOT NULL,
  'hashtag_id' int(11) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('hashtag_id') REFERENCES 'hashtags' ('id')
);

CREATE TABLE Faq(
  'id' int(11) NOT NULL,
  'question' varchar(255) NOT NULL,
  'answer' text NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Document(
  'id' int(11) NOT NULL,
  'url' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Link_documents(
  'ticket_id' int(11) NOT NULL,
  'document_id' int(11) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('document_id') REFERENCES 'document' ('id')
);

CREATE TABLE Comment(
  'id' int(11) NOT NULL,
  'ticket_id' int(11) NOT NULL,
  'UserId' varchar(255) NOT NULL,
  'content' text NOT NULL,
  'date' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ('id'),
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('UserId') REFERENCES 'User' ('UserId')
);

INSERT INTO 'User' ('UserId', 'username', 'name', 'password', 'email', 'image_url') VALUES
(1, 'john1', 'John_1', 'john1', 'john1@gmail.com', '../images/default_user.png'),
(2, 'john2', 'John_2', 'john2', 'john2@gmail.com', '../images/default_user.png'),
(3, 'john3', 'John_3', 'john3', 'john3@gmail,com', '../images/default_user.png'),
(4, 'john4', 'John_4', 'john4', 'john4@gmail.com', '../images/default_user.png'),
(5, 'john5', 'John_5', 'john5', 'john5@gmail.com', '../images/default_user.png');

INSERT INTO 'Client' ('client_id', 'client_username') VALUES
(1, 'john1'),
(2, 'john2');

INSERT INTO 'Agent' ('agent_id', 'agent_username') VALUES
(3, 'john3'),
(4, 'john4');

INSERT INTO 'Admin' ('admin_id', 'admin_username') VALUES
(5, 'john5');
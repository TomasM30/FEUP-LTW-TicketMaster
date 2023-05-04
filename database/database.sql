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

CREATE TABLE user (
  'username' varchar(255) NOT NULL,
  'name' varchar(255) NOT NULL,
  'password' varchar(255) NOT NULL,
  'email' varchar(255) NOT NULL,
  'image_url' varchar(255) NOT NULL DEFAULT '../images/default_user.png',
  PRIMARY KEY ('username')
);

CREATE TABLE client(
  'client_username' varchar(255) NOT NULL,
  FOREIGN KEY ('client_username') REFERENCES 'user' ('username')
  PRIMARY KEY ('client_username')
);

CREATE TABLE agent(
  'agent_username' varchar(255) NOT NULL,
  FOREIGN KEY ('agent_username') REFERENCES 'user' ('username')
  PRIMARY KEY ('agent_username')
);

CREATE TABLE admin(
  'admin_username' varchar(255) NOT NULL,
  FOREIGN KEY ('admin_username') REFERENCES 'user' ('username')
  PRIMARY KEY ('admin_username')
);

CREATE TABLE department (
  'id' int(11) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE link_departments(
  'department_id' int(11) NOT NULL,
  'user_username' varchar(255) NOT NULL,
  FOREIGN KEY ('department_id') REFERENCES 'department' ('id'),
  FOREIGN KEY ('user_username') REFERENCES 'user' ('username')
);

CREATE TABLE statuses(
  'id' int(11) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE ticket (
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

CREATE TABLE hashtags(
  'id' int(11) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE link_hashtags(
  'ticket_id' int(11) NOT NULL,
  'hashtag_id' int(11) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('hashtag_id') REFERENCES 'hashtags' ('id')
);

CREATE TABLE faq(
  'id' int(11) NOT NULL,
  'question' varchar(255) NOT NULL,
  'answer' text NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE document(
  'id' int(11) NOT NULL,
  'url' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE link_documents(
  'ticket_id' int(11) NOT NULL,
  'document_id' int(11) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('document_id') REFERENCES 'document' ('id')
);

CREATE TABLE comment(
  'id' int(11) NOT NULL,
  'ticket_id' int(11) NOT NULL,
  'author_username' varchar(255) NOT NULL,
  'content' text NOT NULL,
  'date' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ('id'),
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('author_username') REFERENCES 'user' ('username')
);


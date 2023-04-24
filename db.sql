PRAGMA foreign_keys = ON;

CREATE TABLE 'user' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'name' varchar(255) NOT NULL,
  'username' varchar(255) NOT NULL,
  'password' varchar(255) NOT NULL,
  'email' varchar(255) NOT NULL,
  'image_url' varchar(255) NOT NULL DEFAULT '../images/default_user.png',
  PRIMARY KEY ('id')
);

CREATE TABLE 'client'(
  'user_id' int(11) NOT NULL,
  FOREIGN KEY ('user_id') REFERENCES 'user' ('id')
  PRIMARY KEY ('user_id')
);

CREATE TABLE 'agent'(
  'user_id' int(11) NOT NULL,
  FOREIGN KEY ('user_id') REFERENCES 'user' ('id')
  PRIMARY KEY ('user_id')
);

CREATE TABLE 'admin'(
  'user_id' int(11) NOT NULL,
  FOREIGN KEY ('user_id') REFERENCES 'user' ('id')
  PRIMARY KEY ('user_id')
);

CREATE TABLE 'department' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE 'link_departments'(
  'department_id' int(11) NOT NULL,
  'user_id' int(11) NOT NULL,
  FOREIGN KEY ('department_id') REFERENCES 'department' ('id'),
  FOREIGN KEY ('user_id') REFERENCES 'user' ('id')
);

CREATE TABLE 'statuses'(
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE 'ticket' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'author_id' int(11) NOT NULL,
  'department_id' int(11) NOT NULL,
  'agent_id' int(11),
  'subject' varchar(255) NOT NULL,
  'content' text NOT NULL,
  'status' int(11) NOT NULL,
  'date' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  'priority' enum('low', 'medium', 'high') DEFAULT 'low',
  PRIMARY KEY ('id'),
  FOREIGN KEY ('status') REFERENCES 'statuses' ('id')
);

CREATE TABLE 'hashtags'(
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE 'link_hashtags'(
  'ticket_id' int(11) NOT NULL,
  'hashtag_id' int(11) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('hashtag_id') REFERENCES 'hashtags' ('id')
);

CREATE TABLE 'faq'(
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'question' varchar(255) NOT NULL,
  'answer' text NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE 'document'(
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'url' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE 'link_documents'(
  'ticket_id' int(11) NOT NULL,
  'document_id' int(11) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('document_id') REFERENCES 'document' ('id')
);

CREATE TABLE 'comment'(
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'ticket_id' int(11) NOT NULL,
  'author_id' int(11) NOT NULL,
  'content' text NOT NULL,
  'date' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ('id'),
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('author_id') REFERENCES 'user' ('id')
);


PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS agent;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS department;
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
  'username' varchar(255) NOT NULL,
  'name' varchar(255) NOT NULL,
  'password' varchar(255) NOT NULL,
  'email' varchar(255) NOT NULL,
  'image_url' blob NOT NULL DEFAULT '../images/default_user.png',
  PRIMARY KEY ('username')
);

CREATE TABLE Client(
  'client_username' varchar(255) NOT NULL,
  FOREIGN KEY ('client_username') REFERENCES 'User' ('username')
  PRIMARY KEY ('client_username')
);

CREATE TABLE Agent(
  'agent_username' varchar(255) NOT NULL,
  FOREIGN KEY ('agent_username') REFERENCES 'User' ('username')
  PRIMARY KEY ('agent_username')
);

CREATE TABLE Admin(
  'admin_username' varchar(255) NOT NULL,
  FOREIGN KEY ('admin_username') REFERENCES 'User' ('username')
  PRIMARY KEY ('admin_username')
);

CREATE TABLE Department (
  'id' int(6) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Link_departments(
  'department_id' int(6) NOT NULL,
  'username' varchar(255) NOT NULL,
  FOREIGN KEY ('department_id') REFERENCES 'department' ('id'),
  FOREIGN KEY ('username') REFERENCES 'User' ('username')
);

CREATE TABLE Statuses(
  'id' int(1) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Hashtags(
  'id' int(6) NOT NULL,
  'name' varchar(255) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Ticket (
  'id' int(6) NOT NULL,
  'author_username' varchar(255) NOT NULL,
  'department_id' int(11),
  'agent_username' varchar(255),
  'subject' varchar(255) NOT NULL,
  'content' text NOT NULL,
  'status' int(1) NOT NULL,
  'date' datetime DEFAULT CURRENT_TIMESTAMP,
  'priority' int(1) DEFAULT 0,
  PRIMARY KEY ('id'),
  FOREIGN KEY ('status') REFERENCES 'statuses' ('id')
  FOREIGN KEY ('author_username') REFERENCES 'User' ('username')
  FOREIGN KEY ('department_id') REFERENCES 'department' ('id')
  FOREIGN KEY ('agent_username') REFERENCES 'Agent' ('agent_username')
  FOREIGN KEY ('status') REFERENCES 'Statuses' ('id')
);


CREATE TABLE Link_hashtags(
  'ticket_id' int(6) NOT NULL,
  'hashtag_id' int(11) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('hashtag_id') REFERENCES 'hashtags' ('id')
);

CREATE TABLE Faq(
  'id' int(6) NOT NULL,
  'question' varchar(255) NOT NULL,
  'answer' text NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Document(
  'id' int(6) NOT NULL,
  'file' mediumblob NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE Link_documents(
  'ticket_id' int(6) NOT NULL,
  'document_id' int(6) NOT NULL,
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('document_id') REFERENCES 'document' ('id')
);

CREATE TABLE Comment(
  'id' int(6) NOT NULL,
  'ticket_id' int(6) NOT NULL,
  'username' varchar(255) NOT NULL,
  'content' text NOT NULL,
  'date' datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ('id'),
  FOREIGN KEY ('ticket_id') REFERENCES 'ticket' ('id'),
  FOREIGN KEY ('username') REFERENCES 'User' ('username')
);

INSERT INTO 'User' ('username', 'name', 'password', 'email', 'image_url') VALUES
('john1', 'John_1', 'john1', 'john1@gmail.com', '../images/default_user.png'),
('john6', 'John_112121212121212121', 'john1', 'john6@gmail.com', '../images/default_user.png'),
('john2', 'John_2', 'john2', 'john2@gmail.com', '../images/default_user.png'),
('john3', 'John_3', 'john3', 'john3@gmail,com', '../images/default_user.png'),
('john4', 'John_4', 'john4', 'john4@gmail.com', '../images/default_user.png'),
('john5', 'John_5', 'john5', 'john5@gmail.com', '../images/default_user.png');

INSERT INTO 'Client' ('client_username') VALUES
('john1'),
('john6'),
('john2');

INSERT INTO 'Agent' ('agent_username') VALUES
('john3'),
('john4');

INSERT INTO 'Admin' ('admin_username') VALUES
('john5');

INSERT INTO 'Department' ('id', 'name') VALUES
(1, 'Department_1'),
(2, 'Department_2'),
(3, 'Department_3'),
(4, 'Department_4'),
(5, 'Department_5');

INSERT INTO 'Link_departments' ('department_id', 'username') VALUES
(1, 'john3'),
(2, 'john3'),
(3, 'john4'),
(4, 'john4'),
(5, 'john1');

INSERT INTO 'Statuses' ('id', 'name') VALUES
(1, 'Open'),
(2, 'Assigned'),
(3, 'Closed');

INSERT INTO 'Ticket' ('id', 'author_username', 'department_id', 'agent_username', 'subject', 'content', 'status', 'date', 'priority') VALUES
(1, 'john1', 1, 'john3', 'Subject_1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus a placerat sem. Nunc euismod nec orci cursus sagittis. In ac tortor et eros ultricies posuere. Phasellus tortor erat, rutrum ac placerat sed, laoreet ac ex. In porttitor, felis nec consequat gravida, ex magna eleifend tortor, ut imperdiet magna enim eget nisi. Nam non faucibus lectus. Nullam nec odio et tellus ultrices tristique. Nam vitae massa ut massa malesuada iaculis. Suspendisse efficitur finibus massa, eget luctus sem. Phasellus tempus aliquam lacus in cursus. Etiam et sem id arcu convallis venenatis.

                                       Suspendisse et enim faucibus, bibendum arcu ac, lobortis turpis. Sed quis ligula id leo hendrerit viverra quis a erat. Phasellus facilisis lectus et arcu aliquet, sit amet placerat neque ornare. Maecenas venenatis lacus at venenatis auctor. Proin dui justo, accumsan at condimentum nec, ullamcorper eget urna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aliquam erat volutpat. Phasellus egestas, eros tristique convallis volutpat, ex nulla convallis felis, vitae pretium nisi purus vel nisi. Duis ante velit, posuere non porta et, molestie ut lorem. Ut at massa porta, cursus quam quis, imperdiet lorem. Ut in aliquam ligula. Maecenas pellentesque accumsan urna.', 1, '2019-01-01 00:00:00', 0),
(2, 'john2', 2, 'john3', 'Subject_2', 'Proin facilisis lorem et purus aliquet, ut sodales felis blandit. Praesent commodo erat quis dolor pulvinar, quis placerat libero aliquam. Proin condimentum in lectus nec lacinia. Etiam vel semper ligula, eu auctor ex. Ut tempor molestie risus, nec porttitor augue bibendum vel. Mauris massa ipsum, viverra vehicula ex posuere, suscipit placerat nibh. In quis quam iaculis, aliquam ligula eget, dignissim ligula. Suspendisse ac turpis pulvinar, vulputate risus pulvinar, laoreet quam. Donec vestibulum dignissim lorem sit amet laoreet. Nulla vehicula, nisl sit amet ornare vehicula, felis nunc accumsan libero, ac feugiat augue risus non elit. Donec tincidunt eros felis, eget sodales urna placerat sit amet. Sed nunc arcu, laoreet vel ultricies sed, imperdiet nec lectus. Vivamus scelerisque nulla sit amet pretium viverra.', 1, '2019-01-02 00:00:00', 0),
(3, 'john1', 2, 'john4', 'Subject_3', 'Phasellus ut placerat elit. Morbi rutrum justo sit amet nisi porttitor, ac vehicula tellus molestie. Mauris ut gravida odio. Etiam blandit, dui ut feugiat elementum, sem elit vulputate turpis, ut lobortis augue elit id velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum mi odio, eleifend quis diam nec, vehicula tempor lacus. Sed efficitur nisl in turpis congue aliquam. Curabitur ut eleifend nibh. Vivamus ornare diam sed nibh tristique, vel pellentesque sapien tempor. Vestibulum tempor mi turpis, eu fringilla quam tempor vel. Fusce a eros metus. Nulla erat odio, feugiat non tempor a, eleifend vel purus. Cras facilisis elementum metus, ut viverra nibh blandit quis. Donec at interdum augue.', 1, '2019-01-03 00:00:00', 0),
(4, 'john2', 4, 'john4', 'Subject_4', 'Integer sodales dictum dapibus. In hac habitasse platea dictumst. Vivamus sollicitudin blandit odio sed tempus. Morbi diam nisi, posuere non fringilla eu, porta vel velit. Phasellus pharetra ligula congue erat ultrices rhoncus vitae et turpis. Curabitur convallis mattis leo, at lacinia justo maximus ac. Mauris et lobortis ipsum. Praesent interdum, lorem ac euismod viverra, ante eros viverra felis, ut sagittis enim odio id odio.', 1, '2019-01-04 00:00:00', 0),
(5, 'john1', 1, 'john3', 'Subject_5', 'Pellentesque interdum diam nibh, a posuere magna consectetur facilisis. Vestibulum nec dapibus est, nec tempor elit. Praesent ultrices ut lectus id efficitur. Morbi eget interdum arcu. Mauris eleifend cursus mattis. Integer pulvinar urna at justo viverra pulvinar. Nam vel nibh justo. Curabitur tristique fermentum lobortis. Donec lobortis tristique velit, sit amet semper tortor. Pellentesque eu leo erat. Curabitur accumsan ut justo ac fringilla. Phasellus posuere eu ligula sed sollicitudin. In tellus quam, accumsan ut risus in, scelerisque elementum urna. Sed accumsan dui porttitor nibh lobortis, vitae egestas turpis vulputate. Nunc id fringilla quam.', 1, '2019-01-05 00:00:00', 0);

INSERT INTO 'Hashtags' ('id', 'name') VALUES
(1, 'Hashtag_1'),
(2, 'Hashtag_2'),
(3, 'Hashtag_3'),
(4, 'Hashtag_4'),
(5, 'Hashtag_5');

INSERT INTO 'Link_hashtags' ('ticket_id', 'hashtag_id') VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3),
(3, 3),
(3, 4),
(4, 4),
(4, 5),
(5, 5),
(5, 1);

INSERT INTO 'Faq' ('id', 'question', 'answer') VALUES
(1, 'Question_1', 'Answer_1'),
(2, 'Question_2', 'Answer_2'),
(3, 'Question_3', 'Answer_3'),
(4, 'Question_4', 'Answer_4'),
(5, 'Question_5', 'Answer_5');

INSERT INTO 'Document' ('id', 'url') VALUES
(1, 'https://www.google.com'),
(2, 'https://www.google.com'),
(3, 'https://www.google.com'),
(4, 'https://www.google.com'),
(5, 'https://www.google.com');

INSERT INTO 'Link_documents' ('ticket_id', 'document_id') VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3),
(3, 3),
(3, 4),
(4, 4),
(4, 5),
(5, 5),
(5, 1);

INSERT INTO 'Comment' ('id', 'ticket_id', 'username', 'content', 'date') VALUES
(1, 1, 'john1', 'Comment_1', '2019-01-01 00:00:00'),
(2, 1, 'john2', 'Comment_2', '2019-01-02 00:00:00'),
(3, 2, 'john1', 'Comment_3', '2019-01-03 00:00:00'),
(4, 2, 'john2', 'Comment_4', '2019-01-04 00:00:00'),
(5, 3, 'john1', 'Comment_5', '2019-01-05 00:00:00'),
(6, 3, 'john2', 'Comment_6', '2019-01-06 00:00:00'),
(7, 4, 'john1', 'Comment_7', '2019-01-07 00:00:00'),
(8, 4, 'john2', 'Comment_8', '2019-01-08 00:00:00'),
(9, 5, 'john1', 'Comment_9', '2019-01-09 00:00:00'),
(10, 5, 'john2', 'Comment_10', '2019-01-10 00:00:00');
--Setup file
DROP DATABASE IF EXISTS coffee_user_db;
CREATE DATABASE IF NOT EXISTS coffee_user_db;
USE coffee_user_db;

--USER RELATED
CREATE TABLE IF NOT EXISTS users(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Username varchar(30) NOT NULL,
	LastName varchar(255) NOT NULL,
	FirstName varchar(255) NOT NULL,
	Password varchar(255) NOT NULL,
	Birthday date,
	Email varchar(255) NOT NULL,
	Status ENUM("Admin", "User") NOT NULL DEFAULT "User",
	UNIQUE (id, Username)
);

CREATE TABLE IF NOT EXISTS sessions(
	id int NOT NULL PRIMARY KEY,
	userID int NOT NULL
);

INSERT INTO users(Username, LastName, FirstName, Password, Email, Status)
	values("admin", "Ministrator", "Ad", "admin", "admin", "Admin");
INSERT INTO users(Username, LastName, FirstName, Password, Email, Status)
	values("EmilioJuan24", "Lopez", "Emil John", "Jivs080299.", "emil_lopez@dlsu.edu.ph", "User");

--lists the moderators for each category
CREATE TABLE IF NOT EXISTS categories_moderators(
	userID int NOT NULL,
	categoryID int NOT NULL,
	PRIMARY KEY(userID, categoryID)

);


INSERT into categories_moderators values(1,1);

DROP DATABASE IF EXISTS coffee_cred_db;
CREATE DATABASE IF NOT EXISTS coffee_cred_db;
USE coffee_cred_db;

CREATE TABLE IF NOT EXISTS credential_master_list(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL
);



INSERT into credential_master_list(name) value("Historian"); --id=1
--connection between potential credentials and the categories they can be used in
CREATE TABLE IF NOT EXISTS credential_category_connection(
	credentialID int NOT NULL,
	categoryID int NOT NULL,
	PRIMARY KEY(credentialID, categoryID)
);

INSERT into credential_category_connection(credentialID, categoryID) values(1, 1); --Historian -> Philippine History

--connection of credentials to users
CREATE TABLE IF NOT EXISTS user_credentials(
	userID int NOT NULL,
	credentialID int NOT NULL,
	evidence_file_dir text,
	status ENUM("PENDING", "APPROVED", "REJECTED") DEFAULT "PENDING",
	PRIMARY KEY(userID, credentialID)
);

INSERT into user_credentials(userID, credentialID, status) values(1, 1, "APPROVED");
INSERT into user_credentials(userID, credentialID, status) values(2, 1, "APPROVED");
--FORUM-RELATED
--List of all possible credentials in the site 
DROP DATABASE IF EXISTS coffee_db;
CREATE DATABASE IF NOT EXISTS coffee_db;
USE coffee_db;

CREATE TABLE IF NOT EXISTS categories(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL,
	description text NOT NULL,
	creatorID int NOT NULL /*primary key of user who created the category*/
);
--preset categories
INSERT into categories(name, description, creatorID)
	values("Philippine History", "The history of the Philippines", 1),
		  ("Agribusiness", "All about businesses in the agricultural space", 1);


CREATE TABLE IF NOT EXISTS topics(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL,
	description text NOT NULL,
	categoryID int NOT NULL
);

INSERT INTO topics(name, description, categoryID)
	values ("Martial Law Era", "The state of the Philippines during the rule of Ferdinand Marcos", 1),
			("Organic Farming", "All about how to make a successful business in organic farming", 2);

CREATE TABLE IF NOT EXISTS posts(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title varchar(255) NOT NULL,
	datetimePosted timestamp DEFAULT CURRENT_TIMESTAMP(), 
	topicID int NOT NULL,
	userID int NOT NULL,
	content text NOT NULL
);

INSERT INTO posts(title, topicID, userID, content)
	values("Who is Marcos", 1, 2, "I don't know who this Marcos guy is?");
CREATE TABLE IF NOT EXISTS responses(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	content text NOT NULL,
	datetimePosted timestamp DEFAULT CURRENT_TIMESTAMP(),
	upvotes int NOT NULL DEFAULT 0,
	downvotes int NOT NULL DEFAULT 0,
	postID int NOT NULL,
	userID int NOT NULL,
	parentResponseID int
	/*
	* self-referential id that shows the topic above. 
	* This should be set to NULL if it is a top-level topic
	*/
);
INSERT INTO responses(content, postID, userID)
			values("He was a dictator who used a communism uprising as an excuse to declare Martial Law<br/><br/>Yikes.", 1 ,1),
				   ("I see. I am actually a historian but I didn't know, how shameful.", 1, 2);

CREATE TABLE IF NOT EXISTS vote_master_list(
	voterUserID int NOT NULL,
	postID int NOT NULL,
	vote ENUM("UP", "DOWN") NOT NULL,
	responseID int
	/* should be nulled out if it is an upvote for the post */
);
CREATE TABLE IF NOT EXISTS answer_requests(
	requestorUserID int NOT NULL,
	requestedUserID int NOT NULL,
	postID int NOT NULL
); 
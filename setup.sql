--Setup file
DROP DATABASE IF EXISTS coffee_db;
CREATE DATABASE IF NOT EXISTS coffee_db;
USE coffee_db;

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
CREATE TABLE IF NOT EXISTS credential_master_list(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL
);
--connection between potential credentials and the categories they can be used in
CREATE TABLE IF NOT EXISTS credential_category_connection(
	credentials_id int NOT NULL,
	categoryID int NOT NULL,
	PRIMARY KEY(credentials_id, categoryID)
);

--connection of credentials to users
CREATE TABLE IF NOT EXISTS user_credentials(
	userID int NOT NULL,
	credential_id int NOT NULL,
	evidence_file_dir text,
	status ENUM("PENDING", "APPROVED") DEFAULT "PENDING",
	PRIMARY KEY(userID, credential_id)
);

--FORUM-RELATED
--List of all possible credentials in the site 
CREATE TABLE IF NOT EXISTS categories(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL,
	description text NOT NULL,
	creatorID int NOT NULL /*primary key of user who created the category*/
);
--preset categories
INSERT into categories(name, description, creatorID)
	values("Philippine History", "The history of the Philippines", 0),
		  ("Agribusiness", "All about businesses in the agricultural space", 0);


CREATE TABLE IF NOT EXISTS topics(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL,
	categoryID int NOT NULL,
	parentTopicID int
		/*
		* self-referential id that shows the topic above. 
		* This should be set to NULL if it is a top-level topic
		*/
);

CREATE TABLE IF NOT EXISTS posts(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title varchar(255) NOT NULL,
	datetimePosted timestamp DEFAULT CURRENT_TIMESTAMP(), 
	description text NOT NULL,
	upvotes int NOT NULL DEFAULT 0,
	downvotes int NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS responses(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	content text NOT NULL,
	upvotes int NOT NULL DEFAULT 0,
	downvotes int NOT NULL DEFAULT 0,
	postID int NOT NULL,
	parentResponseID int
	/*
	* self-referential id that shows the topic above. 
	* This should be set to NULL if it is a top-level topic
	*/
);

CREATE TABLE IF NOT EXISTS vote_master_list(
	voterUserID int NOT NULL,
	postID int NOT NULL,
	responseID int
	/* should be nulled out if it is an upvote for the post */
);
CREATE TABLE IF NOT EXISTS answer_requests(
	requestorUserID int NOT NULL,
	requestedUserID int NOT NULL,
	postID int NOT NULL
); 
--Setup file
CREATE DATABASE IF NOT EXISTS coffee_db;
USE coffee_db;

--USER RELATED
CREATE TABLE IF NOT EXISTS users(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Username varchar(30) NOT NULL,
	LastName varchar(255) NOT NULL,
	FirstName varchar(255) NOT NULL,
	Password varchar(255) NOT NULL,
	Age int,
	Email varchar(255) NOT NULL,
	UNIQUE (id, Username)
);


CREATE TABLE IF NOT EXISTS potential_credentials(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL
);
--connection between potential credentials and the categories they can be used in
CREATE TABLE IF NOT EXISTS potential_credential_categories(
	potential_credentials_id int NOT NULL,
	categoryID int NOT NULL,
	PRIMARY KEY(potential_credentials_id, categoryID)
);

--connection of credentials to users
CREATE TABLE IF NOT EXISTS actual_user_credentials(
	userID int,
	potential_credentials int,
	PRIMARY KEY(userID, potential_credentials)
);

--FORUM-RELATED
--List of all possible credentials in the site 
CREATE TABLE IF NOT EXISTS categories(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL,
	creatorID int NOT NULL /*primary key of user who created the category*/
);


CREATE TABLE IF NOT EXISTS topics(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL,
	categoryID int NOT NULL,
	parentTopicID int NOT NULL 
		/*
		* self-referential id that shows the topic above. 
		* This should be set to 0 if it is a top-level topic
		*/
)
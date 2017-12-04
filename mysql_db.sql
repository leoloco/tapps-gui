DROP DATABASE IF EXISTS tapps_db;
CREATE DATABASE tapps_db;
USE tapps_db;

DROP TABLE IF EXISTS tapps;
CREATE TABLE tapps (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  tpid varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  version_latest varchar(255) NOT NULL DEFAULT '0',
  cdn_uri varchar(255) NOT NULL,
  cdn_login varchar(255) NOT NULL,
  cdn_password varchar(255) NOT NULL,
  user_id int NOT NULL,
  type varchar(255)
);

DROP TABLE IF EXISTS devices;
CREATE TABLE devices (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  tpid varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  creation_date datetime NOT NULL
);

DROP TABLE IF EXISTS ownerships;
CREATE TABLE ownerships (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  device_id int NOT NULL,
  user_id int NOT NULL,
  tapp_id int NOT NULL,
  creation_date datetime,
  modified_date datetime,
  href varchar(255),
  activation boolean
);

DROP TABLE IF EXISTS transactions;
CREATE TABLE transactions (
  id int NOT NULL PRIMARY KEY,
  operation varchar(255) NOT NULL,
  type varchar(255) NOT NULL,
  status boolean
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  tpid varchar(255) NOT NULL,
  username varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  org varchar(255) NOT NULL,
  type varchar(255) NOT NULL,
  API_KEY TEXT
);

DROP TABLE IF EXISTS ownerships_apps;
CREATE TABLE ownerships_apps (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id int NOT NULL,
  tapp_id int NOT NULL
);

DROP TABLE IF EXISTS ownerships_devices;
CREATE TABLE ownerships_devices (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  device_id int NOT NULL,
  user_id int NOT NULL
);

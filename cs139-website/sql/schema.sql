-- Tables
-- Table: user
DROP TABLE USER;
CREATE TABLE USER (
  userID INTEGER PRIMARY KEY AUTOINCREMENT,
  username varchar(63),
  nickname varchar(63),
  password varchar(255),
  email varchar(255),
  dateJoined varchar(31),
  householdID int,
  iconID int
);

-- Table: household
DROP TABLE HOUSEHOLD;
CREATE TABLE HOUSEHOLD (
  householdID INTEGER PRIMARY KEY AUTOINCREMENT,
  name varchar(63),
  password varchar(255),
  dateCreated varchar(31)
);

-- Table: chore
DROP TABLE CHORE;
CREATE TABLE CHORE (
  choreID INTEGER PRIMARY KEY AUTOINCREMENT,
  householdID int,
  creatorID int,
  userID int,
  task varchar(255),
  note varchar(255),
  dateAdded varchar(15),
  status varchar(63),
  frequency varchar(63),
  interval int,
  starting varchar(15),
  dateDue varchar(15),
  weight int
);

CREATE TABLE `posts` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`name`	TEXT,
	`description`	TEXT,
	`text`	TEXT,
	`date`	TEXT
);

CREATE TABLE `admin` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`login`	TEXT,
	`password`	TEXT
);
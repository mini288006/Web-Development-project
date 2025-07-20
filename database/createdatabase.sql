CREATE DATABASE huan_fitness_pal_db;

USE huan_fitness_pal_db;

CREATE TABLE admins(
	Admin_id int AUTO_INCREMENT PRIMARY KEY,
	Admin_username varchar(30) unique not null,
	pass varchar(30) not null,
	Fname varchar(20) not null,
	Lname varchar(20) not null
);

CREATE TABLE users(
	Usr_id int AUTO_INCREMENT PRIMARY KEY not null,
	Usr_username varchar(20) unique not null,
	email varchar(30) unique not null,
	contact varchar(20),
	pass varchar(20) not null,
	Fname varchar(20) not null,
	Lname varchar(20) not null,
	gender varchar(1) not null,
	Usr_height float,
	Usr_weight float,
	amountowe float DEFAULT 0
);

CREATE TABLE physical(
	Usr_id int not null,
	Update_date date not null,
	Usr_height float not null,
	Usr_weight float not null,
	BMI float not null,
	PRIMARY KEY (Usr_id, Update_date),
	FOREIGN KEY (Usr_id) REFERENCES users(Usr_id)
);

CREATE TABLE water(
	Usr_id int not null,
	Update_date date not null,
	Water_intake float ,
	PRIMARY KEY (Usr_id, Update_date),
	FOREIGN KEY (Usr_id) REFERENCES users(Usr_id)
);

CREATE TABLE work_outs(
	Usr_id int not null,
	Wo_date date not null,
	time_start time not null,
	time_end time not null,
	Wo_type varchar(20) not null,
	Wo_duration int not null,

	PRIMARY KEY (Usr_id, Wo_date, time_start, time_end),
	FOREIGN KEY (Usr_id) REFERENCES users(Usr_id)
);

CREATE TABLE classes(
	Cls_id int AUTO_INCREMENT not null PRIMARY KEY,
	Cls_name varchar(30) not null,
	Cls_price float not null
);

CREATE TABLE takes(
	Usr_id int not null,
	Cls_id int not null,
	Cls_date date not null,
	Cls_time varchar(20) not null,
	request varchar(1000),
	PRIMARY KEY (Usr_id, Cls_id, Cls_date, Cls_time),
	FOREIGN KEY (Usr_id) REFERENCES users(Usr_id),
	FOREIGN KEY (Cls_id) REFERENCES classes(Cls_id)
);

CREATE TABLE doctors(
	Dr_id int AUTO_INCREMENT PRIMARY KEY,
	Fname varchar(20) not null,
	Lname varchar(20) DEFAULT "",
	Title varchar(20) not null
);

CREATE TABLE meet_ups(
	Meet_id int AUTO_INCREMENT not null PRIMARY KEY,
	Usr_id int not null,
	Dr_id int not null,
	Meet_Time varchar(20) not null,
	Meet_Date date not null,
	Meet_description varchar(1000),
	Meet_request varchar(1000),
	FOREIGN KEY (Usr_id) REFERENCES users(Usr_id),
	FOREIGN KEY (Dr_id) REFERENCES doctors(Dr_id)
);

ALTER TABLE meet_ups
ADD meet_status ENUM('pending', 'rejected', 'approved', 'cancelled', 'completed') DEFAULT 'pending', 
ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

INSERT INTO doctors VALUES (1, "Leni", "Chow", "Doctor");
INSERT INTO doctors VALUES (2, "Mizhan", null, "Doctor");
INSERT INTO doctors VALUES (3, "Abriel", null, "Coach");
INSERT INTO doctors VALUES (4, "Hans", null, "Coach");

INSERT INTO classes VALUES (1, "yoga", 50);
INSERT INTO classes VALUES (2, "kickboxing", 100);
INSERT INTO classes VALUES (3, "tabata", 50);
INSERT INTO classes VALUES (4, "pilates", 75);

INSERT INTO admins VALUES (1, "ADMIN", "password", "Ad", "Min")
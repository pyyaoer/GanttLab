# GanttLab


## Setup Database
```
mysql> grant all privileges on *.* to 'xiaoyang' identified by 'password' with grant option;
mysql> flush privileges;
mysql> create database gantt;
mysql> use gantt;
mysql> create table person( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50) NOT NULL, email VARCHAR(50), info TEXT, passwd VARCHAR(50) NOT NULL);
mysql> create table project( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50) NOT NULL, info TEXT);
mysql> create table event( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50) NOT NULL, start date NOT NULL, end date NOT NULL, project INT NOT NULL, status INT NOT NULL, info TEXT);
mysql> create table person_project( person_id INT NOT NULL, project_id INT NOT NULL);
mysql> create table person_event( person_id INT NOT NULL, event_id INT NOT NULL);
```

## Database Description
```
mysql> show tables;
+-----------------+
| Tables_in_gantt |
+-----------------+
| event           |
| person          |
| person_event    |
| person_project  |
| project         |
+-----------------+
5 rows in set (0.00 sec)
mysql> describe event;
+---------+-------------+------+-----+---------+----------------+
| Field   | Type        | Null | Key | Default | Extra          |
+---------+-------------+------+-----+---------+----------------+
| id      | int(11)     | NO   | PRI | NULL    | auto_increment |
| name    | varchar(50) | NO   |     | NULL    |                |
| start   | date        | NO   |     | NULL    |                |
| end     | date        | NO   |     | NULL    |                |
| project | int(11)     | NO   |     | NULL    |                |
| status  | varchar(10) | NO   |     | NULL    |                |
| info    | text        | YES  |     | NULL    |                |
+---------+-------------+------+-----+---------+----------------+
7 rows in set (0.01 sec)

mysql> describe person;
+--------+-------------+------+-----+---------+----------------+
| Field  | Type        | Null | Key | Default | Extra          |
+--------+-------------+------+-----+---------+----------------+
| id     | int(11)     | NO   | PRI | NULL    | auto_increment |
| name   | varchar(50) | NO   |     | NULL    |                |
| email  | varchar(50) | YES  |     | NULL    |                |
| info   | text        | YES  |     | NULL    |                |
| passwd | varchar(50) | NO   |     | NULL    |                |
+--------+-------------+------+-----+---------+----------------+
5 rows in set (0.01 sec)

mysql> describe person_event;
+-----------+---------+------+-----+---------+-------+
| Field     | Type    | Null | Key | Default | Extra |
+-----------+---------+------+-----+---------+-------+
| person_id | int(11) | NO   |     | NULL    |       |
| event_id  | int(11) | NO   |     | NULL    |       |
+-----------+---------+------+-----+---------+-------+
2 rows in set (0.01 sec)

mysql> describe person_project;
+------------+---------+------+-----+---------+-------+
| Field      | Type    | Null | Key | Default | Extra |
+------------+---------+------+-----+---------+-------+
| person_id  | int(11) | NO   |     | NULL    |       |
| project_id | int(11) | NO   |     | NULL    |       |
+------------+---------+------+-----+---------+-------+
2 rows in set (0.01 sec)

mysql> describe project;
+-------+-------------+------+-----+---------+----------------+
| Field | Type        | Null | Key | Default | Extra          |
+-------+-------------+------+-----+---------+----------------+
| id    | int(11)     | NO   | PRI | NULL    | auto_increment |
| name  | varchar(50) | NO   |     | NULL    |                |
| info  | text        | YES  |     | NULL    |                |
+-------+-------------+------+-----+---------+----------------+
3 rows in set (0.01 sec)
```


**Goal**<br>
Create functioning messaging board.

**Project Hours**<br>
Project started June  14, 2019 and finished June 25, 2019 Total hours: **~32**

 - **2 hours** - Environment setup.
 - **6 hours** - Database structure setup.
 - **4 hours** - htaccess and dependencies.
 - **6 hours** - API setup.
 - **1 hours** - Front-end api setup.
 - **3 hours** - JS validating system.
 - **1-2 hours** - Paginator system.
 - **4 hours** - Server side validators and rendering data.
 - **4 hours** - Finishing project, fixing.

**Database structure**<br>
Database: *MySQL*<br>
Database name: *emotion*<br>
Table name: *messages*<br>

| nr. |Collumn name | Type         | Collation          |  Default | Extra          |<br>
|-----|-------------|--------------|--------------------|----------|----------------|<br>
| 1   | id          | int(11)      |                    | _None_   | AUTO_INCREMENT |<br>
| 2   | fullName    | varchar(255) | utf8_lithuanian_ci | _None_   |                |<br>
| 3   | email       | varchar(255) | utf8_lithuanian_ci | _None_   |                |<br>
| 4   | birthdate   | varchar(255) | utf8_lithuanian_ci | _None_   |                |<br>
| 5   | message     | text         | utf8_lithuanian_ci | _None_   |                |<br>
| 6   | post_date   | varchar(255) | utf8_lithuanian_ci | _None_   |                |<br>

**Used resources:**

     Backend
     - PHP 7.2.4
     - MySQL 5.7.21
     - Apache 2.4.33

	 Frontend
	 - JavaScript ES5
	 - JQuery 3.4.1

**Ideas for the future:**<br>
Application has good starting structure and functionality foundation. Still there is areas a lot to improve.

**Testing framework**<br>
The project provides its own proprietary testing, however, it's suitable for unit testing. No unit tests made.
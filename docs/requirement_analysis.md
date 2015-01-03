### Requirement Analysis

modules
----
1. Check & Fix
2. Install
3. Login
4. Management
5. Migration

details
----
1. Check & Fix
1.1 Check database status
* if db file exists
* if tables exists
* if basic user created

1.2 Check file structure
* if 'resource' directory exists and writable
* if basic scripts exists

1.3 Check system requirement
* pdo ext enable
* sqlite ext enable
* file upload size

1.4 Check database contents
* if any rows contains invalid file
* if any resource do not have a record
* if md5 mis-match

2. Install

3. Login

4. Management
4.1 Basic
* upload a file and store it to server resource path
* insert basic file info to database
* show info from database, and generate file link

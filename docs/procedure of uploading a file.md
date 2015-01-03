procedure when uploading a file
====

1. check if it's a POST request
2. check if there is any error when uploading:
    * $_FILES[ $field ] is set?
    * $_FILES[ $field ]['error'] is 0?

3. check form data validation
4. calculate the md5 of the uploaded file
5. generate random string to used as filename

6. check if this md5 already exists in the database

7. check the mime of the file, and if this mime is supported
8. get the file extension, and concatenate with the random string, generate the filename to store this file
9. check if the filename is used

10. move the file from tmp directory to destination folder, and save as the generated file name

11. insert the record into database

12. check if insert success, and get record id, otherwise delete moved file

13. show success info

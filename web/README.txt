MRBS 3.2.1 Integration with Moodle
README Notes prepared by Anthony Borrow (aborrow@jesuitcp.org)

I have begun integrating MRBS with Moodle so that it does not require a second logon and will read the login information from Moodle.
I am not a security expert and am not aware of what security holes this integration my introduce to either MRBS or Moodle. There is no change to the Moodle code.
The integration uses MRBS's external database authentication against the Moodle database's mdl_user table (username and password fields).
There was one conflict that I discovered. In the functions.php file there is a function called print_header() which using grep I have renamed to print_header_mrbs() since Moodle already has a print_header() function.

Installation
1) Make the appropriate modifications to /mrbs/web/config.inc.php file
1) Copy the mrbs folder to the Moodle Directory Root
2) Create a resource in a course that points to http://yoursite.com/moodledir/mrbs/web/index.php
3) Any teacher of the course that contains the resource should now be able to utilize the resource. Technically any teacher of any course could create the resource and then be able to reserve rooms. Also, any student could type in the URL after logging in to Moodle and see the reserved room list (but not modify it).
4) 

This is the Moodle 2.0 version of this block, it will not work in Moodle 1.9 (or below) - please download earlier versions from here: http://moodle.org/mod/data/view.php?d=13&rid=734

* MRBS Block - Bugs, Feature Requests, and Improvements *

If you have any problems installing this block or suggestions for improvement please create an issue in the Moodle tracker (tracker.moodle.org) in the CONTRIB section for the Block: MRBS component located at: http://tracker.moodle.org/browse/CONTRIB/component/10216

* MRBS Block - Description *

MRBS is useful for scheduling a variety of resources.
More information about MRBS can be obtained at http://mrbs.sourceforge.net/.

* MRBS Block - Disclaimer *

As with any customization, it is recommended that you have a good backup of your Moodle site before attempting to install contributed code.
While those contributing code make every effort to provide the best code that they can, using contributed code nevertheless entails a certain degree of risk as contributed code is not as carefully reviewed and/or tested as the Moodle core code.
Hence, use this block at your own risk.

* Changes *

2014-06-09 - Fixed compatibility with M2.7
2014-06-09 - Confirmed compatibility with M2.6, fixed roomsearch with periods disabled, removal of deprecated 'ereg_replace' funcion (minor warning message).
2013-06-23 - New capability 'block/mrbs:ignoremaxadvancedays' - allows admin users to bypass the 'max_advance_days' restriction.
2013-01-23 - Re-enabled the booking clashes detection. Fixed a couple of deprecated function warnings.
2012-12-07 - Minor Moodle 2.4 compatibility fix
2012-08-23 - Durations in hours can now be entered as either a decimal value (e.g. 1.25) or in hours and minutes (e.g. 1:15), fix am/pm handling on edit form
2012-07-27 - Fix - cross DB compatibility issue when viewing entries
2012-07-16 - Minor fix - limit room names to 25 characters (to avoid DB error)
2012-05-30 - Minor fix to 'available rooms' list, added 'room name' to email subject line, removed default description 'class' when creating new entries
2012-03-28 - New German translation from Ralf Krause; removed main background colour; fixed translation of help page
2012-03-08 - Now able to edit a series of bookings (and series bookings retain their original ID)
2012-02-27 - New capability 'block/mrbs:editunconfirmed' (see below for details)
2012-02-27 - Can now track 'changed' bookings (but does not currently use the data internally)
2012-02-20 - Fixed cron error when using customised period names
2012-02-18 - Improved capability checks when viewing MRBS pages
2012-02-13 - Renamed database tables to meet Moodle guidelines (to allow upload to Moodle.org); Moodle 2.2 compatibility fixes
2012-01-16 - Can now limit how many days in advance bookings can be made; can specifiy a list of users who can book a particular room
2011-07-02 - Moodle 2.x version released

For a full list of changes, please see https://github.com/arborrow/moodle-block_mrbs

* MRBS Block - History *

Key configuration settings for the MRBS block are located in a file called config.inc.php which has been modified to use connection data from the Moodle config.php file.
Thus, the MRBS block authenticates against the mdl_user table as a customized external database type (auth_moodle.php) allowing for single sign on.
Since Moodle already had a print_header() function, there was one conflict that Anthony discovered between MRBS and Moodle.
In the functions.php file there is a function called print_header() which using grep Anthony renamed to print_header_mrbs().
In addition, to conform with Moodle file naming conventions, Anthony changed all of the file extensions to php.

While initially designed to work with Moodle 1.6 as a single sign on integration, later work made the MRBS project a contributed Moodle block.
Stephen Bourget was kind enough to work on some changes to prepare the MRBS block to take advantage of roles for use with Moodle 1.7 and beyond.

On December 28, 2007, Anthony posted a series of patches to address a SQL injection vulnerability.
All users are encouraged to upgrade to the latest version.
Previous versions (namely for Moodle 1.6) are no longer supported or maintained and because of the SQL injection vulnerability use of the block in version 1.6 is strongly discouraged as it makes your entire Moodle installation vulnerable to attack.

In August 2008, Anthony made major effort to make using the MRBS Block more Moodle-like and to update the code.
After bringing the code up to MRBS version 1.2.5, email related function now use Moodle functions (email_to_user) rather than the MRBS code (sendmail).
In addition, all language strings use the Moodle get_string function rather than the MRBS get_vocab.
As a result, a number of language and mail related files were no longer needed have been deleted from CVS.
These are all major patches.
Because of changes in the way that MRBS handles database calls (they switched in version 1.2.6 to use MDB, not MDB2), Anthony has opted to fork with the MRBS project at version 1.2.5.

In April 2011, Davo Smith ( http://www.davodev.co.uk ), commissioned by Synergy Learning ( http://www.synergy-learning.com/ ) and Landesmedienzentrum Baden-Württemberg (http://www.lmz-bw.de/ ), updated this block to work with Moodle 2.0. This built upon some earlier work by Stephen Bourget, but included updating the block to make use of the Moodle database functionality (for increased security and compatibility with all Moodle supported databases), as well as a number of minor bug fixes, security improvements and general code-cleaning.

* MRBS Block - Installation *

1) Save the zip file somewhere onto your local computer and extract all the files

2) Create a new 'mrbs' folder in your Moodle blocks folder [moodleroot]/blocks/mrbs

3) Copy all the downloaded files directly into this 'mrbs' folder
(You should end up with [moodleroot]/blocks/mrbs/block_mrbs.php; [moodleroot]/blocks/mrbs/db/install.xml; [moodleroot]/blocks/mrbs/web/add.php; etc)

4) Log in as 'administrator' and click on the 'Notifications' link (Moodle 1.9) or the 'Home' link (Moodle 2.x)

5) Privileges to use the scheduler are currently based on custom defined capabilities (MRBS_Administrator, MRBS_Scheduler, and MRBS_Viewer).
Details about making use of these capabilities is found at: http://docs.moodle.org/en/MRBS_block#Installation
Three roles are automatically created during installation - 'mrbsviewer', 'mrbseditor' and 'mrbsadmin'. Assigning users these roles at the system level will allow them the appropriate level of access to the MRBS system.

6) The MRBS block is primarily intended for use on the Moodle front page (it works on other pages, but note that each instance of the block links to the same set of bookings - it is not possible to create independent sets of bookings by adding the block to multiple pages)

* MRBS Block - unconfirmed capability *

If a user has the capability 'block/mrbs:editunconfirmed' and they are not in the list of 'room admins' for that particular room, then they will only be able to make bookings of the type 'unconfirmed'.
Any user who has the capability 'block/mrbs:editunconfirmed' AND is in the list of 'room admins' for that room will be able to edit any booking for that room (including bookings made by other users) and will be able to set the type to any available type.

* MRBS Block - Links *
Modules and Plugin entry is at: http://moodle.org/mod/data/view.php?d=13&rid=734
Documentation for the MRBS Block is available at: http://docs.moodle.org/en/MRBS_block
The tracker component is at: http://tracker.moodle.org/secure/IssueNavigator.jspa?reset=true&mode=hide&pid=10033&sorter/order=DESC&sorter/field=priority&resolution=-1&component=10216
Moodle 1.9 code is at: http://cvs.moodle.org/contrib/plugins/blocks/mrbs/
Moodle 2.x code is at: https://github.com/arborrow/moodle-block_mrbs

* MRBS Block - Suggestions *

Feel free to post comments, questions, suggestions, etc. pertaining to the use of MRBS block at http://moodle.org/mod/forum/discuss.php?d=38604 or email Anthony Borrow at arborrow@jesuits.net.

This is the Moodle 2.0 version of this block, it will not work in Moodle 1.9 (or below) - please download earlier versions from here: http://moodle.org/mod/data/view.php?d=13&rid=734

* MRBS Block - Bugs, Feature Requests, and Improvements *

If you have any problems installing this block or suggestions for improvement please create an issue in the Moodle tracker (tracker.moodle.org) in the CONTRIB section for the Block: MRBS component located at: http://tracker.moodle.org/secure/IssueNavigator.jspa?reset=true&mode=hide&pid=10033&sorter/order=DESC&sorter/field=priority&resolution=-1&component=10216.

* MRBS Block - Description *

MRBS is useful for scheduling a variety of resources.
More information about MRBS can be obtained at http://mrbs.sourceforge.net/.
As distributed here it is setup for periods; however, this can easily be changed to times by modifying the config.inc.php file.

* MRBS Block - Disclaimer *

As with any customization, it is recommended that you have a good backup of your Moodle site before attempting to install contributed code.
While those contributing code make every effort to provide the best code that they can, using contributed code nevertheless entails a certain degree of risk as contributed code is not as carefully reviewed and/or tested as the Moodle core code.
Hence, use this block at your own risk.

* New features *

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

4) Log in as 'administrator' and click on the 'Notifications' link (Moodle 1.9) or the 'Home' link (Moodle 2.0)

5) Privileges to use the scheduler are currently based on custom defined capabilities (MRBS_Administrator, MRBS_Scheduler, and MRBS_Viewer).
Details about making use of these capabilities is found at: http://docs.moodle.org/en/MRBS_block#Installation

6) The MRBS block is primarily intended for use on the Moodle front page (it works on other pages, but note that each instance of the block links to the same set of bookings - it is not possible to create independent sets of bookings by adding the block to multiple pages)

* MRBS Block - Links *
Modules and Plugin entry is at: http://moodle.org/mod/data/view.php?d=13&rid=734
Documentation for the MRBS Block is available at: http://docs.moodle.org/en/MRBS_block
The tracker component is at: http://tracker.moodle.org/secure/IssueNavigator.jspa?reset=true&mode=hide&pid=10033&sorter/order=DESC&sorter/field=priority&resolution=-1&component=10216
Moodle 1.9 code is at: http://cvs.moodle.org/contrib/plugins/blocks/mrbs/
Moodle 2.0 code is at: http://github.com/davosmith/moodle-mrbs/

* MRBS Block - Suggestions *

Feel free to post comments, questions, suggestions, etc. pertaining to the use of MRBS block at http://moodle.org/mod/forum/discuss.php?d=38604 or email Anthony Borrow at arborrow@jesuits.net.

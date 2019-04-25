# BRMS (Building and Resident Management System)
BRMS is a 3 tier web system using L.A.M.P built for a class project.

## The Team:
Our Group Name for this project is *OutOfTheBoxProgramming*. The Team consists of:

* Matthew Hunt (https://github.com/hmatt33)
* Sean Boyle (https://github.com/seboy96)
* James Bowbliss (https://github.com/JBowbliss)
* Faye Lopez (https://github.com/lopezk8)

## Purpose of System:
The Team is just beginning on the implementation stage of the project. BRMS is a web system built with html,php,and mysql. This web system is meant to use a database and multiple tables to keep track of multiple different buildings, and the residents who live there. This system is meant to be used by the employees of a realestate company, the only ones who will have a valid login is an employee. This system should let the company add/remove/edit a building's information, as well as add/remove/edit a resident's information. The system will allow the user to select a building, and be able to see a list of all residents within that building.

## Current Progress:
* Login ability is done
* Logout ability is done
* display buildings page is done
    * edit buildings page is done
    * delete buildings page is done
* edit and delete columns added to all tables
    * edit and delete columns will be used to link to edit/delete pages for users, buildings, and residents
* ability to only show a certain number of rows on screen and create pages for the rest is done
* display users page is done
    * users page is admin only
    * checks to make sure user has admin status
    * admin is the only one able to create new users, edit/delete users
* FAQ page has been started
* Header has been updated to include admin links
* edit user is done
* adding new buildings is done
* adding new users is done
* deleting users and buildings is done
* ability for user to change password is done
* displaying residents is done
	* displaying residents only displays the residents in the building selected
* adding new residents is fully functional
* editing and deleting residents fully functional
* added more session data to login
* added check boxes to residents table so user can select multiple residents to email
* code to email multiple residents mostly finished but not fully tested
* code to email single residents is done but not fully tested
  * emails seem to need an smtp server in order to work with php mail(), but none of us are sure how to do that
  * email code seems to work but no actual email is sent without this smtp email server set up
* encrypted all passwords as they are saved into the database and had login and edit and change passwords check for encryption and encrypt any new changes
* fixed bug in admin page that kept updating session data when it was not supposed to

## Planned Additions:
* CSS styling for site
* Finish the FAQ page
* displaying all residents no matter the building
	* make this page be accessed from the header nav bar
* add a user info page where can see their own account information
  * move the change password button to the user info page


### Acknowledgments/References/Sources

* *Practical PHP and MySQL Website Databases: A Simplified Approach* by Adrian W. West

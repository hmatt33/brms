<!doctype html>
<html lang="en">
<head>
  <title>FAQ Page for BRMS System</title>
  <meta charset="utf-8">
</head>
<body>
  <div id="container" class="col-sm-12">
    <?php include('header.php'); ?>
    <div id="content">
      <br>
      <h2 class="text-center">____________________________________________________</h2>
      <h2 class="text-center">FAQ Page for BRMS System</h2>
      <br>

      <p>
        <b>Login:</b> Users of the system will be prompted with a login page upon their arrival to the site. Usernames and passwords are provided by their system admin to ensure validation and security.
      </p>

      <p>
        <b>Home Page:</b> After logging in users will be presented with a page displaying all of the buildings contained in the system along with all of the information on those buildings. Below this table is a button that can be used to add new buildings to the system <b>(1)</b>. Every entry to the buildings table has three buttons located at the right of the table: Show Residents <b>(2)</b>, Edit <b>(3)</b>, and Delete <b>(4)</b>. The header located at the top of every page contains links to navigate back to the home page, an FAQ page <b>(5)</b>, a page for administrators <b>(6)</b>, a page for users to change their password <b>(7)</b>, a button to view all residents <b>(14)</b>, and a button to logout.
        <p>

          <p>
            <b>Add New Building:</b> Once users click this button they will be taken to a page with fields to fill out regarding information about a new building. If the user tries to register a new building without filling out one of the fields they will be unable to add it and will be asked to fill in the missing information. If the user tries to add a building with the same name of an already existing building they will be asked to change it.
          </p>

          <p>
            <b>Show Residents:</b> Once users click this button they will be presented with a table containing all the residents living in the selected building and all of the information regarding those residents. To the right of the table is three buttons that exist for each resident: Email <b>(8)</b>, Edit <b>(9)</b>, and Delete <b>(4)</b>. Directly below the residents table is an Email Selected Residents button <b>(10)</b>, and below this is an Add New Resident button <b>(11)</b>.
          </p>

          <p>
            <b>(3) Edit Buildings:</b> Once users click this button they will be take to a page containing the same fields as the add new building page, but with all of the information already filled out for whatever building was selected. Users can make whatever changes they need to the building information then submit the changes. If the user does not make any changes and leaves all of the same information they will be given an error and will remain on the same page. If the user tries to submit a change with a field that is missing information then they will be given an error and taken back to the same page with all of the original building information filled out.
          </p>

          <p>
            <b>(4) Delete:</b> Any delete button that is pressed will bring the user to a page to confirm whether or not they want to delete whatever they selected. If they press yes the entry they selected will be removed from the system.
            <b>(5) FAQ Page:</b> This page will contain information regarding every feature of the system, what everything does and how to use it.
          </p>

          <p>
            <b>(6) Administrator Page:</b> Only users with administrator access will be able to access this page. This is where administrators will be able to view a table of all registered users of the system and all of their information. To the right of every table entry is two buttons: Edit <b>(12)</b> and Delete <b>(4)</b>. Directly below the table is an Add User button <b>(13)</b>.
          </p>

          <p>
            <b>(7) Change Password:</b> Users will be able to change their password by entering their current password, their new password, and entering their new password a second time. If the user leaves a field blank they will be given an error and asked to try again. If the user enters the wrong current password they will be given an error and asked to try again. If the two fields for the new password do not much they will be given an error and asked to try again.
          </p>

          <p>
            <b>(8) Email One Resident:</b> Once users click this button they will be brought to a page with the selected user’s email address filled out and fields to fill out that are necessary to sending an email. This feature is currently not fully functioning yet.
          </p>

          <p>
            <b>(9) Edit Resident:</b> Once users click this button they will be brought to a page with fields regarding all of the information of a resident, filled in with the selected resident’s information. Users can make whatever changes they need to the resident’s information then submit the changes. If the user does not make any changes and leaves all of the same information they will be given an error and will remain on the same page. If the user tries to submit a change with a field that is missing information then they will be given an error and taken back to the same page with all of the original resident information filled out.
          </p>

          <p>
            <b>(10) Email Selected Users:</b> Users who are on the show residents page can select the check boxes in the first column of the residents table then click this button to email multiple residents at once. They will be brought to the same email page as if the email one resident button was selected but with multiple email addresses entered to receive the email. If none or only one of the check boxes are selected when this button is pressed users will be given an error and asked to either select multiple users or use the email one user button. This feature is currently not fully functioning yet.
          </p>

          <p>
            <b>(11) Add New Resident:</b> Once users click this button they will be taken to a page with fields to fill out regarding information about a new resident. If the user tries to register a new resident without filling out one of the fields they will be unable to add it and will be asked to fill in the missing information. If the user tries to add a resident with the same name of an already existing resident they will be asked to change it. Whatever building’s resident page the user is on when adding a new resident will be the Building ID that is given to the new user.
          </p>

          <p>
            <b>(12) Edit Users:</b> Once administrators click this button they will be brought to a page with fields regarding all of the information of a user, filled in with the selected user’s information. Administrators can make whatever changes they need to the user’s information then submit the changes. If the administrator does not make any changes and leaves all of the same information they will be given an error and will remain on the same page. If the user tries to submit a change with a field that is missing information then they will be given an error and taken back to the same page with all of the original resident information filled out. If the administrator tries submit changes but the two password fields do not match they will be given an error and asked to fix it.
          </p>

          <p>
            <b>(13) Add Users:</b> Once administrators click this button they will be taken to a page with fields to fill out regarding information about a new user. If the administrator tries to register a new user without filling out one of the fields they will be unable to add it and will be asked to fill in the missing information.
          </p>

          <p>
            <b>(14) View All Residents:</b> When this is clicked a similar page to <b>(2)</b> Show Residents, but lists all residents in the system regardless of what building they are in. This is useful if the user wishes to see a large number of residents at once without having to go into individual buildings.
          </p>
          <footer>
            <?php include('footer.html'); ?>
          </footer>
        </div>
      </div>
    </body>
    </html>

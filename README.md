# Login splashpage #
When presenting a login page that contains a form - many users will ignore all links on the page, and just enter their username/password into the form, forgetting they should use a "Login with Microsoft" or "Login via SAML" button on the page.

This plugin provides a custom splash page that only shows the IDP/SSO buttons and (optionally) a link to the manual Moodle login form.

Once installed, set the alternateloginurl setting in moodle to yourmoodleurl/local/login/index.php 

Note: If you want users to be able to use the manual login form, a custom patch is required - see noredirectpatch.txt file in this repository for this.

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/local/login

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##

2022 Catalyst IT

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.

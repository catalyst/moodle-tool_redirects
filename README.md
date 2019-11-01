<a href="https://travis-ci.org/catalyst/moodle-tool_redirects">
<img src="https://travis-ci.org/catalyst/moodle-tool_redirects.svg?branch=master">
</a>

# Configurable redirects for Moodle

A very simple plugin which allows admin to set redirects based on url. 

## Configuration

* Navigate to Site Administration > Plugins > Admin tools > Redirects
* Add rules. Each line should be a redirect rule like [php regex of local moodle URL to redirect from]=>[any URL to redirect to]. E.g. #/my/#=>/course/view.php?id=2 
* Enable or disable redirects for administrators

## Backdoor option for Admins 
Admins can bypass redirect by adding **noredirect=1** parameter to requested URL. E.g. http://moodle.example.com/my/?noredirect=1

# Contributing and Support

Issues, and pull requests using github are welcome and encouraged!

https://github.com/catalyst/moodle-tool_redirects/issues

If you would like commercial support or would like to sponsor additional improvements
to this plugin please contact us:

https://www.catalyst-au.net/contact-us


# Crafted by Catalyst IT
This plugin was developed by Catalyst IT Australia:

https://www.catalyst-au.net/

<img alt="Catalyst IT" src="https://cdn.rawgit.com/CatalystIT-AU/moodle-auth_saml2/master/pix/catalyst-logo.svg" width="400">


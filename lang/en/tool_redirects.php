<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Lang strings.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Redirects';
$string['rules'] = 'Redirect settings';
$string['rules_desc'] = '<p>Each line should be a redirect rule like [php regex of URL to redirect from]=>[URL to redirect to]. Take care to escape / and . and ? in urls correctly, eg:</p>
<pre>
#\/my#=>/course/view.php?id=123
#\/course\/view\.php\?id=123#=>/some-target
#\/index\.php#=>/some-other-page
#\/index\.php#=>https://some.other.site.com/
</pre>

<p>You can redirect from pages which do not exist as long as you have error pages setup correctly, see:
<a href="https://docs.moodle.org/dev/Error_pages">https://docs.moodle.org/dev/Error_pages</a></p>
';
$string['redirectadmin'] = "Redirect administrators";
$string['redirectadmin_desc'] = "If enabled site administrators will be redirected as well as other users.";
$string['redirectwarning'] = '<p>This pages url matched a regex: <code>{$a->regex}</code> and so would have redirected to:<p>
<a href="{$a->target}">{$a->target}</a>
<p>You are seeing this because you are able to <a href="{$a->editurl}">edit the redirect configuration</a>.</p>';
$string['redirects:manage'] = 'Manage redirect rules';
$string['regex_error_too_short'] = 'RegEx too short';
$string['regex_error_malformed'] = 'Invalid (malformed) RegEx';
$string['privacy:metadata'] = 'The Redirects plugin does not store any personal data.';

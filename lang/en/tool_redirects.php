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
$string['rules_desc'] = "Each line should be a redirect rule like [php regex of URL to redirect from]=>[URL to redirect to]. E.g. /my/=>/course/view.php?id=2";
$string['redirectadmin'] = "Redirect administrators";
$string['redirectadmin_desc'] = "If enabled site administrators will be redirected as well as other users.";
$string['regex_error_too_short'] = 'RegEx too short';
$string['regex_error_malformed'] = 'Invalid (malformed) RegEx';

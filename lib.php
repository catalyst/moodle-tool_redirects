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
 * Lib file.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Redirect users based on configuration.
 *
 * This is a legacy callback that is used for compatibility with older Moodle versions.
 * Moodle 4.4+ will use tool_redirects\hook_callbacks::before_http_headers instead.
 *
 * @throws \moodle_exception
 */
function tool_redirects_before_http_headers() {
    \tool_redirects\helper::redirect_from_rules();
}

/**
 * Redirect users based on configuration.
 *
 * @throws \moodle_exception
 */
function tool_redirects_after_config() {
    \tool_redirects\helper::redirect_from_rules();
}


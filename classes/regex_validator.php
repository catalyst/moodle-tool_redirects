<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     tool_etl
 * @author      Daniel Thee Roperto <daniel.roperto@catalyst-au.net>
 * @copyright   2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

defined('MOODLE_INTERNAL') || die();

class regex_validator {
    /** @var string */
    private $regex;
    /** @var string */
    private $error = null;
    /** @var string */
    private $delimiter = null;
    /** @var string */
    private $contents = null;
    /** @var string */
    private $flags = null;
    /** @var string[] */
    private $options = [];

    public function __construct($regex, $options = array()) {
        if (!is_string($regex)) {
            throw new \coding_exception('Expecting regex to be a string');
        }

        $this->regex = $regex;
        $this->options = $options;

        // Empty regex allowed.
        if ($regex === '') {
            return;
        }
        $this->validate_syntax();
        $this->validate_length();
        $this->parse_parts();
    }

    public function is_valid() {
        return is_null($this->error);
    }

    public function get_error() {
        return is_null($this->error) ? null : get_string("regex_error_{$this->error}", 'tool_redirects');
    }

    private function validate_syntax() {
        if (!is_null($this->error)) {
            return;
        }
        if (@preg_match($this->regex, null) === false) {
            $this->error = 'malformed';
        }
    }

    private function validate_length() {
        if (!is_null($this->error)) {
            return;
        }
        if (strlen($this->regex) < 2) {
            $this->error = 'too_short';
        }
    }

    private function parse_parts() {
        $this->delimiter = $this->regex[0];
        $flags = strrchr($this->regex, $this->delimiter);
        $this->contents = substr($this->regex, 1, strlen($this->regex) - strlen($flags) - 1);
        $this->flags = (strlen($flags) == 1) ? '' : substr($flags, 1);
    }

}

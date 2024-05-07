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
 * Validate rule regexes
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

/**
 * Validate regex rules
 */
class regex_validator implements rule_validator_interface {
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

    /**
     * Create a new rule
     * @param string $regex
     * @param array $options
     */
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

    /**
     * Is this a valud rule regex
     * @return bool
     */
    public function is_valid() {
        return is_null($this->error);
    }

    /**
     * Get validation errors
     */
    public function get_error() {
        return is_null($this->error) ? null : get_string("regex_error_{$this->error}", 'tool_redirects');
    }

    /**
     * Validates the regex
     */
    private function validate_syntax() {
        if (!is_null($this->error)) {
            return;
        }
        if (@preg_match($this->regex, '') === false) {
            $this->error = 'malformed';
        }
    }

    /**
     * Validate length
     */
    private function validate_length() {
        if (!is_null($this->error)) {
            return;
        }
        if (strlen($this->regex) < 2) {
            $this->error = 'too_short';
        }
    }

    /**
     * Parse parts
     */
    private function parse_parts() {
        $this->delimiter = $this->regex[0];
        $flags = strrchr($this->regex, $this->delimiter);
        $this->contents = substr($this->regex, 1, strlen($this->regex) - strlen($flags) - 1);
        $this->flags = (strlen($flags) == 1) ? '' : substr($flags, 1);
    }

}

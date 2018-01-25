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
 * @package     tool_redirects
 * @author      Daniel Thee Roperto <daniel.roperto@catalyst-au.net>
 * @copyright   2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use tool_redirects\regex_validator;

defined('MOODLE_INTERNAL') || die();

class tool_redirects_regex_validator_test extends advanced_testcase {

    public function provider_for_test_it_validates_the_regex() {
        return [
            'Empty RegEx is valid.'            => ['', true],
            'RegEx is too short'               => ['//', true],
            'Capture-all RegEx is valid.'      => ['/^(.*)$/', true],
            'Ignore case flag is valid.'       => ['/^(.*)$/i', true],
            'RegEx is too short.'              => ['.', false],
            'RegEx must match beginning.'      => ['/(.*)$/', true],
            'RegEx must match end.'            => ['/^(.*)/', true],
            'RegEx must have a capture group.' => ['/^.*$/', true],
            'Malformed RegEx.'                 => ['/^a(.*b$/', false],
        ];
    }

    /**
     * @dataProvider provider_for_test_it_validates_the_regex
     */
    public function test_it_validates_the_regex($regex, $acceptable) {
        $validator = new regex_validator($regex);
        $error = $validator->get_error();
        self::assertSame($acceptable, $validator->is_valid(), "{$regex} -> {$error}");
    }

    public function provider_for_test_it_throws_exception_if_regex_is_not_string() {
        return [
            [array(1)],
            [new stdClass()],
            [1],
        ];
    }

    /**
     * @dataProvider provider_for_test_it_throws_exception_if_regex_is_not_string
     * @expectedException coding_exception
     * @expectedExceptionMessage Expecting regex to be a string
     */
    public function test_it_throws_exception_if_regex_is_not_string($regex) {
        $validator = new regex_validator($regex);
    }
}

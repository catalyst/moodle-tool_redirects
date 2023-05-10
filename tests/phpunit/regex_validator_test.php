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
 * Tests
 *
 * @package     tool_redirects
 * @author      Daniel Thee Roperto <daniel.roperto@catalyst-au.net>
 * @copyright   2018 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

use tool_redirects\regex_validator;

/**
 * Tests
 */
class regex_validator_test extends \advanced_testcase {

    /**
     * Provider
     */
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
     * Provider
     * @dataProvider provider_for_test_it_validates_the_regex
     * @param string $regex
     * @param bool $acceptable
     */
    public function test_it_validates_the_regex($regex, $acceptable) {
        $validator = new regex_validator($regex);
        $error = $validator->get_error();
        self::assertSame($acceptable, $validator->is_valid(), "{$regex} -> {$error}");
    }

    /**
     * Provider
     */
    public function provider_for_test_it_throws_exception_if_regex_is_not_string() {
        return [
            [array(1)],
            [new \stdClass()],
            [1],
        ];
    }

    /**
     * Test
     * @dataProvider provider_for_test_it_throws_exception_if_regex_is_not_string
     * @param string $regex
     */
    public function test_it_throws_exception_if_regex_is_not_string($regex) {
        $this->expectException(\moodle_exception::class);
        $validator = new regex_validator($regex);
    }
}

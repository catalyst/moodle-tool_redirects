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
 * Redirect rule class.
 *
 * @package    tool_redirects
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @copyright  2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects;

defined('MOODLE_INTERNAL') || die();

class rule_config {
    /**
     * Rule regex string.
     *
     * @var string
     */
    protected $regex = '';

    /**
     * URL to redirect to.
     *
     * @var string
     */
    protected $redirecturl = '';

    /**
     * Enabled?
     *
     * @var bool
     */
    protected $enabled = true;

    /**
     * Should we redirect admins?
     *
     * @var bool
     */
    protected $redirectadmin = false;

    /**
     * Constructor.
     *
     * @param array $data Config data for a rule.
     */
    public function __construct(array $data) {
        foreach ($data as $name => $value) {
            if (array_key_exists($name, get_object_vars($this))) {
                $this->$name = $value;
            }
        }
    }

    /**
     * Magic method to get property.
     *
     * @param string $name Name of the required property.
     *
     * @return mixed
     * @throws \coding_exception
     */
    public function __get($name) {
        if (!array_key_exists($name, get_object_vars($this))) {
            throw new \coding_exception('Invalid property ' . $name);
        }

        return $this->$name;
    }

}

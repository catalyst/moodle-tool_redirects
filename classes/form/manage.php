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
 * Form to manage redirect rules.
 *
 * @package    tool_redirects
 * @author     Benjamin Walker <benjaminwalker@catalyst-au.net>
 * @copyright  2024, Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirects\form;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

/**
 * Manage redirects form.
 */
class manage extends \moodleform {
    /** @var array config settings attached to the form */
    protected const FORM_CONFIG = [
        'rules',
    ];

    /** @var array config */
    protected $config;

    /**
     * Form definition
     *
     * @return void
     */
    public function definition(): void {
        global $CFG, $DB, $USER;

        $mform = $this->_form;

        // Rules.
        $mform->addElement('textarea', 'rules', get_string('rules', 'tool_redirects'), ['cols' => 60, 'rows' => 8]);
        $mform->setType('rules', PARAM_RAW);
        $mform->addElement('static', 'rules_help', '', get_string('rules_desc', 'tool_redirects'));

        $this->add_action_buttons(false);
    }

    /**
     * Loads the current values of the form config.
     * @return void
     */
    public function load_form_config(): void {
        $config = [];
        foreach (self::FORM_CONFIG as $name) {
            $config[$name] = get_config('tool_redirects', $name);
        }

        // Save empty config values but don't set them. Needed for comparisons.
        $this->config = $config;
        $this->set_data(array_filter($config));
    }

    /**
     * Saves the new form data to config.
     * @param \stdClass $data submitted data
     * @return void
     */
    public function save_form_config(\stdClass $data): void {
        foreach ($data as $key => $value) {
            if (in_array($key, self::FORM_CONFIG) && $value !== $this->config[$key]) {
                set_config($key, $value, 'tool_redirects');
                add_to_config_log($key, (string) $this->config[$key], $value, 'tool_redirects');
            }
        }
    }
}

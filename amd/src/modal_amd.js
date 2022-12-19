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
 * Modal AMD module.
 *
 * @module     block_superframe/modal_amd
 * @copyright  Richard Jones  richardnz@outlook.com
 * @copyright  2022 G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import $ from 'jquery';
import ModalFactory from 'core/modal_factory';
import {get_strings as getStrings} from 'core/str';
import Notification from 'core/notification';

export const init = () => {
    var trigger = $('#block_superframe_about');

    var strings = [
        {
            key: 'about',
            component: 'block_superframe'
        },
        {
            key: 'modalbody',
            component: 'block_superframe'
        },
        {
            key: 'modalfooter',
            component: 'block_superframe'
        }
    ];

    /* Refs: https://docs.moodle.org/dev/Javascript/Coding_Style and
             https://moodledev.io/docs/4.1/guides/javascript#working-with-strings
             admin/tool/dataprivacy/amd/src/categoriesactions.js */
    getStrings(strings).then(function(langStrings) {
        var title = langStrings[0];
        var body = langStrings[1];
        var footer = langStrings[2];
        ModalFactory.create({
            title: title,
            body: '<p>' + body + '</p>',
            footer: '<p>' + footer + '</p>'
        }, trigger).done(function(modal) {
            // Do what you want with your new modal.
            modal.setLarge();
        });
    }).fail(Notification.exception);
};

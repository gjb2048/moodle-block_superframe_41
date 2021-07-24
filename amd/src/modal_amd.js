import $ from 'jquery';
import ModalFactory from 'core/modal_factory';
export const init = (data) => {
    var trigger = $('#block_superframe_about');
    ModalFactory.create({
        title: data.title,
        body: '<p>' + data.body + '</p>',
        footer: '<p>' + data.footer + '</p>'
    }, trigger).done(function(modal) {
        // Do what you want with your new modal.
        modal.setLarge();
    });
};

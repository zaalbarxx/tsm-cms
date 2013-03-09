/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */


CKEDITOR.editorConfig = function (config) {
    config.toolbar_Custom =
        [
            { name:'document', items:[ 'Source'] },
            { name:'clipboard', items:[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name:'editing', items:[ 'SpellChecker', 'Scayt' ] },
            { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
            { name:'links', items:[ 'Link', 'Unlink', 'Anchor', 'Image', 'Table', 'HorizontalRule' ] },
            '/',
            { name:'paragraph', items:[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv',
                '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
            { name:'insert', items:[  ] },
            '/',
            { name:'styles', items:[ 'Styles', 'Format', 'Font', 'FontSize' ] },
            { name:'colors', items:[ 'TextColor', 'BGColor' ] },
            { name:'tools', items:[ 'Maximize', 'ShowBlocks', '-', 'About' ] }
        ];
    config.toolbar = 'Custom'
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
};

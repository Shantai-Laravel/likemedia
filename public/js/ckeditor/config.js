/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
var roxyFileman = '/js/ckeditor/fileman/index.html';

CKEDITOR.editorConfig = function( config ) {
    config.filebrowserBrowseUrl = roxyFileman;
    config.filebrowserImageBrowseUrl = roxyFileman+'?type=image';
    config.removeDialogTabs = 'link:upload;image:upload';
    config.height = 350;

    config.toolbar = [
        { name: 'document',    items: [ 'Source', '-',  'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
        { name: 'clipboard',   items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-','Undo', 'Redo' ] },
        { name: 'editing',     items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
        { name: 'insert',      items: [ 'CreatePlaceholder', 'Image', 'Flash', 'Table', 'HorizontalRule', 'PageBreak', 'Iframe', 'InsertPre' ] },
        '/',
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
        { name: 'paragraph',   items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr', 'BidiRtl' ] },
        { name: 'links',       items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'tools',       items: [ 'UIColor', 'Maximize', 'ShowBlocks' ] },
        '/',
        { name: 'styles',      items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
        { name: 'colors',      items: [ 'TextColor', 'BGColor' ] },
        { name: 'forms',       items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] }

    ];
};

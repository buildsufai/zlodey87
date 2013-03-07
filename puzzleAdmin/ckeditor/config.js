/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.language = 'ru';
    //	 config.uiColor = '#AADC6E';
    config.filebrowserBrowseUrl = '/puzzleAdmin/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/puzzleAdmin/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = '/puzzleAdmin/ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl = '/puzzleAdmin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/puzzleAdmin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/puzzleAdmin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};

/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	  //  config.filebrowserBrowseUrl = 'assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
   // config.filebrowserImageBrowseUrl = 'assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
   // config.filebrowserFlashBrowseUrl = 'assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = 'assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = 'assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = 'assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
};

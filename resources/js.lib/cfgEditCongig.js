/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

//  CKEDITOR.editorConfig = function( config ) {
// 	// Define changes to default configuration here. For example:
// 	// config.language = 'fr';
// 	// config.uiColor = '#AADC6E';
        
//     // config.removeDialogTabs = 'image:advanced;link:advanced';
//     config.filebrowserUploadUrl = '/js/ckeditor.4.5.11/upload.php';        

//     // config.language = 'ru';
//     config.filebrowserUploadMethod = 'form';
//     // config.extraPlugins = 'uploadimage';
//     // config.filebrowserUploadUrl = '/ckeditor/upload.php?type=Files';
//     config.filebrowserBrowseUrl = '/ckeditor/browse.php?type=Files';

// };

CKEDITOR.replace( 'editor' , 
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        
    // config.removeDialogTabs = 'image:advanced;link:advanced';
    filebrowserUploadUrl : '/ckeditor-upload',        

    // config.language = 'ru';
    filebrowserUploadMethod: 'form',
    // config.extraPlugins = 'uploadimage';
    // config.filebrowserUploadUrl = '/ckeditor/upload.php?type=Files';
    filebrowserBrowseUrl: '/ckeditor/browse.php?type=Files',

} );


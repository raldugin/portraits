/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// Register a templates definition set named "default".
CKEDITOR.addTemplates( 'default', {
	// The name of sub folder which hold the shortcut preview images of the
	// templates.
	imagesPath: CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	// The templates definitions.
	templates: [
        {
            title: 'Museum News',
            //image: 'template1.gif',
            description: 'News+Anons',
            html:
            // ----------- heading section -----------
			'<div class="sectionСontainer_Inside_Content_Header">' +
            'Колядники в музеї' +
			'</div>' +
            // ------------ Date section ------------
			'<div class="sectionСontainer_Inside_Content_Date">' +
			'12 січня' +
			'</div>' +
			'<div class="sectionСontainer_Inside_Text">' +
            // ------------ Leed section ------------
			'<div class="sectionСontainer_Inside_Text_Leed">' +
			'Сьогодні в музеї школярі відзначили День знань.' +
			'</div>' +
			// ---------- carousel section ----------
			'<div class="carouselHalfWidth carouselHalfWidth_Left">' +
			'<?= $carousel_content ?>' +
			'</div>'+
			// ---------- First text section ----------
			'<p>'+
			'Текст до панорамы' +
			'</p>'+
            // ---------- Panorama Img section ---------
			// contenteditable="false" - запрещает пользователю редактировать елемент и его содержимое
            '<div class="panoramaImg">' +
			'<?= $panoramaImg ?>' +
            'Фото панорамы' +
			'</div>'+
            // ---------- Second text section ----------
            '<p>'+
            'Текст после панорамы' +
            '</p>'+

			'</div>'
        },

		{
		title: 'Image and Title',
		image: 'template1.gif',
		description: 'One main image with a title and text that surround the image.',
		html:
			'<h3>' +
			// Use src=" " so image is not filtered out by the editor as incorrect (src is required).
			'<img src=" " alt="" style="margin-right: 10px" height="100" width="100" align="left" />' +
			'Type the title here' +
			'</h3>' +
			'<p>' +
			'Type the text here' +
			'</p>'
	},
	{
		title: 'Strange Template',
		image: 'template2.gif',
		description: 'A template that defines two columns, each one with a title, and some text.',
		html: '<table cellspacing="0" cellpadding="0" style="width:100%" border="0">' +
			'<tr>' +
				'<td style="width:50%">' +
					'<h3>Title 1</h3>' +
				'</td>' +
				'<td></td>' +
				'<td style="width:50%">' +
					'<h3>Title 2</h3>' +
				'</td>' +
			'</tr>' +
			'<tr>' +
				'<td>' +
					'Text 1' +
				'</td>' +
				'<td></td>' +
				'<td>' +
					'Text 2' +
				'</td>' +
			'</tr>' +
			'</table>' +
			'<p>' +
			'More text goes here.' +
			'</p>'
	},
	{
		title: 'Text and Table',
		image: 'template3.gif',
		description: 'A title with some text and a table.',
		html: '<div style="width: 80%">' +
			'<h3>' +
				'Title goes here' +
			'</h3>' +
			'<table style="width:150px;float: right" cellspacing="0" cellpadding="0" border="1">' +
				'<caption style="border:solid 1px black">' +
					'<strong>Table title</strong>' +
				'</caption>' +
				'<tr>' +
					'<td>&nbsp;</td>' +
					'<td>&nbsp;</td>' +
					'<td>&nbsp;</td>' +
				'</tr>' +
				'<tr>' +
					'<td>&nbsp;</td>' +
					'<td>&nbsp;</td>' +
					'<td>&nbsp;</td>' +
				'</tr>' +
				'<tr>' +
					'<td>&nbsp;</td>' +
					'<td>&nbsp;</td>' +
					'<td>&nbsp;</td>' +
				'</tr>' +
			'</table>' +
			'<p>' +
				'Type the text here' +
			'</p>' +
			'</div>'
	} ]
} );

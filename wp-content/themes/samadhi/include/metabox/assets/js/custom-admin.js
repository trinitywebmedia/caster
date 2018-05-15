/**
 * This script adds the custom jquery to admin in Samadhi Theme.
 *
 * @package Samadhi\JS
 * @author ZigzagPress
 * @license GPL-2.0+
 */
 
jQuery( function ($) {
	// Composer page metaboxes behaviour.
	function sectionMetabox() {
		$('select[name*="[zpmeta_section_block_select]"]').each(function() {
			var trigger = $(this),
				blockPanel = trigger.closest('.cmb-repeatable-grouping'),
					
				defVal = trigger.find('option[value="none"]'),
				portfolio = trigger.find('option[value="portfolio"]'),
				headerText = trigger.find('option[value="header_text"]'),
				customShortcode = trigger.find('option[value="block_custom_shortcode"]'),
				columnBlocks = trigger.find('option[value="column_blocks"]'),
				sliderBlocks = trigger.find('option[value="slider"]'),
				heroBlocks = trigger.find('option[value="hero_image"]'),
				splitBlocks = trigger.find('option[value="column_split"]'),
				hiddenClass = 'visuallyhidden';
				blockPanel.find('.cmb-repeat-group-field').addClass(hiddenClass);
				blockPanel.find('[class*="section-more-trigger"], [class*="section-block-select"]').removeClass(hiddenClass);
				blockPanel.find('[class*="section-col-block"]').addClass(hiddenClass);
		    	blockPanel.find('[class*="section-col-block-2"]').addClass(hiddenClass);
		    	blockPanel.find('[class*="section-col-block-3"]').addClass(hiddenClass);
		    	blockPanel.find('[class*="section-col-block-4"]').addClass(hiddenClass);
			   if ( defVal.is(':selected') ) {
			   		blockPanel.find('[class*="section-more-trigger"], [class*="section-block-select"]').removeClass(hiddenClass);
			    } else if ( portfolio.is(':selected') ) {
			    	blockPanel.find('[class*="section-portfolio"]').removeClass(hiddenClass);
			    }else if ( headerText.is(':selected') ) { 
			    	blockPanel.find('[class*="section-header-text"]').removeClass(hiddenClass);
			    }else if ( customShortcode.is(':selected') ) {
			    	blockPanel.find('[class*="section-custom-shortcode"]').removeClass(hiddenClass);
			    }else if ( columnBlocks.is(':selected') ) {
			    	blockPanel.find('[class*="section-col-block"]').removeClass(hiddenClass);
			    	blockPanel.find('[class*="section-col-block-2"]').removeClass(hiddenClass);
			    	blockPanel.find('[class*="section-col-block-3"]').removeClass(hiddenClass);
			    	blockPanel.find('[class*="section-col-block-4"]').removeClass(hiddenClass);
			    }else if ( sliderBlocks.is(':selected') ) {
			    	blockPanel.find('[class*="section-slider"]').removeClass(hiddenClass);
			    }else if ( heroBlocks.is(':selected') ) {
			    	blockPanel.find('[class*="section-hero"]').removeClass(hiddenClass);
			    }else if ( splitBlocks.is(':selected') ) {
			    	blockPanel.find('[class*="section-split"]').removeClass(hiddenClass);
			    }
		});
	}
	sectionMetabox();
	$('#zpmeta_section_block_repeat').on('change', 'select[name*="[zpmeta_section_block_select]"]', sectionMetabox );
	$(document).on( 'click', '.cmb-shift-rows', sectionMetabox );
	$(document).on('click', '.cmb-add-group-row', sectionMetabox );
	// Show more options.
	function togglePanel() {
		var trigger = $(this),
			blockPanel = trigger.closest('.cmb-repeatable-grouping'),
			notToHide = '[class*="section-block-select"], [class*="section-more-trigger"], .cmb-group-title, .cmb-remove-field-row',
			togglingItems = blockPanel.find('.cmb-nested').find('.cmb-row').not(notToHide);
		if ( blockPanel.hasClass('expanded') ) {
		    blockPanel.removeClass('expanded').addClass('compressed');
		    togglingItems.hide();
		    if ( trigger.is('.more-trigger') ) {
		    	trigger.text(passed_data.closedString) // vars are stored in functions.php - original string is metbox/cmb2-functions.php
		    } else {
		    	blockPanel.find('.more-trigger').text(passed_data.closedString)
		    }
		}  else if ( blockPanel.hasClass('compressed') ) {
		    blockPanel.removeClass('compressed').addClass('expanded');
		    togglingItems.fadeIn();
		    if ( trigger.is('.more-trigger') ) {		    
		    	trigger.text(passed_data.expandedString) // vars are stored in functions.php - original string is metbox/cmb2-functions.php
		    } else {
		    	blockPanel.find('.more-trigger').text(passed_data.expandedString)
		    }
		} else {
		    blockPanel.addClass('expanded');
		    togglingItems.fadeIn();
		    if ( trigger.is('.more-trigger') ) {		    
		    	trigger.text(passed_data.expandedString) // vars are stored in functions.php - original string is metbox/cmb2-functions.php
		    } else {
		    	blockPanel.find('.more-trigger').text(passed_data.expandedString)
		    }
		}
	}
	$('#zpmeta_section_block_repeat').on('click', '.more-trigger', togglePanel );
	// Hides columns by default.
	function columnHide(){
		var blockPanel = $('.cmb-repeatable-grouping'),
			columnSelect = blockPanel.find('select[name*="[zpmeta_section_col_block_column]"] option:selected');
			hiddenClass = 'visuallyhidden',
			columnVal = columnSelect.val();
    	blockPanel.find('[class*="col-block-1"]').not('[class*="col-block-1-label"]').each(function(){
    		var blockThis = $(this);
      			blockThis.addClass(hiddenClass);
    	});
    	blockPanel.find('[class*="col-block-2"]').not('[class*="col-block-2-label"]').each(function(){
    		var blockThis = $(this);
   			blockThis.addClass(hiddenClass);
    	});
    	blockPanel.find('[class*="col-block-23"]').not('[class*="col-block-3-label"]').each(function(){
    		var blockThis = $(this);
   			blockThis.addClass(hiddenClass);
    	});
    	blockPanel.find('[class*="col-block-4"]').not('[class*="col-block-4-label"]').each(function(){
    		var blockThis = $(this);
    			blockThis.addClass(hiddenClass);
    	});
	}
	columnHide();
	$(document).on('click', '.cmb-add-group-row', columnHide );
	
	// Column show trigger.
	function columnPanel(){
		var trigger = $(this),
			blockPanel = trigger.closest('.cmb-repeatable-grouping'),
			hiddenClass = 'visuallyhidden';
			colID = trigger.attr('id');
    	blockPanel.find('[class*="'+colID+'"]').not('[class*="'+colID+'-label"]').each(function(){
    		var blockThis = $(this);
    		if( blockThis.hasClass( hiddenClass ) ){
    			blockThis.removeClass(hiddenClass);
    		}else{
    			blockThis.addClass(hiddenClass);
    		}
    	});
	}
	$('#zpmeta_section_block_repeat').on('click', '.column-trigger', columnPanel );
	// Portfolio Option.	
	var portfolioType = $('#zpmeta_portfolio_single_linktype').val();
	if( portfolioType == 'lightbox' ){
		$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-images"]').show();
		$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-external"]').hide();
	}else if( portfolioType == 'external' ){
		$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-external"]').show();
		$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-images"]').hide();
	}else if( portfolioType == 'single_portfolio' ){
		$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-external"]').hide();
		$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-images"]').show();
	}
	$('#zpmeta_portfolio_metabox').on('change', '#zpmeta_portfolio_single_linktype', function(){
		var portfolioType = $(this).val();
		if( portfolioType == 'lightbox' ){
			$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-images"]').show();
			$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-external"]').hide();
		}else if( portfolioType == 'external' ){
			$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-external"]').show();
			$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-images"]').hide();
		}else if( portfolioType == 'single_portfolio' ){
			$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-external"]').hide();
			$('#zpmeta_portfolio_metabox').find('[class*="portfolio-single-images"]').show();
		}
	});
});
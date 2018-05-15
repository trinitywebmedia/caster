<?php
/**
 * Samadhi.
 *
 * This defines the section composer functions for use in the Samadhi Theme.
 *
 * @package Samadhi
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    https://zigzagpress.com/downloads/samadhi/
 */

/**
 * Portfolio Block Function
 *
 * This renders the markup of portfolio block.
 *
 * @param integer $entry - entry ID.
 * @param integer $section_id - section ID.
 * @return an HTML layout of portfolio block.
 */
function zp_section_portfolio( $entry, $section_id ){
	$portfolio_layout = cmb2_get_meta( $entry, 'zpmeta_section_portfolio_layout' );
	$portfolio_id = cmb2_get_meta( $entry, 'zpmeta_section_block' );
	$padding_top = cmb2_get_meta( $entry, 'zpmeta_section_portfolio_layout_padding_top' );
	$padding_bottom = cmb2_get_meta( $entry, 'zpmeta_section_portfolio_layout_padding_bottom' );
	$padding_top = ( $padding_top ) ? 'padding-top:' . $padding_top . 'px;' : '';
	$padding_bottom = ( $padding_bottom ) ? 'padding-bottom:' . $padding_bottom . 'px;' : '';
	$background_color = cmb2_get_meta( $entry, 'zpmeta_section_portfolio_bgcolor' );
	$background_image = cmb2_get_meta( $entry, 'zpmeta_section_portfolio_bgimage' );
	$overlay = cmb2_get_meta( $entry, 'zpmeta_section_portfolio_overlay' );
	$opacity = cmb2_get_meta( $entry, 'zpmeta_section_portfolio_opacity' );

	echo '<div class="portfolio_container hero_fullwidth" style="' . $padding_top . $padding_bottom . '" >';
		if( $background_image != '' ){
			echo '<div class="portfolio_block_image" style="background-image: url(' . $background_image . ');"></div>';
			echo '<div class="portfolio_image_overlay" style="background-color: ' . $overlay . '; opacity: ' . $opacity . '"></div>';
		}else{
			echo '<div class="portfolio_block_image" style="background-color: ' . $background_color . '; "></div>';
		}
		echo  '<div class="portfolio_section_content">'. do_shortcode( '[zp_portfolio layout="' . $portfolio_layout . '"]' ).'</div>';
	echo '</div>';
}

/**
 * Header Text Block Function
 *
 * This renders the markup of header text block.
 *
 * @param integer $entry - entry ID.
 * @param integer $section_id - section ID.
 * @return an HTML layout of header text block.
 */
function zp_section_header_text( $entry, $section_id ){
	$header_title = cmb2_get_meta( $entry, 'zpmeta_section_header_text_title' );
	$header_subtitle = cmb2_get_meta( $entry, 'zpmeta_section_header_text_subtitle' );
	$header_content = cmb2_get_meta( $entry, 'zpmeta_section_header_text_content' );
	$header_alignment = cmb2_get_meta( $entry, 'zpmeta_section_header_text_alignment' );
	$padding_top = cmb2_get_meta( $entry, 'zpmeta_section_header_text_padding_top' );
	$padding_bottom = cmb2_get_meta( $entry, 'zpmeta_section_header_text_padding_bottom' );
	$padding_top = ( $padding_top ) ? 'padding-top:' . $padding_top . 'px;' : '';
	$padding_bottom = ( $padding_bottom ) ? 'padding-bottom:' . $padding_bottom . 'px;' : '';


	$background_color = cmb2_get_meta( $entry, 'zpmeta_section_header_text_bgcolor' );
	$text_color = cmb2_get_meta( $entry, 'zpmeta_section_header_text_textcolor' );

	if( $text_color ){
		$text_color = 'color:'.$text_color.';';
	}

	if( $background_color ){
		$background_color = 'background-color:'.$background_color.';';
	}
	
	if( $header_alignment == 'center' ){
		$alignment = 'header_text_center';
	}elseif( $header_alignment == 'left' ){
		$alignment = 'header_text_left';
	}elseif( $header_alignment == 'right' ){
		$alignment = 'header_text_right';
	}

	echo '<div class="section_header_text hero_fullwidth '.$alignment.'" style="text-align: ' . $header_alignment . '; ' . $padding_top . $padding_bottom .$background_color.$text_color.'">';
		echo  '<div class="section_header_wrap">';
			
			if( $header_title )
				echo '<h2>' . $header_title . '</h2>';
			
			if( $header_subtitle )
				echo '<p>' . do_shortcode( $header_subtitle ) . '</p>';
			
			if( $header_content )
				echo '<p class="intro">' . do_shortcode( $header_content ) . '</p>';
		echo '</div>';
	echo '</div>';
}

/**
 * Hero Image Block Function
 *
 * This renders the markup of hero image block.
 *
 * @param integer $entry - entry ID.
 * @param integer $section_id - section ID.
 * @return an HTML layout of hero image block.
 */
function zp_section_hero_image( $entry, $section_id ){
	global $post;
	$wrap = cmb2_get_meta( $entry, 'zpmeta_section_hero_wrap' );
	$top = cmb2_get_meta( $entry, 'zpmeta_section_hero_padding_top' );
	$bottom = cmb2_get_meta( $entry, 'zpmeta_section_hero_padding_bottom' );
	$top = ( $top ) ? 'padding-top:' . $top . 'px;' : '';
	$bottom = ( $bottom ) ? 'padding-bottom:' . $bottom . 'px;' : '';

	echo '<div class="hero_image_wrap hero_' . $wrap . '" style="'.$top.$bottom.'">';
		$title = cmb2_get_meta( $entry, 'zpmeta_section_hero_title' );
		$desc = cmb2_get_meta( $entry, 'zpmeta_section_hero_desc' );
		$label = cmb2_get_meta( $entry, 'zpmeta_section_hero_label' );
		$link = cmb2_get_meta( $entry, 'zpmeta_section_hero_link' );
		$bgcolor = cmb2_get_meta( $entry, 'zpmeta_section_hero_bgcolor' );
		$color = cmb2_get_meta( $entry, 'zpmeta_section_hero_textcolor' );
		$bgimage = cmb2_get_meta( $entry, 'zpmeta_section_hero_bgimage' );
		$overlay = cmb2_get_meta( $entry, 'zpmeta_section_hero_overlay' );
		$opacity = cmb2_get_meta( $entry, 'zpmeta_section_hero_opacity' );
		$alignment = cmb2_get_meta( $entry, 'zpmeta_section_hero_content_alignment' );
		if( 'center' == $alignment ){
			$align = 'hero_center';
		}else if( 'left' == $alignment ){
			$align = 'hero_left';
		}else if( 'right' == $alignment ){
			$align = 'hero_right';
		}else{
			$align = 'hero_center';
		}
		if( $bgimage != '' ){
			echo '<div class="hero_block_image '.$align.'" style="background-image: url(' . $bgimage . '); color: ' . $color . '">';
			echo '<div class="hero_image_overlay" style="background-color: ' . $overlay . '; opacity: ' . $opacity . '"></div>';
		}else{
			echo '<div class="hero_block_image '.$align.'" style="background-color: ' . $bgcolor . '; color: ' . $color . '">';
		}
			echo '<div class="hero_block hero_entry_' . $post->ID . '">';
				echo '<div class="hero_block_content">';		
					if( $title ){
						echo '<h3 class="hero_block_title">' . $title . '</h3>';					
					}
					if( $desc ){
						echo '<span class="hero_block_desc">' . do_shortcode( $desc ) . '</span>';
					}
					if( $link ){
						echo '<a class="button" href="' . $link . '">' . $label . '</a>';
					}
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

/**
 * Column Split Block Function
 *
 * This renders the markup of column split block.
 *
 * @param integer $entry - entry ID.
 * @param integer $section_id - section ID.
 * @return an HTML layout of column split block.
 */
function zp_section_column_split( $entry, $section_id ){
	global $post;
	$wrap = cmb2_get_meta( $entry, 'zpmeta_section_split_layout' );
	$padding_top = cmb2_get_meta( $entry, 'zpmeta_section_split_padding_top' );
	$padding_bottom = cmb2_get_meta( $entry, 'zpmeta_section_split_padding_bottom' );
	$padding_top = ( $padding_top ) ? 'padding-top:' . $padding_top . 'px;' : '';
	$padding_bottom = ( $padding_bottom ) ? 'padding-bottom:' . $padding_bottom . 'px;' : '';
	$background_color = cmb2_get_meta( $entry, 'zpmeta_section_split_bgcolor' );
	$text_color = cmb2_get_meta( $entry, 'zpmeta_section_split_textcolor' );

	$layoutwrap = cmb2_get_meta( $entry, 'zpmeta_section_split_wrap' );

	$images = cmb2_get_meta( $entry, 'zpmeta_section_split_sliderimages' );
	$video = esc_url( cmb2_get_meta( $entry, 'zpmeta_section_split_video' ) );
	$height = cmb2_get_meta( $entry, 'zpmeta_section_split_height' );


	if( $text_color ){
		$text_color = 'color:'.$text_color.';';
	}

	if( $background_color ){
		$background_color = 'background-color:'.$background_color.';';
	}
	if( $height != ''){
		$height = 'height:'.$height.'px';
	}

	echo '<div class="column_split_block_wrap column_' . $wrap . ' custom_' . $layoutwrap . ' " style="' . $padding_top . $padding_bottom . $height. '">';
		$title = cmb2_get_meta( $entry, 'zpmeta_section_split_title' );
		$subtitle = cmb2_get_meta( $entry, 'zpmeta_section_split_subtitle' );
		$desc = cmb2_get_meta( $entry, 'zpmeta_section_split_desc' );
		$label = cmb2_get_meta( $entry, 'zpmeta_section_split_label' );
		$link = cmb2_get_meta( $entry, 'zpmeta_section_split_link' );
		$bgimage = cmb2_get_meta( $entry, 'zpmeta_section_split_bgimage' );

			if( $images ){
				echo '<div class="column_split_block_slider">';
					echo '<div class="split_slider_wrap">';
						$script = '<script type="text/javascript">
							jQuery(function( $ ){
								$(window).load( function(){
							    $("#split_slider_' . $section_id . '").fadeIn(500);
							      // carousel
							      _slider   = $("#split_slider_' . $section_id . '"),
							      _smargin     = _slider.data("margin"),
							      _scenter     = _slider.data("center"),
							      _sitem     = _slider.data("item"),
							      _sautoW    = _slider.data("autowidth"),
							      _sslideby    = _slider.data("slideby"),
							      _sauto     = _slider.data("auto"),
							      _sshowdot    = _slider.data("showdot"),
							      _sshownav    = _slider.data("nav"),
							      _sanimateIn  = _slider.data("animatein"),
							      _sanimateOut = _slider.data("animateout"),
							      _sloop   = _slider.data("loop"),
							      _slazyLoad   = _slider.data("lazy");
							     _slider.owlCarousel({
							          margin: _smargin,
							          loop: _sloop,
							          autoWidth:_sautoW,
							          center: _scenter,
							          animateIn: _sanimateIn,
							          animateOut: _sanimateOut,
							          slideSpeed : 300,
							              paginationSpeed : 400,
							          items: _sitem,
							          autoplay: _sauto,
							          responsiveClass:true,
							          navText:["",""],
							          slideBy:_sslideby,
							          dots:_sshowdot, 
							          nav:_sshownav,
							          responsive:{
							              0:{
							                  items:_sitem,
							                  nav:_sshownav
							              },
							              480:{
							                  items:_sitem,
							                  nav:_sshownav
							              },
							              769:{
							                  items:_sitem,
							                  nav:_sshownav 
							              }
							          }
							      });	      
								});
							});
						</script>';
						echo $script . '<div id="split_slider_' . $section_id . '"" class="split_slider owl-carousel owl-center"  data-item="1" data-center="false" data-margin="0" data-autowidth="false" data-slideby="1" data-showdot="true" data-nav="false" data-loop="false" data-lazy="true">';
							foreach ( (array) $images as $attachment_id => $attachment_url ) {
								echo '<div class="carousel-item">';
					        	// /echo '<div class="split_slider_overlay"></div>';
					        	$slide_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					        	echo '<div class="split_slider_image" style="background-image: url('.$slide_image[0].')"></div>';
						       // echo wp_get_attachment_image( $attachment_id, 'full' );
						        echo '</div>';
							}

					    echo '</div>';

					echo '</div>';
				echo '</div>';
			}elseif( $video ){
				echo '<div class="column_split_block_video">';
					echo '<div class="split_video_wrap split_video">';
						echo '<div class="column_split_video_image" style="background-image: url(' . $bgimage . ');"></div>';
						//echo wp_oembed_get( $video );
						echo '<a href="'.$video.'"><i class="ion-ios-play"></i></a>';
					echo '</div>';
				echo '</div>';
			}else{
				echo '<div class="column_split_block_image" style="background-image: url(' . $bgimage . ');"></div>';
			}
					
			echo '<div class="column_split_block column_split_entry_' . $post->ID . '" style="'.$background_color.$text_color.'" >';
				echo '<div class="column_split_block_content">';		
					if( $title ){
						echo '<h4 class="column_split_block_title">' . $title . '</h4>';					
					}
					if( $subtitle ){
						echo '<span class="column_split_block_subtitle">' . do_shortcode( $subtitle ) . '</span>';					
					}
					if( $desc ){
						echo '<span class="column_split_block_desc">' . do_shortcode( $desc ) . '</span>';
					}
					if( $link ){
						echo '<a class="button" href="' . $link . '">' . $label . '</a>';
					}
				echo '</div>';				
			echo '</div>';
	echo '</div>';
}

/**
 * Column Block Function
 *
 * This renders the markup of column block.
 *
 * @param integer $entry - entry ID.
 * @param integer $section_id - section ID.
 * @return an HTML layout of column block.
 */
function zp_section_column_blocks( $entry, $section_id ){
	global $post;
	$count = 0;
	$colClass = '';
	$i = 1;
	while( $i <= 4 ){
		$title = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_title' );
		$desc = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_desc' );
		if( $title || $desc ){
			$count++;
		}
		$i++;
	}
	if( $count == 1 ){
		$colClass = 'column_full';
	}else if( $count == 2 ){
		$colClass = 'column_two';
	}else if( $count == 3 ){
		$colClass = 'column_three';
	}else if( $count == 4 ){
		$colClass = 'column_four';
	}
	$i = 1;
	echo '<div class="column_block_wrap ' . $colClass . '">';
	$hover_bg = $hover_text = '';
	while( $i <= $count ){
		$title = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_title' );
		$desc = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_desc' );
		$link = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_link' );
		$bgcolor = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_bgcolor' );
		$color = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_color' );
		$bgimage = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_image' );
		$overlay = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_overlay' );
		$opacity = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_opacity' );
		$hover_bg = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_hover_bg' );
		$hover_txt = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_hover_text' );
		$padding_top = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_padding_top' );
		$padding_bottom = cmb2_get_meta( $entry, 'zpmeta_section_col_block_' . $i . '_padding_bottom' );
		$padding_top = ( $padding_top ) ? 'padding-top:' . $padding_top . 'px;' : '';
		$padding_bottom = ( $padding_bottom ) ? 'padding-bottom:' . $padding_bottom . 'px;' : '';
		if( $hover_bg || $hover_text ){
			echo '<style>
			#'.$section_id.' .column_block_' . $i . ' .column_block_content:hover{
				background-color: ' . $hover_bg . ' !important;
				background-image: none !important;
				color: ' . $hover_txt . ' !important;
			}
			</style>';
		}
		echo '<div class="column_block_' . $i . ' column_block column_entry_' . $post->ID . '" style="' . $padding_top . $padding_bottom . '">';
			if( $bgimage != '' ){
				echo '<div class="column_block_content column_block_image" style="background-image: url(' . $bgimage . '); color: ' . $color . '">';
				echo '<div class="column_image_overlay" style="background-color: ' . $overlay . '; opacity: ' . $opacity . '"></div>';
			}else{
				echo '<div class="column_block_content" style="background-color: ' . $bgcolor . '; color: ' . $color . '">';
			}				
				if( $link != '' ){
					echo '<a href="' . $link . '" target="_self"></a>';
				}
				if( $title ){
					echo '<h4 class="column_block_title">' . $title . '</h4>';					
				}
				if( $desc ){
					echo '<span class="column_block_desc">' . do_shortcode( $desc ) . '</span>';
				}
			echo '</div>';
		echo '</div>';		
		$i++;
	}
	echo '</div>';
}

/**
 * Shortcode Block Function
 *
 * This renders the markup of shortcode block.
 *
 * @param integer $entry - entry ID.
 * @param integer $section_id - section ID.
 * @return an HTML layout of shortcode block.
 */
function zp_section_shortcode_blocks( $entry, $section_id ){
	$shortcode = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode' );
	$background_color = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_bgcolor' );
	$text_color = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_textcolor' );
	$background_image = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_bgimage' );
	$overlay = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_overlay' );
	$opacity = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_opacity' );
	$padding_top = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_padding_top' );
	$padding_bottom = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_padding_bottom' );
	$padding_top = ( $padding_top ) ? 'padding-top:' . $padding_top . 'px;' : '';
	$padding_bottom = ( $padding_bottom ) ? 'padding-bottom:' . $padding_bottom . 'px;' : '';

	$wrap = cmb2_get_meta( $entry, 'zpmeta_section_custom_shortcode_wrap' );


	echo '<div class="custom_shortcode_block hero_fullwidth" style="' . $padding_top . $padding_bottom . 'color: ' . $text_color . '">';
		if( $background_image != '' ){
			echo '<div class="custom_shortcode_block_image" style="background-image: url(' . $background_image . '); "></div>';
			echo '<div class="custom_shortcode_image_overlay" style="background-color: ' . $overlay . '; opacity: ' . $opacity . '"></div>';
		}else{
			echo '<div class="custom_shortcode_block_image" style="background-color: ' . $background_color . ';"></div>';
		}
		echo '<div class="custom_shortcode_wrap custom_'.$wrap.'">';
			echo '<div class="custom_shortcode_content">'.do_shortcode( $shortcode ) . '</div>';
		echo '</div>';
	echo '</div>';
}

/**
 * Slider Block Function
 *
 * This renders the markup of slider block.
 *
 * @param integer $entry - entry ID.
 * @param integer $section_id - section ID.
 * @return an HTML layout of slider block.
 */
function zp_section_slider( $entry, $section_id ){
	global $post;
	$slider_images = cmb2_get_meta( $entry, 'zpmeta_section_slider' );
	$padding_top = cmb2_get_meta( $entry, 'zpmeta_section_slider_padding_top' );
	$padding_bottom = cmb2_get_meta( $entry, 'zpmeta_section_slider_padding_bottom' );
	$padding_top = ( $padding_top ) ? 'padding-top:' . $padding_top . 'px;' : '';
	$padding_bottom = ( $padding_bottom ) ? 'padding-bottom:' . $padding_bottom . 'px;' : '';
	$slider_desc = cmb2_get_meta( $entry, 'zpmeta_section_slider_desc' );
	$slider_color = cmb2_get_meta( $entry, 'zpmeta_section_slider_color' );
	$slider_height = cmb2_get_meta( $entry, 'zpmeta_section_slider_height' );
	$slider_overlay_color = cmb2_get_meta( $entry, 'zpmeta_section_slider_overlay_color' );
	$slider_overlay_opacity = cmb2_get_meta( $entry, 'zpmeta_section_slider_overlay_opacity' );
	$slider_color = ( $slider_color ) ? 'color:'. $slider_color.';' : '';
	$slider_overlay_color = ( $slider_overlay_color ) ? 'background-color:'. $slider_overlay_color .';' : '';
	$slider_overlay_opacity = ( $slider_overlay_opacity ) ? 'opacity:'. $slider_overlay_opacity.';' : 'opacity: 0;';

	$slider_height = ( $slider_height ) ? 'height:'. $slider_height.'px;' : '';


	$script = '<script type="text/javascript">
		jQuery(function( $ ){
			$(window).load( function(){
		    $("#slider_' . $section_id . '").fadeIn(500);
		      // carousel
		      _slider   = $("#slider_' . $section_id . '"),
		      _smargin     = _slider.data("margin"),
		      _scenter     = _slider.data("center"),
		      _sitem     = _slider.data("item"),
		      _sautoW    = _slider.data("autowidth"),
		      _sslideby    = _slider.data("slideby"),
		      _sauto     = _slider.data("auto"),
		      _sshowdot    = _slider.data("showdot"),
		      _sshownav    = _slider.data("nav"),
		      _sanimateIn  = _slider.data("animatein"),
		      _sanimateOut = _slider.data("animateout"),
		      _sloop   = _slider.data("loop"),
		      _slazyLoad   = _slider.data("lazy");
		     _slider.owlCarousel({
		          margin: _smargin,
		          loop: _sloop,
		          autoWidth:_sautoW,
		          center: _scenter,
		          animateIn: _sanimateIn,
		          animateOut: _sanimateOut,
		          slideSpeed : 300,
		              paginationSpeed : 400,
		          items: _sitem,
		          autoplay: _sauto,
		          responsiveClass:true,
		          navText:["",""],
		          slideBy:_sslideby,
		          dots:_sshowdot, 
		          nav:_sshownav,
		          responsive:{
		              0:{
		                  items:_sitem,
		                  nav:_sshownav
		              },
		              480:{
		                  items:_sitem,
		                  nav:_sshownav
		              },
		              769:{
		                  items:_sitem,
		                  nav:_sshownav 
		              }
		          }
		      });	      
			});
		});
	</script>';
	echo $script . '<div id="slider_' . $section_id . '" style="' . $padding_top . $padding_bottom . $slider_color . '" class="hero_fullwidth section_slider owl-carousel owl-center owl-theme"  data-item="1" data-center="false" data-margin="0" data-autowidth="false" data-slideby="1" data-showdot="false" data-nav="true" data-loop="true" data-lazy="true">';
	foreach ( (array) $slider_images as $attachment_id => $attachment_url ) {
        echo '<div class="carousel-item" style="'.$slider_height.'">';
        	echo '<div class="slider_overlay" style="'.$slider_overlay_color.' '.$slider_overlay_opacity.'"></div>';
        	
        	$image = wp_get_attachment_image_src( $attachment_id, 'full' );
        	if( $image )
        		echo '<div class="carousel_image" style="background-image: url( '.$image[0].' )"></div>';

	        $image_meta =  zp_get_attachment( $attachment_id );
	        echo '<div class="slider_section_caption">';
	        	echo '<div class="slider_section_caption_wrap">';
	        		if( $image_meta['title'] )
	        			echo '<h4>'.$image_meta['title'].'</h4>';
	        		if( $image_meta['caption'] )
	        			echo '<div class="slider_section_desc">'.$image_meta['caption'].'</div>'; 
	        		if( $image_meta['description'] )
	        			echo '<div class="slider_section_button">'.$image_meta['description'].'</div>';
	        	echo '</div>';
	        echo '</div>';

        echo '</div>';
    }
    echo '</div>';
}
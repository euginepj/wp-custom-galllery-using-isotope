<?php
/**
 * ------------------------------------------
 * ABOUT THIS PAGE: 
 * ------------------------------------------
 * This is an isotope portfolio page for 
 * wordpress using Photo Gallery plugin by 
 * WebDorado. 
 * Ref: http://isotope.metafizzy.co/
 * @developed by: Eugine
 * ------------------------------------------
 */

?>
<style> 
h1 { 
  font-size: 72px;
  margin: 0 0 40px;
  color: #15A9F6;
  text-align: center;
  text-shadow: 1px 1px 1px #2A4154;
}
.fancybox-lock .fancybox-overlay { background: rgba(0,0,0,0.6) }
#filters {
	margin:10px 0 50px 0;
	text-align: center;
	display: block;
	float: none;
	z-index: 2;
	position: relative;
}
#filters ul {
	margin: 0;
	list-style: none;
	padding: 0;
}
#filters ul li {
	display: inline-block;
}
#filters ul li a {
	display: block;
	float: left;
	padding: 2px 5px;
	color: inherit;
	font-weight: bold;
  text-decoration: none;
}
#filters ul li a h3 {
	font-size: 14px;
	text-transform:uppercase;
	padding:12px 21px;
	border: 1px solid transparent;
	margin:0;
	font-family: 'Open Sans',sans-serif;
  color: #4c4c4c;
  font-weight: normal;
}
#filters ul li a:hover h3, #filters ul li a.active h3 {
	color: #7251a2;
	border: 1px solid;
}
.crop {
  width: 399px;
  height: 270px;
  overflow: hidden;
}
.crop img {
  width: 100%;
}

#portfolio-items-wrap {
	position: relative;
	padding: 0;
	width: 100.1%;
	margin: 0 auto;
	display: block;
}
#portfolio-items-wrap .portfolio-item {
	margin: 0;
	overflow: hidden;
	line-height: 0;
	width: 25%;
	padding: 0;
}
.portfolio-item.current {
	box-shadow: 0 0px 0px 10px rgba(255, 255, 255, 0.37);
	z-index: 101;
}
.portfolio-item {
	padding: 0;
	position: relative;
	overflow: hidden;
}
.portfolio {
	overflow: hidden;
	display: block;
	position: relative;
}
.portfolio img {
	width: 100%;
	height: auto;
}
.portfolio .portfolio-overlay {
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	position: absolute;
	display: block;
	z-index: 4;
	opacity: 0;
	-moz-opacity: 0;
	filter: alpha(opacity=0);
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
	background: #FFD600;
}
.portfolio > a, .portfolio > a:hover {
	color: #ffffff;
}
.portfolio-item .portfolio > a:hover > .portfolio-overlay {
	opacity: 1;
	-moz-opacity: 1;
	filter: alpha(opacity=100);
}
.portfolio > a img {
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
}
.portfolio > a:hover img {
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
}
.portfolio .thumb-info {
	position: absolute;
	width: 100%;
	height: 100%;
	opacity: 0;
	-moz-opacity: 0;
	filter: alpha(opacity=0);
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
}
.portfolio a:hover .portfolio-overlay .thumb-info {
	opacity: 1;
	-moz-opacity: 1;
	filter: alpha(opacity=100);
}
.portfolio-overlay .thumb-info i {
	top: 58%;
	font-size: 50px;
}
.portfolio-overlay .thumb-info h3 {
	top: 38%;
	font-size: 30px;
}
.portfolio-overlay .thumb-info p {
	top: 50%;
	font-size: 13px;
}
.portfolio-overlay .thumb-info h3 {
	color: #ffffff;
	width: 100%;
	position: absolute;
	text-align: center;
}
.portfolio-overlay .thumb-info p {
	color: #ffffff;
	width: 100%;
	position: absolute;
	text-align: center;
	font-weight: bold;
}
.portfolio-overlay .thumb-info i {
	color: #ffffff;
	width: 100%;
	position: absolute;
	text-align: center;
	display: block;
}
</style>

	<!-- BEGIN PORTFOLIO CONTAINER -->
	<section class="portfolio no-padding-bottom" id="portfolio">
  	<div class="container">
    	<!-- BEGIN HEADING -->
    	<h1 class="yellow text-center">Portfolio</h1>
    	<!-- END HEADING -->
		</div>

<?php 
global $wpdb;
$option = $wpdb->get_row( "SELECT `id`, `images_directory` FROM `wp_bwg_option`" ); 
$upload = '/wp-content/uploads';
if(isset($option->images_directory)): 
	$upload = '/'.$option->images_directory.'/photo-gallery';
endif;

	// Get the tags that are used in the portfolio
	$tags = $wpdb->get_results("
		SELECT 
			`term_id`,
			`name`
		FROM
			`wp_terms`
		WHERE 
			`term_id` in (
				SELECT 
					DISTINCT `term_id` 
				FROM 
					`wp_bwg_image_tag` 
			)
		"); 
	
	$images = $wpdb->get_results("
		SELECT 
			`wp_bwg_image`.`id`, 
			`wp_bwg_image`.`image_url`, 
			`wp_bwg_image`.`thumb_url`, 
			`wp_bwg_image`.`order`, 
			`wp_bwg_image_tag`.`image_id`, 
			`wp_bwg_image_tag`.`tag_id`
		FROM 
			`wp_bwg_image` 
		LEFT JOIN 
			`wp_bwg_image_tag` 
		ON 
			`wp_bwg_image_tag`.`image_id` = `wp_bwg_image`.`id` 
		ORDER BY `order` asc" ); 
?>
    
    <div id="filters">
			<!-- BEGIN PORTFOLIO NAV -->
    	<ul class="clearfix">
      <?php 
				foreach($tags as $tag): 
			?>	
      	<li><a href="#" data-filter="<?=(($tag->name!='All')?('.tag_'.$tag->term_id):'*')?>"
        	<?=(($tag->name=='All')?'class="active"':'')?> ><h3><?=$tag->name?></h3></a></li>
			<?php 
				endforeach;
			?>
     	</ul>
			<!-- END PORTFOLIO NAV -->
		</div>

		<div id="portfolio-items-wrap" class="fadeInUp">
		<?php 
			foreach($images as $img): 
		?> 
			<div class="portfolio-item tag_<?=$img->tag_id?>"> 
        <div class="portfolio"> 
          <div class="crop"><img src="<?=get_site_url().$upload.$img->image_url?>" alt=""></div> 
        </div>
			</div>
		<?php 
      endforeach; 
    ?> 
    </div>
	</section> 	

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.1/isotope.pkgd.min.js"></script>
<script type="text/javascript">
//------------------------------------ PORTFOLIO -----------------------------------//
$('#portfolio-items-wrap').isotope({
	itemSelector: '.portfolio-item',
	layoutMode: 'fitRows',
})
</script>

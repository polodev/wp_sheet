# wordpres-snippet
# laravel-snippet
# react-snippet
# php-snippet
# express-snippet
# angular-snippet
# vue-snippet


* page.php
* single.php
* header.php

<!-- wordpress loop -->
<?php while(have_posts()): ?>
	<?php the_post(); ?>
	<h1>
		<a href="<?php the_permalink() ?>">
			<?php the_title(); ?>
		</a>
	</h1>
	<?php the_content() ?>
<?php endwhile; ?>


<!-- Header and footer -->
<?php get_header(); ?>
<?php get_footer(); ?>

<!-- wordpress in control head section -->
<?php wp_head(); ?>

<!-- wordpress control footer section -->
<?php wp_footer(); ?>

<!-- functions.php -->

<?php 

function university_files() {

	wp_enqueue_script('filename whatever you want', 'file_path', 'dependency like jquery', 'version number', 'Should we place in footer boolean');
	wp_enqueue_script('main-js-file', get_theme_file_uri('/js/main.js'), NULL, '1.0', true);

	wp_enqueue_style('font_awesome', '//maxcdn.blahh.com');
	wp_enqueue_style('name_of_stylesheet', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'university_files')

?>


<!-- theme content -->
<?php echo get_theme_file_uri('/images/hello.jpg')  ?>

<!-- Dynmic title tag using functions  -->


<?php 

function university_features(){
 add_theme_support('title-tag');
}
add_action('after_setup_theme', 'university_features')


?>

<!-- making more reliable link using site_url() -->

<a href="<?php echo site_url('/about-us') ?>">About us</a>


<!-- Parent and children page -->

<p>Make page with some parents</p>

<?php the_ID(); ?>
<?php get_the_ID(); ?>
<?php wp_get_post_parent_id(); // it will return 0 if there is no parent  ?>
<?php 

if (wp_get_post_parent_id(get_the_ID())) {
	// it has parent page . show we will show bradcrumb
}

?>

<!-- parent post link -->
<?php 
$theParent = wp_get_post_parent_id(get_the_ID());
get_the_title($theParent);
get_the_permalink($theParent);

?>


<!-- listing all child page  -->

<?php 
wp_list_pages(); // every single page of this website

wp_list_pages([
	'title_li' => null,
	'child_of' => 'some_page_id',
	'sort_column' => 'menu_order',
]);

// use case
if ($theParent) {
	$findChildOf = $theParent;
} else {
	$findChildOf = get_the_ID();
}
	wp_list_pages([
		'title_li' => null,
		'child_of' => $findChildOf,
		'sort_column' => 'menu_order',
	]);



?>

<!-- hiding child page links where there are no child pages  -->

<!-- if has parent or has child -->
<?php

$testArray = get_pages([
	'child_of' => get_the_ID(),
]); // get_pages and wp_list_pages() simillar
if ($theParent or $testArray) {
	// showing child page links
}

?>

<!-- some meta information -->
<html <?php language_attributes() ?>>
<meta charset="<?php bloginfo('charset') ?>">
<body <?php body_class(); ?>>
	

<!-- dynamic navigation page -->

<!-- functions.php -->

<?php 

function university_features2() {
	register_nav_menu('header_menu_location', 'Header Menu');
}
add_action('after_setup_theme', 'university_features2')


?>

<!-- in view -->
<?php
wp_nav_menu([
	'theme_location' => 'header_menu_location'
]);
?>

<!-- how to keep a static html nav highlighted  -->
<?php 

wp_get_post_parent_id(0); // 0 means current page
//or 
wp_get_post_parent_id(get_the_ID()) ; 
// is same  

 ?>
<li <?php echo (is_page('about-us') or wp_get_post_parent_id(0) == 16) ? 'class=current-menu-item' : ''; ?>><a href="#">About us</a></li>  
<!-- here 16 was about page id which can be viewed when -->


<!-- frontpage and blogpage setting from reading  -->


* front-page.php
* index.php 

<?php the_excerpt(); ?>
<?php the_permalink(); ?>
<?php the_author_posts_link()  ?>
<?php the_time('n.j.y')  ?>
<?php echo get_the_category_list(', ') ?>

<!-- wordpress nick name can be changed from user > nick name from dahsboard -->

<?php paginate_links(); ?>

<!-- Archive page - for category/ tags/ author page -->
* archive.php


# dynamic title  in archive page - but we will use the_archieve_title();

<?php


if ( is_category()) {
	// category name will be here
	single_cat_title();
}
if (is_author())  {
	echo 'Posts by ' . the_author();
}

?>
<!-- one functions do all for us for archive title -->
<?php the_archieve_title() ?>
<?php the_archieve_description() ?>

?>


# custom query : bring 2 post in home page 

<?php
$homepagePosts = new WP_Query([
	'posts_per_page' => 2,
	'category_name' => 'awards',
	'post_type' => 'post', // default //page 
]);

while ( $homepagePosts->have_posts()) { $homepagePosts->the_post(); ?>
	<div></div>
<?php } ?>


<?php the_time('M') ?>
<?php the_time('d') ?>
<?php wp_trim_words('content I want to limit', 'how many words') ?>
<?php echo wp_trim_words(get_the_content(), 18) ?>
<!-- at the end of the query -->

<?php wp_reset_postdata(); ?>

# 24

<?php is_archive() ?>
<?php if(get_post_type() == 'post') {} ?>


# 29



# mu-plugins (must use plugins)
mu-plugins >  university-post-types.php

<?php 


function university_post_types(){
	register_post_type('event', [
		'public' => true,
		'has_archieve' => true,  // it will showing listing page
		'labels' => [
			'name' => 'Events',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'all_items' => 'All Items',
			'singular_name' => 'Event',
		],
		'rewrite' => [
			'slug' => 'events'
		],
		'supports' => [
			'title',
			'content',
			'excerpt',
			'custom-fields'  // instead of this fields we will use ACF plugins
		],
		'menu_icon' => 'dashicons-calender'
	]);
}

add_action('init', 'university_post_types');

 ?>


 # displaying custom post types
<?php

$homepageEvents = new WP_Query([
	'post_type' => 'events',
	'posts_per_page' => 2,
]);

while($homepageEvents->have_posts()) {
	$homepageEvents->the_post();
}

?>

* We have to save permalink again to take effect  new post type
* single-event.php
* single-<post_type>.php

automatic post type archieve 

<?php echo get_post_type_archieve_link('event') ?>


# how to customized excerpt content 
<?php 

if (has_excerpt()) {
	echo get_the_excerpt();
}else {
	wp_trim_words(get_the_content(), 18);
}


 ?>

 # making event highlighted 
 <?php if (get_post_type() === 'event') echo 'class=current-menu-item' ?>




# custom fields - plugings for custom fields 

* Advanced custom fields (ACF)
* CMB2 (Custom Metaboxes 2)

<?php the_field('event_date') ?>
<?php 
$date = get_field('event_date'); 
$eventDate = new DateTime($date);
echo $eventDate->format('M');
echo $eventDate->format('d');


 ?>

# Custom query skill in another level # 33
# sort by custom field 

<?php 
$today = date('Ymd');
$homepageEvents = new WP_Query([
	'post_type' => 'events',
	'posts_per_page' => -1, // negetive means all 
	'orderby' => 'meta_value_num', // rand, title, meta_value, meta_value_num
	'order' => 'ASC',
	'meta_key' => 'event_date', // whenever we use meta_value/meta_value_num we will use meta_key
	'meta_query' => [
		[
			'key' => 'event_date',
			'compare' => '>=',
			'value' => $today,
			'type' => 'numeric'
		]
	],
]);

 ?>


# Manipulating Default URL based queries 


<?php 


function university_adjust_queries($query)
{
	$today = date('Ymd');
	if (!is_admin() && is_post_type_archive('event') and $query->is_main_query()) {
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'asc');
		$query->set('meta_key', 'event_date');
		$query->set('meta_query',[
			[
				'key' => 'event_date',
				'compare' => '>=',
				'value' => $today,
				'type' => 'numeric',
			]
		]);

	}

}
add_action('pre_get_posts', 'university_adjust_queries');

?>


# 35 passed events

slug of page is : localhost:3000/past-events/
corresponding file name: page-past-events.php
<?php 




$today = date('Ymd');
$pastEvents = new WP_Query([
	'paged' => get_query_var('paged', 1), // pagination
	'post_type' => 'event',
	'posts_per_page' => 2,
	'meta_key' => 'event_date',
	'order' => 'asc',
	'orderby' => 'meta_value_num',
	'meta_query' => [
		[
			'key' => 'event_date',
			'compare' => '<',
			'value' => $today,
			'type' => 'numeric'
		]
	]
]);

while($pastEvents->have_posts()) {
	the_post();
}

echo paginate_links([
	'total' => $pastEvents->max_num_pages
]);

// for making active menu link for is_page('past-events')


?>

# program post type - relationship with program and event

<?php 


function old_functions1 () {
	register_post_type('program', [
		'public' => true,
		'has_archieve' => true,  // it will showing listing page
		'labels' => [
			'name' => 'Programs',
			'add_new_item' => 'Add New Program',
			'edit_item' => 'Edit Program',
			'all_items' => 'All Items',
			'singular_name' => 'Program',
		],
		'rewrite' => [
			'slug' => 'programs'
		],
		'supports' => [
			'title',
			'content',
		],
		'menu_icon' => 'dashicons-calender'
	]);
}

 ?>







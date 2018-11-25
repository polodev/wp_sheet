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









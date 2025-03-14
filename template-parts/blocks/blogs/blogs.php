<?php
/**
 * Blogs Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$background_color = get_field('background_color') ?: 'white';
$supertitle = get_field('supertitle') ?: '';
$supertitle_style = get_field('supertitle_style') ?: 'primary';
$title = get_field('title') ?: '';
$section_header_color = get_field('section_header_color') ?: 'white';
$text = get_field('text') ?: '';
$cta_style = get_field('cta_style') ?: 'white';
$cta = get_field('cta') ?: [];

$args = array(
'post_type' =>'post',
'posts_per_page' => 4,
'status' => 'published',
'orderby' => 'post_date',
'order' => 'DESC' ,
'suppress_filters' => false
);

$blog_posts = get_posts($args);
?>
<section class="section section--default section--<?= $background_color; ?>">
    <div class="container">
        <div class="section__header section__header--<?= $section_header_color; ?>">
            <?php if($supertitle) { ?>
            <div class="section__supertitle section__supertitle--<?= $supertitle_style; ?>">
                <?= $supertitle; ?>
            </div>
            <?php } ?>
            <?php if($title) { ?>
            <h2 class="section__title section__title">
                <?= $title; ?>
            </h2>
            <?php } ?>
            <?php if($text) { ?>
            <div class="section__text rich-text">
                <?= $text; ?>
            </div>
            <?php } ?>
        </div>
        <div class="blogs owl-carousel js">
            <?php
                foreach($blog_posts as $key => $blog_post) {
                $id = $blog_post->ID;
                $title = $blog_post->post_title;
                $text = strip_tags($blog_post->post_content);
                $link = get_permalink($id);
                $image = get_post_thumbnail_id($id);
                $post_date = $blog_post->post_date;
                $blog_categories = get_the_terms($id, 'blog_category');
            ?>  
                <div class="blogs__item">
                    <a href="<?= $link; ?>" class="image">
                        <?php the_lqip($image); ?>
                    </a>
                    <div class="meta">
                        <a href="<?= $link; ?>" class="meta__title">
                            <?= $title; ?>
                        </a>
                        <a href="<?= $link; ?>" class="meta__text">
                            <?= remove_divi_shortcodes($text); ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if($cta) { ?>
        <div class="section__cta">
            <a href="<?= $cta['url']; ?>" class="button button--<?= $cta_style; ?>"><?= $cta['title']; ?></a>
        </div>
        <?php } ?>
    </div>
</section>
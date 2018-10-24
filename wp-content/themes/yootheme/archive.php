<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#category
 */

get_header();

?>

<?php if (have_posts()) :

    // Header
    $title = get_the_archive_title();
    $description = get_the_archive_description();

    $attrs_title = [];
    $attrs_description = [];

    if ($description) {
        $attrs_description['class'][] = 'uk-margin-medium-bottom';
    } else {
        $attrs_title['class'][] = 'uk-margin-medium-bottom';
    }

    if ($theme->get('post.header_align')) {
        $attrs_title['class'][] = 'uk-text-center';
        $attrs_description['class'][] = 'uk-text-center';
    }

    // Grid
    if (($columns = $theme->get('blog.column', 1)) != 1) {

        $attrs = [];
        $options = [];

        $options[] = $theme->get('blog.grid_masonry') ? 'masonry: true' : '';
        $options[] = $theme->get('blog.grid_parallax') ? "parallax: {$theme->get('blog.grid_parallax')}" : '';
        $attrs['uk-grid'] = implode(';', array_filter($options)) ?: true;

        // Columns
        $breakpoint = $theme->get('blog.column_breakpoint');
        $breakpoints = ['s', 'm', 'l', 'xl'];
        $pos = array_search($breakpoint, $breakpoints);

        if ($pos === false) {
            $attrs['class'][] = "uk-child-width-1-{$columns}";
        } else {
            for ($i = $columns; $i > 0; $i--) {
                if (($pos > -1) && ($i > 1)) {
                    $attrs['class'][] = "uk-child-width-1-{$i}@{$breakpoints[$pos]}";
                    $pos--;
                }
            }
        }

        $attrs['class'][] = $theme->get('blog.column_gutter') ? 'uk-grid-large' : '';

    }

    ?>

    <?php if (!is_category() || $theme->get('blog.category_title')) : ?>

        <h3<?= get_attrs($attrs_title) ?>><?= $title ?></h3>

        <?php if ($description) : ?>
        <div<?= get_attrs($attrs_description) ?>><?= $description ?></div>
        <?php endif ?>

    <?php endif ?>

    <?php if ($columns != 1) : ?>
    <div<?= get_attrs($attrs) ?>>
    <?php endif ?>

        <?php foreach ($wp_query->posts as $post) : ?>
            <?php if ($columns != 1) : ?>
            <div>
                <?php
                    setup_postdata($GLOBALS['post'] = $post);
                    get_template_part('templates/post/content', get_post_format());
                ?>
            </div>
            <?php else : ?>
                <?php
                    setup_postdata($GLOBALS['post'] = $post);
                    get_template_part('templates/post/content', get_post_format());
                ?>
            <?php endif ?>
        <?php endforeach ?>

    <?php if ($columns != 1) : ?>
    </div>
    <?php endif ?>

    <?php

    get_template_part('templates/pagination', 'archive');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();

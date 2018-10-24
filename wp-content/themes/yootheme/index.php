<?php
/**
 * The main template file.
 *
 * The most generic template file in the WordPress file hierarchy.
 * Used if WordPress cannot find any other matching template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

get_header();

?>

<?php if (have_posts()) :

    // Grid
    if ($columns != 1) {

        $attrs = [];
        $options = [];

        $options[] = $theme->get('blog.grid_masonry') ? 'masonry: true' : '';
        $options[] = $theme->get('blog.grid_parallax') ? "parallax: {$theme->get('blog.grid_parallax')}" : '';
        $attrs['uk-grid'] = implode(';', array_filter($options)) ?: true;

        // Columns
        $columns = $theme->get('blog.column', 1);
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

    get_template_part('templates/pagination');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();
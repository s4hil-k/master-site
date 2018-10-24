<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

use YOOtheme\Util\Str;

$params = $theme->get('post', []);

if (!is_single()) {
    $params->merge($theme->get('blog', []));
}

$attrs_container = [];

// Image
$attrs_image['class'][] = 'uk-text-center';
$attrs_image['class'][] = get_margin($params['image_margin']);

// Container


if ((!isset($params['column']) || $params['column'] == 1) && $params['content_width'] && ($params['content_width'] != $params['width'])) {
    $attrs_container['class'][] = "uk-container uk-container-{$params['content_width']}";
}

// Title
$attrs_title['class'][] = get_margin($params['title_margin']) . ' uk-margin-remove-bottom';
$attrs_title['class'][] = $params['header_align'] ? 'uk-text-center' : '';
$attrs_title['class'][] = $params['title_style'] ? "uk-{$params['title_style']}" : 'uk-article-title';

// Content
$attrs_content['class'][] = get_margin($params['content_margin']);
$attrs_content['class'][] = $params['content_align'] ? 'uk-text-center' : '';
$attrs_content['class'][] = is_single() && $params['content_dropcap'] ? 'uk-dropcap' : '';

// Tags
$attrs_tags['class'][] = $params['header_align'] ? 'uk-text-center' : '';

// Button
$attrs_button['class'][] = "uk-button uk-button-{$params['button_style']}";
$attrs_button_container['class'][] = $params['header_align'] ? 'uk-text-center' : '';
$attrs_button_container['class'][] = "uk-margin-{$params['button_margin']}";

/*
 * Image template
 */
$image = function ($attr) use ($params, $theme) {

    $src = str_replace(get_site_url() . '/', '', get_the_post_thumbnail_url());
    $meta = get_post_meta(get_post_thumbnail_id());
    $alt = isset($meta['_wp_attachment_image_alt']) ? $meta['_wp_attachment_image_alt'] : '';

    if ($theme->view->isImage($src) == 'svg') {
        $thumbnail = $theme->image->replace($theme->view->image($src, ['width' => $params['image_width'], 'height' => $params['image_height'], 'uk-img' => true, 'property' => 'url', 'alt' => $alt]));
    } else {
        $thumbnail = $theme->image->replace($theme->view->image([$src, 'thumbnail' => [$params['image_width'], $params['image_height']], 'srcset' => true], ['uk-img' => true, 'property' => 'url', 'alt' => $alt]));
    }

    ?>

    <?php if ($thumbnail) : ?>
        <div<?= get_attrs($attr) ?> property="image" typeof="ImageObject">
            <?php if (is_single()) : ?>
                <?= $thumbnail ?>
            <?php else : ?>
                <a href="<?php the_permalink() ?>"><?= $thumbnail ?></a>
            <?php endif ?>
        </div>
    <?php endif ?>

    <?php
};

/*
 * Meta template
 */
$meta = function () use ($params) {

    $date = $params['date'] ? '<span>'.get_post_date().'</span>' : '';
    $author = $params['author'] ? get_post_author() : '';
    $category = $params['categories'] ? get_the_category_list(__(', ')) : '';
    $comments = $params['comments'] && !post_password_required() && (comments_open() || get_comments_number());

    if ($date || $author || $category || $comments) {

        $attrs_meta['class'][] = get_margin($params['meta_margin']) . ' uk-margin-remove-bottom';

        switch ($params['meta_style']) {

            case 'list':

                $attrs_meta['class'][] = 'uk-subnav uk-subnav-divider';
                $attrs_meta['class'][] = $params['header_align'] ? 'uk-flex-center' : '';

                ?>
                <ul<?= get_attrs($attrs_meta) ?>>
                    <?php foreach (array_filter([$date, $author]) as $part) : ?>
                    <li><?= $part ?></li>
                    <?php endforeach ?>

                    <?php if ($category && count(wp_get_post_categories(get_the_ID())) > 1) : ?>
                    <li><span><?= $category ?></span></li>
                    <?php elseif($category) : ?>
                    <li><?= $category ?></li>
                    <?php endif ?>

                    <?php if ($comments) : ?>
                    <li><?php comments_popup_link(__('0 Comments', 'yootheme'), __('1 Comment', 'yootheme'), __('% Comments', 'yootheme')) ?></li>
                    <?php endif ?>
                </ul>
                <?php
                break;

            default: // sentence

                $attrs_meta['class'][] = 'uk-article-meta';
                $attrs_meta['class'][] = $params['header_align'] ? 'uk-text-center' : '';

                ?>
                <p<?= get_attrs($attrs_meta) ?>>
                <?php

                if ($author && $date) {
                    printf(__('Written by %s on %s.', 'yootheme'), get_post_author(), get_post_date());
                } elseif ($author) {
                    printf(__('Written by %s.', 'yootheme'), get_post_author());
                } elseif ($date) {
                    printf(__('Written on %s.', 'yootheme'), get_post_date());
                }

                ?>
                <?php

                if ($category && $categories = get_the_category_list(__(', '))) {
                    printf(__('Posted in %1$s.', 'yootheme'), $categories);
                }

                ?>
                <?php

                if ($comments) {
                    comments_popup_link(__('Leave a Comment'), __('1 Comment', 'yootheme'), __('% Comments', 'yootheme'));
                }

                ?>
                </p>
                <?php
        }

    }

};

?>

<article id="post-<?php the_ID() ?>" <?php post_class('uk-article') ?> typeof="Article">

    <meta property="name" content="<?= esc_html(get_the_title()) ?>">
    <meta property="author" typeof="Person" content="<?= esc_html(get_the_author()) ?>">
    <meta property="dateModified" content="<?= get_the_modified_date('c') ?>">
    <meta class="uk-margin-remove-adjacent" property="datePublished" content="<?= get_the_date('c') ?>">

    <?php if ($params['image_align'] == 'top') : ?>
    <?= $image($attrs_image) ?>
    <?php endif ?>

    <?php if ($attrs_container) : ?>
    <div<?= get_attrs($attrs_container) ?>>
    <?php endif ?>

        <?php if ($params['meta_align'] == 'top') : ?>
        <?= $meta() ?>
        <?php endif ?>

        <?php
            if (is_single()) {
                the_title('<h1' . get_attrs($attrs_title) . '>', '</h1>');
            } else {
                the_title('<h2' . get_attrs($attrs_title) . '><a class="uk-link-reset" href="' . esc_url(get_permalink()) . '">', '</a></h2>');
            }
        ?>

        <?php if ($params['meta_align'] == 'bottom') : ?>
        <?= $meta() ?>
        <?php endif ?>

        <?php if ($params['image_align'] == 'between') : ?>

            <?php if ($attrs_container) : ?>
            </div>
            <?php endif ?>

            <?= $image($attrs_image) ?>

            <?php if ($attrs_container) : ?>
            <div<?= get_attrs($attrs_container) ?>>
            <?php endif ?>

        <?php endif ?>

        <?php if (get_the_content('')) : ?>
        <div<?= get_attrs($attrs_content) ?> property="text">
            <?php if ($length = $params['content_length']) : ?>
                <?= Str::limit(strip_tags(get_the_content()), $length, '...', false) ?>
            <?php else : ?>
                <?php the_content('') ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($params['tags'] && $tags = get_the_tags()) : ?>
        <p<?= get_attrs($attrs_tags) ?>>
            <?php $i = 1; ?>
            <?php foreach ($tags as $tag) :
                $seperator = $i++ < count($tags) ? ',' : '' ?>
                <a href="<?= get_tag_link($tag->term_id) ?>"><?= $tag->name ?></a><?= $seperator ?>
            <?php endforeach; ?>
        </p>
        <?php endif ?>

        <?php if (!is_single() && $params['button'] and $readmore = get_readmore()) : ?>
        <p<?= get_attrs($attrs_button_container) ?>>
            <a<?= get_attrs($attrs_button) ?> href="<?= get_permalink() ?>"><?= $readmore ?></a>
        </p>
        <?php endif ?>

        <?php if (is_single()) {
            wp_link_pages(['before' => '<div class="uk-margin-medium">' . __('Pages:') . '<ul class="uk-pagination">', 'after'  => '</ul></div>']);
        } ?>

        <?php if ($edit = get_edit_post_link()) : ?>
        <p>
            <a href="<?= esc_url($edit) ?>"><?= sprintf(__('%1$s Edit', 'yootheme'), '<span uk-icon="pencil"></span>') ?></a>
        </p>
        <?php endif ?>

        <?php if (is_single() && $params['navigation']) : ?>
        <ul class="uk-pagination uk-margin-medium">
            <?php if ($prev = get_previous_post_link('%link', sprintf(__('%1$s Previous', 'yootheme'), '<span uk-pagination-previous></span>'))) : ?>
            <li><?= $prev ?></li>
            <?php endif ?>
            <?php if ($next = get_next_post_link('%link', sprintf(__('Next %1$s', 'yootheme'), '<span uk-pagination-next></span>'))) : ?>
            <li class="uk-margin-auto-left"><?= $next ?></li>
            <?php endif ?>
        </ul>
        <?php endif ?>

        <?php if (is_single() && get_the_author_meta('description')) : ?>
        <hr class="uk-margin-medium-top">
        <div class="uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m">
                <?= get_avatar(get_the_author_meta('user_email')) ?>
            </div>
            <div class="uk-width-expand@m">
                <h4 class="uk-margin-small-bottom"><?php the_author() ?></h4>
                <div><?php the_author_meta('description') ?></div>
            </div>
        </div>
        <hr>
        <?php endif ?>

    <?php if ($attrs_container) : ?>
    </div>
    <?php endif ?>

</article>

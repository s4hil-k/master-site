<?php

namespace YOOtheme\Wordpress;

class CsrfProvider
{
    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return wp_create_nonce();
    }

    /**
     * {@inheritdoc}
     */
    public function validate($token)
    {
        return wp_verify_nonce($token);
    }
}

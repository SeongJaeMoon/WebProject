<?php

namespace OnePageExpress\Customizer\Settings;

class ContentSetting extends \OnePageExpress\Customizer\BaseSetting
{

    private $pageIDRegex = '/<!--@@CPPAGEID\[(.*)\]@@-->/s';

    public function update($value)
    {
        // clean
        $matches = array();
        preg_match($this->pageIDRegex, $value, $matches);

        if (count($matches) == 2) {
            $textMatch = $matches[0];
            $page_id   = (int) $matches[1];
            $content   = str_replace($textMatch, "", $value);


            wp_update_post(array(
                'ID'           => $page_id,
                'post_content' => $content,
            ));

            parent::update(false);
        }
    }

    public function value()
    {
        if ($this->is_previewed) {
            $value = $this->post_value(null);
        } else {
            $value = false;
        }

        if (is_string($value)) {
            $value = preg_replace($this->pageIDRegex, "", $value);
        }

        return $value;
    }
}

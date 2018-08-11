<?php


 add_action('wp_ajax_cp_list_fa', function () {
        $result = array();
        $icons  = (require __DIR__ . "/fa-icons-list.php");

        foreach ($icons as $icon) {
            $title    = str_replace('-', ' ', str_replace('fa-', '', $icon));
            $result[] = array(
                'id'    => $icon,
                'fa'    => $icon,
                "title" => $title,
                'mime'  => "fa-icon/font",
                'sizes' => null,
            );
        }

        echo json_encode($result);
        exit;

    });

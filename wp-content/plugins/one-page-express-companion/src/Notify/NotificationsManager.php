<?php


namespace OnePageExpress\Notify;


class NotificationsManager
{
    const DISMISSED_NOTIFICATIONS_OPTION = "cp_dismissed_notifications";
    const INITIALIZATION_NOTIFICATIONS_OPTION = "cp_initialize_notifications";


    public static function initializationTS()
    {
        $time = get_option(static::INITIALIZATION_NOTIFICATIONS_OPTION, false);
        if ( ! $time) {
            $time = time();
            update_option(static::INITIALIZATION_NOTIFICATIONS_OPTION, $time);
        }

        return $time;
    }

    public static function load($notifications)
    {

        static::initializationTS();

        if ( ! get_option('cp_initialize_notifications', false)) {
            update_option('cp_initialize_notifications', time());
        }

        $notifications = apply_filters('cp_load_notifications', $notifications);

        foreach ($notifications as $notification) {
            new Notification($notification);
        }

        if (count($notifications)) {
            add_action('admin_head', function () {
                ?>
                <style type="text/css">
                    .cp-notification {
                        padding-top: 0rem;
                        padding-bottom: 0rem;
                    }

                    .cp-notification-card {
                        padding: 30px 20px;
                        margin: 0px 10px 20px 10px;
                        display: inline-block;
                        background: #fff;
                        box-shadow: 0 1px 20px 5px rgba(0, 0, 0, 0.1);
                    }

                    .cp-notification-card:first-of-type {
                        margin-left: 0px;
                    }

                    .cp-notification-card:last-of-type {
                        margin-right: 0px;
                    }

                </style>
                <?php
            });

            add_action('wp_ajax_cp_dismiss_notification', array(__CLASS__, 'dismissNotification'));
        }

    }


    public static function dismissNotification()
    {
        if ( ! is_user_logged_in() || ! current_user_can('edit_theme_options')) {
            die();
        }

        $notification = isset($_REQUEST['notification']) ? $_REQUEST['notification'] : false;

        if ($notification) {
            $dismissedNotifications = get_option(static::DISMISSED_NOTIFICATIONS_OPTION, array());
            if ( ! in_array($notification, $dismissedNotifications)) {
                $dismissedNotifications[] = $notification;
            }

            update_option(static::DISMISSED_NOTIFICATIONS_OPTION, $dismissedNotifications);
        }

    }

}
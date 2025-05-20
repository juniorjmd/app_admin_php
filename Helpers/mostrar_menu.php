<?php
function mostrar_menu_personalizado() {
    global $wpdb;
    $tabla_menus = $wpdb->prefix . 'custom_menus';

    $menus = $wpdb->get_results("SELECT * FROM $tabla_menus ORDER BY menu_order");

    if ($menus) {
        echo '<ul>';
        foreach ($menus as $menu) {
            echo '<li><a href="' . esc_url($menu->menu_url) . '">' . esc_html($menu->menu_name) . '</a></li>';
        }
        echo '</ul>';
    }
}

<?php
    $settings = array(
        'db' => array(
            'host' => 'sample_host',
            'user' => 'sample_user',
            'password' => 'sample_password',
            'name' => 'db_name'
        ),
        'cookiename' => 'AWEdashboard',
        'cookiedomain' => 'sample_cookiedomain',
        'base' => 'sample_base'
    );

    if ( file_exists( 'localtest.php' ) ) {
        // load local settings from localtest.php
        function SettingsMerge( $settings, $settingslocal ) {
            foreach ( $settingslocal as $key => $value ) {
                if ( is_array( $value ) && isset( $settings[ $key ] ) ) {
                    $settings[ $key ] = SettingsMerge( $settings[ $key ], $settingslocal[ $key ] );
                    continue;
                }
                $settings[ $key ] = $value;
            }
            return $settings;
        }
        $localsettings = include 'localtest.php';
        $settings = SettingsMerge( $settings, $localsettings );
    }

    return $settings;
?>

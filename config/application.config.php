<?php

return [
    'modules' => [
        'Laminas\Db',
        'Laminas\Router',
        'LeoGalleguillos\Question',
        'MonthlyBasis\ContentModeration',
        'MonthlyBasis\Flash',
        'MonthlyBasis\Memcached',
        'MonthlyBasis\String',
        'MonthlyBasis\Superglobal',
        'MonthlyBasis\User',
    ],
    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => array(
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths' => array(
            './module',
            './vendor',
        ),

        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => array(
            'config/autoload/{{,*.}global,{,*.}local}.php',
        ),
        'config_cache_enabled' => false,
    ),
];

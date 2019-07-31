<?php

namespace App;

use function Roots\app;

/**
 * Simple function to pretty up our field partial includes.
 *
 * @param  mixed $partial
 * @return mixed
 */
function get_field_partial($partial)
{
    return include app()->resourcePath("fields/partials/{$partial}.php");
}

/**
 * Retrieves a list of humanized options for the relevant design control
 *
 * @param  string $control
 * @return array
 */
function get_choices($control)
{
    return array_keys(require app()->resourcePath("fields/controls/{$control}.php"));
}

<?php

namespace App\Composers;

use Illuminate\Support\Str;
use function Roots\app;
use function Roots\view;

/**
 * Class Names (cx)
 *
 * Resolves the classnames according the design control settings.
 * Loosely inspired by the classnames Node module.
 *
 * @param  array $controls
 * @return string
 */
function cx(array $controls)
{
    $classes = [];

    foreach ($controls as $control => $value) {
        $classes[] = collect(
            require app()->resourcePath("fields/controls/{$control}.php")
        )->get($value);
    }

    return implode(' ', $classes);
}

/**
 * Render block children
 *
 * @param  array $fields
 * @param  array $layout
 * @return string HTML
 */
function render($fields = [], $layout = [])
{
    $content = [];

    if (is_array($fields)) {
        foreach ($fields as $field) {
            $view = 'components.' . Str::slug($field['acf_fc_layout']);
            $data = array_merge($field, $layout);

            $content[] = in_array('full_width', $field) && $field['full_width'] === true
                ? view($view, $data)
                : view('components.block-child', [
                    'classes' => cx([
                        'columns' => $layout['columns'] ?? 'One',
                        'gutter' => $layout['gutter'] ?? 'None',
                    ]),
                    'view' => $view,
                    'data' => $data,
                ]);
        }
    }

    return implode('', $content);
}

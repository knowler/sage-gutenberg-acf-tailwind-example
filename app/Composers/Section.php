<?php

namespace App\Composers;

use Roots\Acorn\View\Composer;

class Section extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['blocks.section'];

    /**
     * Data to be passed to view before rendering.
     *
     * @param  array $data
     * @param  \Illuminate\View\View $view
     * @return array
     */
    public function with($block, $view)
    {
        /** Extract data from ACF */
        extract($block['acf']);

        return [
            'content' => render($content, $layout ?? []),
            'gutter' => $layout['gutter'] ?? 'None',
            'columns' => $layout['columns'] ?? 'Two',
            'classes' => cx([
                'bg-color' => $bg_color ?? 'White',
                'color' => $color ?? 'Black',
            ]),
        ];
    }
}

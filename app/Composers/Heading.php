<?php

namespace App\Composers;

use Roots\Acorn\View\Composer;

class Heading extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['components.heading'];

    /**
     * Data to be passed to view before rendering.
     *
     * @param  array $data
     * @param  \Illuminate\View\View $view
     * @return array
     */
    public function override($data, $view)
    {
        return [
            'classes' => cx([
                'font-size' => $data['font_size'] ?? 'Extra-Large 3',
            ]),
            'level' => $data['level'] ?? 2,
            'slot' => $data['slot'],
        ];
    }
}



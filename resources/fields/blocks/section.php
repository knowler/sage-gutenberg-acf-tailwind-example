<?php

use KMDigital\AcfBlockBuilder\Block;
use function App\get_choices;
use function App\get_field_partial;

/**
 * Initial a block field builder
 */
$section = new Block('section');

/** Allow full width, but not custom class names. */
$section
    ->setAlign('full')
    ->setSupports([
        'align' => ['full'],
        'customClassName' => false,
    ]);

/**
 * Content fields
 */
$section->addAccordion('content')
    ->addFlexibleContent('content')
        ->addLayout('heading', ['min' => 1])
            ->addFields(get_field_partial('heading'))
    ->endFlexibleContent();

/**
 * Design control fields
 */
$section->addAccordion('design')
    ->addSelect('bg_color', ['label' => 'Background Color'])
        ->addChoices(get_choices('bg-color'))
        ->setDefaultValue('Indigo')
    ->addSelect('color', ['label' => 'Text Color'])
        ->addChoices(get_choices('color'))
        ->setDefaultValue('White')
    ->addGroup('layout')
        ->addSelect('columns')
            ->addChoices(get_choices('columns'))
            ->setDefaultValue('Two')
        ->addSelect('gutter')
            ->addChoices(get_choices('gutter'))
    ->endGroup();

return $section;

<?php

use StoutLogic\AcfBuilder\FieldsBuilder;
use function App\get_choices;

$heading = new FieldsBuilder('heading');

$heading->addAccordion('content')
    ->addText('slot', ['label' => 'Text'])
    ->addSelect('level')
        ->addChoices([1, 2, 3, 4, 5, 6])
        ->setDefaultValue(2);

$heading->addAccordion('design')
    ->addSelect('font_size')
        ->addChoices(get_choices('font-size'))
        ->setDefaultvalue('Extra Large 3')
    ->addTrueFalse('full_width')
        ->setDefaultValue(true);

return $heading;

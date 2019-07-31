# Sage 10 with an ACF block builder

This is an example of how to set up Sage 10 with an ACF block
builder. For the CSS framework, we’ll build our own with
Tailwind.

## What’s happening?

First off all, in order to effectively use Tailwind with
Gutenberg in a way that is not invasive to a typical
utility-first workflow, we need to do some CSS magic. Gutenberg
wraps the frontend preview with a lot of CSS which has some
agressive specificity. Since utility classes in functional CSS
frameworks tend to have a low specificity<sup>1</sup> we need to
increase the specificity without bloating the public facing
stylesheet and punishing the visitor. We can achieve this by
creating two stylesheets: `app.css` and `editor.css`. Now, we
aren’t creating a second stylesheet to write a massive amount of
editor specific styles in, because that would be a waste of
time. What we’ll do with this second stylsheet is import
`app.css` and then set the base styles for the
`.acf-block-preview` element. Those base styles should match any
styles you’ve attached to the body.

```css
@import "app.css";

/** These are styles we’ve attached to the body */
.acf-block-preview {
  @apply bg-black text-white font-sans;

  /** Force children of this block to inherit its body styles */
  & * {
    color: inherit;
    font-family: inherit;
  }
}
```

Now we can share the PostCSS plugin stack between these two
stylesheet, but we can add `postcss-wrap` to the editor one, and
wrap it’s styles with `.acf-block-preview`. This effectively
scopes the styles to the block preview and gives it enough of a
specificity boost (in most cases) to avoid being overriden by
the greedy rules of the editor.

<small>
<sup>1</sup> Some methodologies like ITCSS prescribes utilities
to include `!important` — this is not the case with Tailwind or
Tachyons).
</small>

## A Flexible Content Block

Final HTML:

```html
<section class="bg-indigo-700 text-white py-8">
  <div class="container flex flex-wrap">
    <h2 class="w-full font-bold text-s4">Test</h2>
  </div>
</section>
```

Here is the Blade template for the Section component itself:

```html
<section class="{{ $classes }} py-8">
  <div class="container flex flex-wrap">
    {!! $content !!}
  </div>
</section>
```

The view composer for our section block collects the flexible
content layouts and determines how to render them.

If a layout requires itself to be full width, it will just
render the component itself:

```html
<h{{ $level }} class="w-full font-bold {{ $classes }}">{{ $slot }}</h{{ $level }}>
```

Otherwise, it will wrap the component with a `<div>` where it
can apply any styling options that the block (or the parent) has
specified. These might be the column width or gutter settings.

```html
<div class="{{ $classes }}">
  @include($view, $data)
</div>
```

## Composing Blocks

1. Create view in `resources/views/blocks/<my-block>.blade.php`.
2. Create fields schema in `resources/fields/blocks/<my-block>.php`.
3. Create view composer in `app/Composers/<MyBlock>.php`.
    * Register this in `config/view.php`.

## Composing Components (Pseudo-Blocks)

1. Create view in `resources/views/component/<my-component>.blade.php`.
2. Create fields schema in `resources/fields/partial/<my-component>.php`.
3. Create view composer in `app/Composers/<MyComponent>.php`.
    * Register this in `config/view.php`.

## Design Controls

Design controls are reusable ACF fields which can be shared
between blocks and components. This methodology works very well
with Tailwind.

We define our controls in: `resources/fields/controls`.

Each of these files just returns an associative array. That area
looks something like this:

```php
<?php

return [
  'Black' => 'bg-black',
  'White' => 'bg-white',
  'Indigo' => 'bg-indigo-700',
];
```

How this works is that the ACF field uses the keys in the
associative array and then the View Composer uses a helper
function which resolves the design choices into class names.
This is good because we never want to save class names to the
database.

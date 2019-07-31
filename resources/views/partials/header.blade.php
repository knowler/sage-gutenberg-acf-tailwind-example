<header>
  <div class="container">
    <a href="{{ home_url('/') }}">
      {{ get_bloginfo('name', 'display') }}
    </a>

    <nav>
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation']) !!}
      @endif
    </nav>
  </div>
</header>

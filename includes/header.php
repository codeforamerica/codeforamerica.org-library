<nav class="nav-global-primary">
  <ul class="layout-breve layout-tight">
    <li><a href="/blog">Blog</a></li>
    <li><a href="/library">Library</a></li>
    <li>
      <form class="search-global" id="search-global" action="https://www.google.com/search" method="get" role="search">
          <input type="search" id="search-global-input" class="search-global-input" autocomplete="off" placeholder="Search" name="q" />
          <!-- consider applying autofocus="autofocus" to input -->
          <button class="search-global-submit" id="search-global-submit" value="www.codeforamerica.org" type="submit" name="as_sitesearch">Search</button>
      </form>
    </li>
  </ul>
</nav>

<div class="masthead masthead-s">
  <div class="masthead-hero">
    <div class="masthead-image" 
      style="background-image: url('{{ page.masthead-image }}')">
    </div>
  </div>
  <header class="layout-semibreve masthead-header">
    <h1 class="page-title">Library</h1>
  </header>
</div>

<?= file_get_contents('http://www.codeforamerica.org/fragments/global-header.html') ?>

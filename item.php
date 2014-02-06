<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $item_id = $context->path_info();

?>

<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="utf-8">
    <title>Code for America</title>
    <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6435252/678502/css/fonts.css" />
    <link rel="stylesheet" href="http://style.codeforamerica.org/style/css/main.css">
    <link rel="stylesheet" href="http://style.codeforamerica.org/style/css/layout.css" media="all and (min-width: 40em)">
    <link href="http://style.codeforamerica.org/style/css/prism.css" rel="stylesheet" />
    <script src="http://style.codeforamerica.org/script/fittext.js" type="text/javascript"></script>
    
    
    <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if (lt IE 9)&(!IEMobile)]>
    <link rel="stylesheet" href="http://style.codeforamerica.org/style/css/layout.css" media="all">
    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    
<body>

<div class="js-container">

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

<div class="global-header">  
  <a href="/" class="global-header-logo">
      <img src="<?= $context->base() ?>/assets/logo.gif" />
  </a>
  <p class="skip-to-nav"><a href="#global-footer">Menu</a></p>

  <nav class="nav-global-secondary">
    <ul>
      <li class="nav-tier1 nav-has-children">
        <a href="/about">About</a>
      </li>
      <li class="nav-tier1 nav-has-children">
        <a href="/cities">Governments</a>
      </li>
      <li class="nav-tier1 nav-has-children">
        <a href="/geeks">Citizens</a>  
      </li>
      <li class="nav-tier1">
        <a href="/apps">Apps</a>
      </li>
      <li><a href="/donate" class="button">Donate</a></li>
    </ul>
  </nav>    
</div>

<main role="main">
<div class="layout-semibreve">

    <nav class="nav-breadcrumbs" role="navigation">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="<?= $context->base() ?>/">Library</a></li>
        </ul>
    </nav>
	
    <? if($item = get_item($context, $item_id)) { ?>
        <div class="heading">
            <h2><?= html($item['title']) ?></h2>
        </div>
    
        <div class="layout-minor">
            <h3 class="text-prominent">Category</h3>
            <ul class="list-no-bullets text-whisper link-invert">
                <li><a href="<?= category_href($context, $item['category']) ?>"><?= html($item['category']) ?></a></li>
            </ul>

            <h4 class="text-whisper layout-tight">Tags</h4>
            <p>
                <? foreach($item['tags'] as $tag) { ?>
                    <a href="<?= tag_href($context, $tag) ?>"><?= html($tag) ?></a>,
                <? } ?>
            </p>
        
            <? if(!empty($item['programs'])) { ?>
              <h4 class="text-whisper layout-tight">Programs</h4>
              <p>
                <? foreach($item['programs'] as $program) { ?>
                    <a href="<?= program_href($context, $program) ?>"><?= html($program) ?></a>,
                <? } ?>
              </p>
            <? } ?>
        
            <? if(!empty($item['locations'])) { ?>
              <h4 class="text-whisper layout-tight">Locations</h4>
              <p>
                <? foreach($item['locations'] as $location) { ?>
                    <a href="<?= location_href($context, $location) ?>"><?= html($location) ?></a>,
                <? } ?>
              </p>
            <? } ?>
        
            <h4 class="text-whisper layout-tight">Date</h4>
            <ul class="list-no-bullets text-whisper link-invert">
                <li><?= html($item['date']) ?></li>
            </ul>
        
        </div>
    
        <div class="layout-major">
            <dl>
                <dt>ID</dt>
                <dd><?= html($item['id']) ?></dd>
                <dt>Link</dt>
                <dd><a href="<?= html($item['link']) ?>"><?= html($item['link']) ?></a></dd>
                <dt>Format</dt>
                <dd><?= html($item['format']) ?></dd>
            </dl>
        </div>
    <? } ?>
</div>
    
<div class="global-footer" id="global-footer">
  
  <div class="layout-breve layout-tight">
  
    <form class="search-global" action="https://www.google.com/search" method="get">
        <input type="search" autocomplete="off" placeholder="Search" name="q" />
        <input name="as_sitesearch" value="www.codeforamerica.org" type="hidden" />
    </form>
  
    <nav class="nav-footer" role="navigation">
      <ul>
        <li class="nav-tier1"><a class="nav-heading" href="/">Home</a></li>
        <li class="nav-tier1"><a class="nav-heading" href="/about">About</a>
          <ul class="nav-tier2">
            <li><a href="/about/fellowship">Fellowship</a></li>
            <li><a href="/about/brigade">Brigade</a></li>
            <li><a href="/about/startups">Civic Startups</a></li>
            <li><a href="/about/peernetwork">Peer Network</a></li>
            <li><a href="/about/international">International</a></li>
            <li><a href="/about/team">Team</a></li>
            <li><a href="/supporters">Supporters</a></li>
            <li><a href="/press">Press</a></li>
            <li><a href="/jobs">Jobs</a></li>
            <li><a href="/contact">Contact</a></li>
          </ul>
        </li>
      
        <li class="nav-tier1"><a class="nav-heading" href="/cities">Governments</a>
          <ul class="nav-tier2">
            <li><a href="/cities/atlanta">Atlanta, GA</a></li>
            <li><a href="/cities/charlotte">Charlotte, NC</a></li>
            <li><a href="/cities/chattanooga">Chattanooga, TN</a></li>
            <li><a href="/cities/denver">Denver, CO</a></li>
            <li><a href="/cities/lexington">Lexington, KY</a></li>
            <li><a href="/cities/longbeach">Long Beach, CA</a></li>
            <li><a href="/cities/mesa">Mesa, AZ</a></li>
            <li><a href="/cities/rhodeisland">Rhode Island</a></li>
            <li><a href="/cities/sanantonio">San Antonio, TX</a></li>
            <li><a href="/cities/sanjuan">San Juan, PR</a></li>
            <li><a href="/cities/alumni">Alumni Partners</a></li>
            <li><a href="/about/peernetwork">Peer Network</a></li>
            <li><a href="/cities/data-standards-faq">Data Standards</a></li>
          </ul>
        </li>
          <li class="nav-tier1"><a class="nav-heading" href="/geeks">Citizens</a>
          <ul class="nav-tier2">
            <li><a href="/geeks/our-geeks">Our Geeks</a></li>
            <li><a href="https://github.com/codeforamerica">Our Code</a></li>
            <li><a href="/geeks/our-startups">Our Startups</a></li>
            <li><a href="/events">Events</a></li>
            <li><a href="https://github.com/codeforamerica/hack-requests">Requests</a></li>
          </ul>
        </li>
           </li>
          <li class="nav-tier1"><a class="nav-heading" href="/apps">Apps</a>
          <ul class="nav-tier2">
            <li><a href="/apps/local-service.html#nav-tabs">Local Service</a></li>
            <li><a href="/apps/citizen-engagement.html#nav-tabs">Citizen Engagement</a></li>
            <li><a href="/apps/free.html#nav-tabs">Free Apps</a></li>
            <li><a href="/apps/paid.html#nav-tabs">Paid Apps</a></li>
          </ul>
        </li>
        <li class="nav-tier1"><a class="nav-heading" href="/donate">Donate</a>
          <ul class="nav-tier2">
            <li><a href="/donate/form">Financial Contributions</a></li>
          </ul>
        </li>
        <li class="nav-tier1"><a class="nav-heading">Social</a>
          <ul class="nav-tier2">
            <li><a href="https://www.facebook.com/codeforamerica" class="icon-facebook">Facebook</a></li>
            <li><a href="https://twitter.com/codeforamerica" class="icon-twitter">Twitter</a></li>
            <li><a href="http://www.youtube.com/user/CodeforAmerica" class="icon-youtube">YouTube</a></li>
            <li><a href="https://github.com/codeforamerica" class="icon-github2">GitHub</a></li>
            <li><a href="http://codeforamerica.tumblr.com/" class="icon-tumblr">Tumblr</a></li>
            <li><a href="http://www.flickr.com/photos/codeforamerica" class="icon-flickr">Flickr</a></li>
            <li><a href="http://www.codeforamerica.org/feed/" class="icon-feed">RSS</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>

<div class="global-foot" role="contentinfo">
  <div class="layout-tight layout-breve">
    <div class="global-foot-content">
      <img class="global-foot-logo" src="<?= $context->base() ?>/assets/logo-inversed.png" />
      <small>Code for America Labs, Inc is a non-partisan, non-political 501(c)(3) organization. Content is licensed through Creative Commons.</small>
    </div>
  </div>
</div>

</main>

</div><!-- /.js-container -->
<script src="http://style.codeforamerica.org/script/global.js"></script>

</body>
</html>

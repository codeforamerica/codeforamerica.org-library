<?php

    class Context
    {
        // PDO handle to SQLite DB.
        var $dbh;
    
        function __construct($dbname)
        {
            $this->dbh = new PDO("sqlite:{$dbname}");
        }
        
       /**
        * Run a query, fetch results list as associative arrays, and return.
        */
        function select($q)
        {
            return $this->dbh->query($q, PDO::FETCH_ASSOC);
        }
        
       /**
        * Call select() with the same parameters as sprintf: format + args list.
        */
        function selectf($format)
        {
            $args = array_map(array($this->dbh, 'quote'), func_get_args());
            $args[0] = $format; // don't quote the format string
            $query = call_user_func_array('sprintf', $args);

            return $this->select($query);
        }
        
        function path_info()
        {
            return urldecode(ltrim($_SERVER['PATH_INFO'], '/'));
        }
        
        function base()
        {
            return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        }
    }
    
    function html($string)
    {
        return htmlspecialchars($string);
    }
    
    function enc($string)
    {
        return urlencode($string);
    }
    
    function item_href(&$ctx, $item)
    {
        $name = $item['slug'] ? $item['slug'] : $item['id'];
        return $ctx->base() . '/item/' . urlencode($name);
    }
    
    function category_href(&$ctx, $category)
    {
        return $ctx->base() . '/category/' . urlencode($category);
    }
    
    function tag_href(&$ctx, $tag)
    {
        return $ctx->base() . '/tag/' . urlencode($tag);
    }
    
    function program_href(&$ctx, $program)
    {
        return $ctx->base() . '/program/' . urlencode($program);
    }
    
    function location_href(&$ctx, $location)
    {
        return $ctx->base() . '/location/' . urlencode($location);
    }
    
    function person_href(&$ctx, $person)
    {
        return '#'; //$ctx->base() . '/person/' . urlencode($person['name']);
    }
    
    function embed_html($item)
    {
        if(preg_match('#^https?://(www.)?youtube.com/#', $item['link']))
        {
            if(preg_match('#\bv=(\w[\-\w]+\w)\b#', $item['link'], $m)) {
                $id = $m[1];

            } else {
                return;
            }
            
            $url = "//www.youtube.com/embed/{$id}";
            $url .= preg_match('#\blist=(\w[\-\w]+\w)\b#', $item['link'], $m)
                ? "?list={$m[1]}" : '';
            
            return "
                <div class='youtube video-embed'>
                  <div><iframe src='{$url}' frameborder='0' allowfullscreen></iframe></div>
                </div>
                ";
        }
        
        if(preg_match('#^https?://(www.)?vimeo.com(/album/\w+/video)?/(\w+)$#', $item['link'], $m))
        {
            $id = $m[3];
            $url = "//player.vimeo.com/video/{$id}?title=0&amp;byline=0&amp;portrait=0";
        
            return "
                <div class='vimeo video-embed'>
                  <div><iframe src='{$url}' frameborder='0' allowfullscreen></iframe></div>
                </div>
                ";
        }
    }
    
    function get_categories(&$ctx)
    {
        $categories = array();

        $query = 'SELECT DISTINCT category
                  FROM items WHERE category IS NOT NULL AND category != ""
                  ORDER BY category';
        
        foreach($ctx->select($query) as $row)
        {
            $categories[] = $row['category'];
        }
        
        return $categories;
    }
    
    function get_tags(&$ctx)
    {
        $tags = array();

        $query = 'SELECT DISTINCT tag
                  FROM item_tags WHERE tag IS NOT NULL AND tag != ""
                  ORDER BY tag';
        
        foreach($ctx->select($query) as $row)
        {
            $tags[] = $row['tag'];
        }
        
        return $tags;
    }
    
    function get_programs(&$ctx)
    {
        $programs = array();

        $query = 'SELECT DISTINCT program
                  FROM item_programs WHERE program IS NOT NULL AND program != ""
                  ORDER BY program';
        
        foreach($ctx->select($query) as $row)
        {
            $programs[] = $row['program'];
        }
        
        return $programs;
    }
    
    function get_locations(&$ctx)
    {
        $locations = array();

        $query = 'SELECT DISTINCT location
                  FROM item_locations WHERE location IS NOT NULL AND location != ""
                  ORDER BY location';
        
        foreach($ctx->select($query) as $row)
        {
            $locations[] = $row['location'];
        }
        
        return $locations;
    }
    
    function get_category_items(&$ctx, $category_name)
    {
        $query = 'SELECT * FROM items
                  WHERE category = %s
                  ORDER BY title';
        
        $items = $ctx->selectf($query, $category_name);
        
        return $items;
    }
    
    function get_tag_items(&$ctx, $tag_name)
    {
        $query = 'SELECT items.* FROM item_tags
                  LEFT JOIN items ON items.id = item_tags.item_id
                  WHERE item_tags.tag = %s
                  ORDER BY items.title';
        
        $items = $ctx->selectf($query, $tag_name);
        
        return $items;
    }
    
    function get_program_items(&$ctx, $program_name)
    {
        $query = 'SELECT items.* FROM item_programs
                  LEFT JOIN items ON items.id = item_programs.item_id
                  WHERE item_programs.program = %s
                  ORDER BY items.title';
        
        $items = $ctx->selectf($query, $program_name);
        
        return $items;
    }
    
    function get_location_items(&$ctx, $location_name)
    {
        $query = 'SELECT items.* FROM item_locations
                  LEFT JOIN items ON items.id = item_locations.item_id
                  WHERE item_locations.location = %s
                  ORDER BY items.title';
        
        $items = $ctx->selectf($query, $location_name);
        
        return $items;
    }
    
    function get_item_tags(&$ctx, $item_id)
    {
        $tags = array();

        $query = 'SELECT tag FROM item_tags
                  WHERE item_id = %s AND tag != ""
                  ORDER BY tag';
        
        foreach($ctx->selectf($query, $item_id) as $row)
        {
            $tags[] = $row['tag'];
        }
        
        return $tags;
    }
    
    function get_item_locations(&$ctx, $item_id)
    {
        $locations = array();

        $query = 'SELECT location FROM item_locations
                  WHERE item_id = %s AND location != ""
                  ORDER BY location';
        
        foreach($ctx->selectf($query, $item_id) as $row)
        {
            $locations[] = $row['location'];
        }
        
        return $locations;
    }
    
    function get_item_programs(&$ctx, $item_id)
    {
        $programs = array();

        $query = 'SELECT program FROM item_programs
                  WHERE item_id = %s AND program != ""
                  ORDER BY program';
        
        foreach($ctx->selectf($query, $item_id) as $row)
        {
            $programs[] = $row['program'];
        }
        
        return $programs;
    }
    
    function get_item_contacts(&$ctx, $item_id)
    {
        $query = 'SELECT people.* FROM item_contacts
                  LEFT JOIN people ON people.id = item_contacts.person_id
                  WHERE item_id = %s';
        
        
        $contacts = $ctx->selectf($query, $item_id);
        
        return $contacts;
    }
    
    function get_item_contributors(&$ctx, $item_id)
    {
        $query = 'SELECT people.* FROM item_contributors
                  LEFT JOIN people ON people.id = item_contributors.person_id
                  WHERE item_id = %s';
        
        $contributors = $ctx->selectf($query, $item_id);
        
        return $contributors;
    }
    
    function get_item(&$ctx, $name)
    {
        $query = 'SELECT * FROM items
                  WHERE id = %s OR slug = %s
                  ORDER BY CAST(slug = %s AS INT) DESC';
        
        foreach($ctx->selectf($query, $name, $name, $name) as $row)
        {
            $row['tags'] = get_item_tags($ctx, $row['id']);
            $row['locations'] = get_item_locations($ctx, $row['id']);
            $row['programs'] = get_item_programs($ctx, $row['id']);
            $row['contacts'] = get_item_contacts($ctx, $row['id']);
            $row['contributors'] = get_item_contributors($ctx, $row['id']);
        
            return $row;
        }
        
        return null;
    }

?>

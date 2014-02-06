<?php

    class Context
    {
        // PDO handle to SQLite DB.
        var $dbh;
    
        function __construct($dbname)
        {
            $this->dbh = new PDO("sqlite:{$dbname}");
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
    
    function get_categories(&$ctx)
    {
        $categories = array();
        $query = 'SELECT DISTINCT category
                  FROM items WHERE category IS NOT NULL AND category != ""
                  ORDER BY category';
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
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
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
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
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
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
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $locations[] = $row['location'];
        }
        
        return $locations;
    }
    
    function get_category_items(&$ctx, $category_name)
    {
        $items = array();
        $query = sprintf('SELECT * FROM items
                          WHERE category = %s
                          ORDER BY title',
                         $ctx->dbh->quote($category_name));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $items[] = $row;
        }
        
        return $items;
    }
    
    function get_tag_items(&$ctx, $tag_name)
    {
        $items = array();
        $query = sprintf('SELECT items.* FROM item_tags
                          LEFT JOIN items ON items.id = item_tags.item_id
                          WHERE item_tags.tag = %s
                          ORDER BY items.title',
                         $ctx->dbh->quote($tag_name));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $items[] = $row;
        }
        
        return $items;
    }
    
    function get_program_items(&$ctx, $program_name)
    {
        $items = array();
        $query = sprintf('SELECT items.* FROM item_programs
                          LEFT JOIN items ON items.id = item_programs.item_id
                          WHERE item_programs.program = %s
                          ORDER BY items.title',
                         $ctx->dbh->quote($program_name));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $items[] = $row;
        }
        
        return $items;
    }
    
    function get_location_items(&$ctx, $location_name)
    {
        $items = array();
        $query = sprintf('SELECT items.* FROM item_locations
                          LEFT JOIN items ON items.id = item_locations.item_id
                          WHERE item_locations.location = %s
                          ORDER BY items.title',
                         $ctx->dbh->quote($location_name));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $items[] = $row;
        }
        
        return $items;
    }
    
    function get_item_tags(&$ctx, $item_id)
    {
        $tags = array();
        $query = sprintf('SELECT tag FROM item_tags
                          WHERE item_id = %s AND tag != ""
                          ORDER BY tag',
                         $ctx->dbh->quote($item_id));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $tags[] = $row['tag'];
        }
        
        return $tags;
    }
    
    function get_item_locations(&$ctx, $item_id)
    {
        $locations = array();
        $query = sprintf('SELECT location FROM item_locations
                          WHERE item_id = %s AND location != ""
                          ORDER BY location',
                         $ctx->dbh->quote($item_id));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $locations[] = $row['location'];
        }
        
        return $locations;
    }
    
    function get_item_programs(&$ctx, $item_id)
    {
        $programs = array();
        $query = sprintf('SELECT program FROM item_programs
                          WHERE item_id = %s AND program != ""
                          ORDER BY program',
                         $ctx->dbh->quote($item_id));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $programs[] = $row['program'];
        }
        
        return $programs;
    }
    
    function get_item(&$ctx, $item_id)
    {
        $query = sprintf('SELECT * FROM items WHERE id = %s LIMIT 1',
                         $ctx->dbh->quote($item_id));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $row['tags'] = get_item_tags($ctx, $item_id);
            $row['locations'] = get_item_locations($ctx, $item_id);
            $row['programs'] = get_item_programs($ctx, $item_id);
        
            return $row;
        }
        
        return null;
    }

?>

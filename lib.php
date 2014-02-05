<?php

    class Context
    {
        // PDO handle to SQLite DB.
        var $dbh;
    
        function __construct($dbname)
        {
            $this->dbh = new PDO("sqlite:{$dbname}");
        }
    }
    
    function get_categories(&$ctx)
    {
        $categories = array();
        $query = 'SELECT DISTINCT category
                  FROM items WHERE category IS NOT NULL
                  ORDER BY category';
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $categories[] = $row['category'];
        }
        
        return $categories;
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
    
    function get_item(&$ctx, $item_id)
    {
        $query = sprintf('SELECT * FROM items WHERE id = %s LIMIT 1',
                         $ctx->dbh->quote($item_id));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            return $row;
        }
        
        return null;
    }

?>

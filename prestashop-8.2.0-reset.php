<?php
// Database configuration
define('_DB_SERVER_', 'localhost');  // Replace with your server
define('_DB_NAME_', 'prestashop');   // Replace with your database name
define('_DB_USER_', 'root');         // Replace with your username
define('_DB_PASSWD_', '');           // Replace with your password
define('_DB_PREFIX_', 'ps_');        // Table prefix, default is 'ps_'

try {
    // Database connection
    $db = new PDO('mysql:host='._DB_SERVER_.';dbname='._DB_NAME_, _DB_USER_, _DB_PASSWD_);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tables to empty (TRUNCATE) - Updated for PS 8.2
    $tables_to_truncate = [
        // Products and combinations
        _DB_PREFIX_.'product',
        _DB_PREFIX_.'product_lang',
        _DB_PREFIX_.'product_shop',
        _DB_PREFIX_.'product_combination',
        _DB_PREFIX_.'product_combination_shop',
        _DB_PREFIX_.'combination',
        _DB_PREFIX_.'combination_shop',
        _DB_PREFIX_.'product_attribute',
        _DB_PREFIX_.'product_attribute_shop',
        
        // Categories
        _DB_PREFIX_.'category',
        _DB_PREFIX_.'category_lang',
        _DB_PREFIX_.'category_shop',
        _DB_PREFIX_.'category_product',
        
        // Customers and orders
        _DB_PREFIX_.'cart',
        _DB_PREFIX_.'cart_product',
        _DB_PREFIX_.'orders',
        _DB_PREFIX_.'order_detail',
        _DB_PREFIX_.'customer',
        
        // CMS
        _DB_PREFIX_.'cms',
        _DB_PREFIX_.'cms_lang',
        _DB_PREFIX_.'cms_category',
        _DB_PREFIX_.'cms_category_lang',
        _DB_PREFIX_.'cms_role',
        _DB_PREFIX_.'cms_role_lang',
        
        // Brands and suppliers
        _DB_PREFIX_.'manufacturer',
        _DB_PREFIX_.'manufacturer_lang',
        _DB_PREFIX_.'manufacturer_shop',
        _DB_PREFIX_.'supplier',
        _DB_PREFIX_.'supplier_lang',
        _DB_PREFIX_.'supplier_shop',
        
        // Images
        _DB_PREFIX_.'image',
        _DB_PREFIX_.'image_lang',
        _DB_PREFIX_.'image_shop',
        _DB_PREFIX_.'image_type',
        
        // Stock
        _DB_PREFIX_.'stock_available',
        _DB_PREFIX_.'stock_mvt',
        _DB_PREFIX_.'stock',
        
        // Specific prices
        _DB_PREFIX_.'specific_price',
        _DB_PREFIX_.'specific_price_rule',
        
        // Features and attributes
        _DB_PREFIX_.'feature_product',
        _DB_PREFIX_.'feature',
        _DB_PREFIX_.'feature_lang',
        _DB_PREFIX_.'feature_value',
        _DB_PREFIX_.'feature_value_lang',
        
        // SEO and URLs
        _DB_PREFIX_.'alias',
        _DB_PREFIX_.'search_index',
        _DB_PREFIX_.'search_word',
        _DB_PREFIX_.'meta',
        _DB_PREFIX_.'meta_lang',
        
        // Tags
        _DB_PREFIX_.'tag',
        _DB_PREFIX_.'product_tag'
    ];

    // Empty tables
    foreach ($tables_to_truncate as $table) {
        try {
            $db->exec("SET FOREIGN_KEY_CHECKS = 0");
            $db->exec("TRUNCATE TABLE IF EXISTS $table");
            $db->exec("SET FOREIGN_KEY_CHECKS = 1");
            echo "Table $table emptied\n";
        } catch (PDOException $e) {
            echo "Notice: Table $table doesn't exist or cannot be emptied\n";
            continue;
        }
    }

    // File cleanup
    $directories_to_clean = [
        'img/p/',       // Product images
        'img/c/',       // Category images
        'img/m/',       // Manufacturer images
        'img/s/',       // Supplier images
        'img/cms/',     // CMS images
        'download/',    // Downloadable files
        'upload/',      // Uploaded files
        'var/cache/'    // Cache files
    ];

    foreach ($directories_to_clean as $dir) {
        if (is_dir($dir)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                // Preserve system files
                if ($fileinfo->getFilename() !== '.htaccess' && 
                    $fileinfo->getFilename() !== 'index.php' && 
                    $fileinfo->getFilename() !== '.gitkeep') {
                    if ($fileinfo->isDir()) {
                        @rmdir($fileinfo->getRealPath());
                    } else {
                        @unlink($fileinfo->getRealPath());
                    }
                }
            }
            echo "Directory $dir cleaned<br>";
        }
    }

    // Reset default category
    try {
        $db->exec("INSERT INTO "._DB_PREFIX_."category VALUES (1, 0, 1, 1, 1, NOW(), NOW(), 0, 0)");
        $db->exec("INSERT INTO "._DB_PREFIX_."category_lang (id_category, id_lang, name, description, link_rewrite, meta_title, meta_keywords, meta_description) 
                  SELECT 1, id_lang, 'Root', '', 'root', '', '', '' FROM "._DB_PREFIX_."lang");
        $db->exec("INSERT INTO "._DB_PREFIX_."category_shop (id_category, id_shop, position) VALUES (1, 1, 0)");
        echo "Root category recreated<br>";
    } catch (PDOException $e) {
        echo "Notice: Root category already exists<br>";
    }

    echo "Cleanup completed successfully!<br>";
    echo "Your shop has been reset while preserving login credentials.<br>";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

# PrestaShop Reset

This script provides a streamlined way to reset a PrestaShop 8.2 installation to its base state while preserving administrator credentials. It removes all content and media files while maintaining the core system functionality.

## Prerequisites
- PrestaShop 8.2 installed
- Database access credentials
- PHP 7.4 or higher
- Sufficient permissions to modify files and database

## Installation
1. Download the `prestashop-8.2.0-reset.php` script
2. Open the script in a text editor and update the database configuration:
   ```php
   define('_DB_SERVER_', 'localhost');
   define('_DB_NAME_', 'prestashop');
   define('_DB_USER_', 'root');
   define('_DB_PASSWD_', '');
   define('_DB_PREFIX_', 'ps_');
   ```
3. Place the script in your PrestaShop root directory
4. Execute the script through your web browser or command line

## What Gets Cleaned

### Database Tables
- Products and combinations
- Categories
- Customers and orders
- CMS content
- Brands and suppliers
- Images references
- Stock information
- Specific prices
- Features and attributes
- SEO data and URLs
- Tags

### Directories
- `img/p/` - Product images
- `img/c/` - Category images
- `img/m/` - Manufacturer images
- `img/s/` - Supplier images
- `img/cms/` - CMS images
- `download/` - Downloadable files
- `upload/` - Uploaded files
- `var/cache/` - Cache files

## Safety Measures

The script includes several safety features:
- Preserves system files (.htaccess, index.php)
- Maintains administrator credentials
- Includes error handling for each operation
- Keeps core configuration intact

Before using this script:
1. Create a complete backup of your database and files
2. Verify database credentials
3. Test in a development environment first
4. Remove the script after use for security


## Supporting The Project

If you find this project beneficial and appreciate its contributions, you might consider offering your support. One of the ways you can do this is through a Bitcoin donation!

Here is the Bitcoin address:
`bc1q3pc0ftvdew3e87k07d00k8tqj7ll924hgy69n6`

By donating Bitcoin, you are not only providing tangible assistance, but also endorsing the use of decentralized digital currencies. This encourages further innovation and freedom in the financial sector, aligning with the open source principles that guide this project.

Every donation, big or small, is deeply appreciated and will be used to further improve and maintain this project. Your support helps dedicate more time and resources, ensuring the project's continuity and enhancement!

## Author

This project is maintained by Yann Rimbaud ([yrimbaud](https://github.com/yrimbaud)).

## Licence

This project is licensed under the MIT License.
1. Create an issue
2. Submit a pull request
3. Contact the maintainer

The goal is to keep this script efficient, secure, and up-to-date with the latest PrestaShop versions.

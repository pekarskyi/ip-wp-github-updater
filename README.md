# IP WordPress GitHub Updater

A WordPress plugin update system via GitHub releases. This works only for public releases.

![https://github.com/pekarskyi/assets/raw/master/ip-wp-github-updater/ip-get-logger_update-plugin.jpg](https://github.com/pekarskyi/assets/raw/master/ip-wp-github-updater/ip-get-logger_update-plugin.jpg)

## Description

This tool allows you to automate the updating of your WordPress plugins directly from GitHub. The system automatically checks for new releases in your GitHub repository and offers updates through the standard WordPress interface.

## Installation

1. Copy the `updates` directory into your plugin folder.
2. Add the following code to the main file of your plugin (for example, somewhere at the end of the file):

```php
// Adding update check via GitHub
require_once plugin_dir_path( __FILE__ ) . 'updates/github-updater.php';

$github_username = 'github_username'; // Specify your GitHub username
$repo_name = 'repo_name'; // Specify your GitHub repository name, for example ip-wp-github-updater
$prefix = 'your_prefix'; // Set a unique plugin prefix, for example ip_wp_github_updater

// Initialize the GitHub plugin update system
if ( function_exists( 'ip_github_updater_load' ) ) {
    // Load the updater file with our prefix
    ip_github_updater_load($prefix);
    
    // Create the update function name from the prefix
    $updater_function = $prefix . '_github_updater_init';   
    
    // After loading, our update function should be available
    if ( function_exists( $updater_function ) ) {
        call_user_func(
            $updater_function,
            __FILE__,       // Plugin file path
            $github_username, // Your GitHub username
            $repo_name       // Repository name (based on prefix)
        );
    }
} 
```
(The function code is also duplicated in the func_connect.php file)

Change these values to your own:

- `$github_username = 'github_username';` - specify your GitHub username
- `$repo_name = 'repo_name';` - specify your GitHub repository name, for example ip-wp-github-updater
- `$prefix = 'your_prefix';` - specify a unique plugin prefix, for example ip_wp_github_updater

With this, the update system connection for your plugin is complete.

Next, you can create a new version of the plugin and upload it to GitHub.

Read on for versioning recommendations.

## Setting Plugin Version

### Versioning Recommendations

1. **Always specify the plugin version in the header of the main file**:
   ```php
   /**
    * Plugin Name: Plugin Name
    * Version: 1.0.0
    */
   ```

2. **Versioning Format**:
   - It is recommended to use [Semantic Versioning](https://semver.org/): `MAJOR.MINOR.PATCH`
   - Example: `1.0.0`, `1.2.3`, `2.0.0`

3. **Version Consistency**:
   - The version in the plugin header should match the version in internal constants/variables. Update the version in all places in your code before creating a new release.

Example of version consistency in your plugin files:

```php
class My_Plugin {
    private $version;
    
    public function __construct() {
        // Get the version from the plugin header to avoid discrepancies
        $plugin_data = get_plugin_data( __FILE__ );
        $this->version = $plugin_data['Version'];
    }
}
```

## Creating GitHub Releases

1. Create a new release/tag in your GitHub repository
2. Use the same version number as in the plugin header (optionally with a `v` prefix)
3. Add a description of changes in the "Release notes" field - this information will be displayed as a changelog
4. Optional: Upload a ready-made ZIP archive of the plugin as an asset for the release

## Potential Issues and Solutions

- **Update notification doesn't appear**: Ensure that the tag in GitHub has a higher version than in the plugin
- **Error during update**: Check access permissions for the plugin directory on the server
- **Directory structure mismatch**: Make sure the directory structure in the GitHub archive matches the plugin structure

## GitHub API Usage Limitations

GitHub has limits on the number of API requests. For public repositories, the limit is `60 requests per hour from a single IP address`. To increase this limit, you can use a GitHub API token. 

## Changelog

1.1.0 (05-04-2025):
- Improved and optimized version

1.0.0 (01-04-2025):
- Initial release
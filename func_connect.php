// Adding update check via GitHub
require_once plugin_dir_path( __FILE__ ) . 'updates/github-updater.php';
if ( function_exists( 'ip_woo_cleaner_github_updater_init' ) ) {
    ip_woo_cleaner_github_updater_init(
        __FILE__,       // Plugin file path
        'pekarskyi',     // Your GitHub username
        '',              // Access token (empty)
        'ip-woo-cleaner' // Repository name (optional)
        // Other parameters are determined automatically
    );
} 
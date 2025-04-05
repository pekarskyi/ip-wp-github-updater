// Adding update check via GitHub
require_once plugin_dir_path( __FILE__ ) . 'updates/github-updater.php';

$github_username = 'pekarskyi'; // Вказуємо ім'я користувача GitHub
$repo_name = 'repo_name'; // Вказуємо ім'я репозиторію GitHub, наприклад ip-wp-github-updater
$prefix = 'your_prefix'; // Встановлюємо унікальний префікс плагіну, наприклад ip_wp_github_updater
//$access_token = defined('IP_QUICK_ORDER_TOKEN') ? IP_QUICK_ORDER_TOKEN : '';

// Ініціалізуємо систему оновлення плагіну з GitHub
if ( function_exists( 'ip_github_updater_load' ) ) {
    // Завантажуємо файл оновлювача з нашим префіксом
    ip_github_updater_load($prefix);
    
    // Формуємо назву функції оновлення з префіксу
    $updater_function = $prefix . '_github_updater_init';   
    
    // Після завантаження наша функція оновлення повинна бути доступна
    if ( function_exists( $updater_function ) ) {
        call_user_func(
            $updater_function,
            __FILE__,       // Plugin file path
            $github_username, // Your GitHub username
            $access_token,              // Access token
            $repo_name       // Repository name (на основі префіксу)
        );
    }
} 
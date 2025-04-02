# IP WordPress GitHub Updater

Система оновлення плагінів WordPress через релізи GitHub.

![https://github.com/pekarskyi/assets/raw/master/ip-wp-github-updater/ip-get-logger_update-plugin.jpg](https://github.com/pekarskyi/assets/raw/master/ip-wp-github-updater/ip-get-logger_update-plugin.jpg)

## Опис

Цей інструмент дозволяє автоматизувати оновлення ваших плагінів WordPress безпосередньо з GitHub. Система автоматично перевіряє наявність нових релізів у вашому GitHub репозиторії та пропонує оновлення через стандартний інтерфейс WordPress.

## Інсталяція

1. Скопіюйте директорію `updates` в папку вашого плагіну.
2. Додайте наступний код у головний файл вашого плагіну (наприклад, десь в кінець файлу):

```php
// Adding update check via GitHub
require_once plugin_dir_path( __FILE__ ) . 'updates/github-updater.php';

$github_username = 'github_username'; // Вказуємо ім'я користувача GitHub
$repo_name = 'repo_name'; // Вказуємо ім'я репозиторію GitHub, наприклад ip-wp-github-updater
$prefix = 'your_prefix'; // Встановлюємо унікальний префікс плагіну, наприклад ip_wp_github_updater

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
            '',              // Access token (empty)
            $repo_name       // Repository name (на основі префіксу)
        );
    }
} 
```
(Код функції продублював також в файлі func_connect.php)

Змініть ці дані на власні:

- `$github_username = 'github_username';` - вкажіть ім'я користувача GitHub
- `$repo_name = 'repo_name';` - вкажіть ім'я репозиторію GitHub, наприклад ip-wp-github-updater
- `$prefix = 'your_prefix';` - вкажіть унікальний префікс плагіну, наприклад ip_wp_github_updater

## Вказування версії плагіну

### Рекомендації щодо версіонування

1. **Завжди вказуйте версію плагіну в шапці головного файлу**:
   ```php
   /**
    * Plugin Name: Назва Плагіну
    * Version: 1.0.0
    */
   ```

2. **Формат версіонування**:
   - Рекомендується використовувати [Semantic Versioning](https://semver.org/): `MAJOR.MINOR.PATCH`
   - Приклад: `1.0.0`, `1.2.3`, `2.0.0`

3. **Узгодження версій**:
   - Версія в шапці плагіну повинна відповідати версії у внутрішніх константах/змінних. Оновіть версію у всіх місцях коду перед створенням нового релізу.

Приклад узгодження версій в файлах вашого плагіну:

```php
class My_Plugin {
    private $version;
    
    public function __construct() {
        // Отримуємо версію з шапки плагіну для уникнення розбіжностей
        $plugin_data = get_plugin_data( __FILE__ );
        $this->version = $plugin_data['Version'];
    }
}
```

## Створення релізів у GitHub

1. Створіть новий реліз/тег у вашому GitHub репозиторії
2. Використовуйте той самий номер версії, що й у шапці плагіну (можна з префіксом `v`)
3. Додайте опис змін у полі "Release notes" - ця інформація відображатиметься як changelog
4. Опціонально: завантажте готовий ZIP-архів плагіну як asset для релізу

## Можливі проблеми та рішення

- **Не з'являється сповіщення про оновлення**: переконайтесь, що тег у GitHub має вищу версію, ніж у плагіні
- **Помилка при оновленні**: перевірте права доступу для директорії плагіну на сервері
- **Невідповідність структури директорій**: переконайтесь, що структура директорій у GitHub архіві відповідає структурі плагіну

## Обмеження використання API GitHub

GitHub має обмеження на кількість запитів до API. Для публічних репозиторіїв ліміт становить `60 запитів на годину з однієї IP-адреси`. Для збільшення ліміту можна використати GitHub API token. 
# IP WordPress GitHub Updater

Система автоматичного оновлення WordPress плагінів через GitHub релізи.

![https://github.com/pekarskyi/assets/raw/master/ip-wp-github-updater/ip-get-logger_update-plugin.jpg](https://github.com/pekarskyi/assets/raw/master/ip-wp-github-updater/ip-get-logger_update-plugin.jpg)

## Опис

Цей інструмент дозволяє автоматизувати оновлення ваших WordPress плагінів безпосередньо з GitHub. Система автоматично перевіряє наявність нових релізів у вашому GitHub репозиторії та пропонує оновлення через стандартний інтерфейс WordPress.

## Інсталяція

1. Скопіюйте директорію `updates` з файлом `github-updater.php` до вашого плагіну.
2. В файлі `github-updater.php`, в рядку 24: `$prefix = 'IP_WOO_CLEANER';` вкажіть унікальний префікс (можна в нижньому регістрі)
3. Підключіть файл у головному файлі вашого плагіну.

### Основне підключення

Додайте наступний код у головний файл вашого плагіну:

```php
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
```

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

3. **Синхронізація з тегами GitHub**:
   - Створюйте теги в GitHub з такими ж версіями, як у плагіні
   - Система підтримує префікс `v` в тегах GitHub (наприклад, `v1.0.0`)

4. **Узгодження версій**:
   - Версія в шапці плагіну повинна відповідати версії у внутрішніх константах/змінних
   - Оновіть версію у всіх місцях коду перед створенням нового релізу

```php
// Приклад узгодження версій
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

GitHub має обмеження на кількість запитів до API. Для публічних репозиторіїв ліміт становить 60 запитів на годину з однієї IP-адреси. Для збільшення ліміту можна використати GitHub API token. 
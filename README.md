<h1 align="center"> Laravel Notion API</h1>

## Примечание

Пакет модифицирован, относительно базового пакета `5am-code/laravel-notion-api`  
Добавлена поддержка children в блоках.  
Управление загрузкой children осуществляется вне библиотеки.  
Пример реализации находится в  `examples\NotionService.php`

## Установка

Необходимо добавить в composer.json репозиторий:
```json
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:famiryru/laravel-notion-api.git"
    }
  ]
```

После этого установить пакет с помощью composer:

```bash
composer require mamadogroup/laravel-notion-api
```

> Ниже официальная документация пакета.

### Authorization

The Notion API requires an access token and a Notion integration, [the Notion documentation](https://developers.notion.com/docs/getting-started#before-we-begin) explains how this works. It's important to grant access to the integration within your Notion account to enable the API access.

Add your Notion API token to your `.env` file:

```
NOTION_API_TOKEN="$YOUR_ACCESS_TOKEN"
```

## Usage

Head over to the [Documentation](https://5amco.de/docs) of this package.

### 🔥 Code Examples to jumpstart your Notion API Project

#### Basic Setup (+ example)
```php
use FiveamCode\LaravelNotionApi\Notion; 

# Access through Facade (token has to be set in .env)
\Notion::databases()->find($databaseId);

# Custom instantiation (necessary if you want to access more than one NotionApi integration)
$notion = new Notion($apiToken, $apiVersion); // version-default is 'v1'
$notion->databases()->find($databaseId);
```

#### Fetch Page Information
```php
// Returns a specific page
\Notion::pages()->find($yourPageId);
```

#### Search
```php
// Returns a collection pages and databases of your workspace (included in your integration-token)
\Notion::search($searchText)
        ->query()
        ->asCollection();
```

#### Query Database

```php
// Queries a specific database and returns a collection of pages (= database entries)
$sortings = new Collection();
$filters = new Collection();

$sortings
  ->add(Sorting::propertySort('Ordered', 'ascending'));
$sortings
  ->add(Sorting::timestampSort('created_time', 'ascending'));

$filters
  ->add(Filter::textFilter('title', ['contains' => 'new']));
// or
$filters
  ->add(Filter::rawFilter('Tags', ['multi_select' => ['contains' => 'great']]));
  
\Notion::database($yourDatabaseId)
      ->filterBy($filters) // filters are optional
      ->sortBy($sortings) // sorts are optional
      ->limit(5) // limit is optional
      ->query()
      ->asCollection();
```


### Testing

```bash
vendor/bin/phpunit tests
```

## Support

If you use this package in one of your projects or just want to support our development, consider becoming a [Patreon](https://www.patreon.com/bePatron?u=56662485)!

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@dianaweb.dev instead of using the issue tracker.

## Used By

- Julien Nahum created [notionforms.io](https://notionforms.io) with [laravel-notion-api](https://github.com/5am-code/laravel-notion-api), which allows you to easily create custom forms, based on your selected database within notion.
- [GitHub Notion Sync](https://githubnotionsync.com/), a service by [Beyond Code](https://beyondco.de) to sync the issues of multiple GitHub repositories into a Notion database
- [Notion Invoice](https://notioninvoice.com/), the first premium invoicing solution for freelancers and businesses that use Notion. Create beautiful PDF invoices from your Notion data.

Using this package in your project? Open a PR to add it in this section!

## Credits

- [Diana Scharf](https://github.com/mechelon)
- [Johannes Güntner](https://github.com/johguentner)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

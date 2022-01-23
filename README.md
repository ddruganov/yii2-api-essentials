# yii2-api-essentials

Bunch of small components to make one's development life eaiser

## Auth module

For the auth part of this library to work you need to add this to your app's params config:

```php
...
    'authentication' => [
        'masterPassword' => [
            'enable' => true,
            'value' => ''
        ],
        'tokens' => [
            'secret' => '',
            'access' => [
                'ttl' => 0 // seconds
            ],
            'refresh' => [
                'ttl' => 0 // seconds
            ]
        ]
    ]
...
```

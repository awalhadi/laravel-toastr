# Laravel Toastr

Easy Toastr notifications for Laravel 8+

## Installation

You can install the package via composer:

```bash
composer require your-vendor/laravel-toastr
```

## Usage

You can use the `toastr()` helper function or the `ttoastr()` function for typed notifications:

```php
// In your controller
public function store()
{
    // Your logic here

    toastr()->success('Post created successfully!');
    // or
    toastr('Post created successfully!', 'success');
    // or
    ttoastr('success', 'Post created successfully!');

    return redirect()->route('posts.index');
}
```

You can also chain methods for more control:

```php
toastr()->position('top-left')->success('Message');
```

Available types: `success`, `info`, `warning`, `error`

In your blade template, include the Toastr view:

```php
@include('toastr::toastr')
```

The required CSS and JS files will be automatically included when a notification is fired.

## Configuration

To publish the config file:

```bash
php artisan vendor:publish --provider="YourVendor\LaravelToastr\ToastrServiceProvider" --tag="config"
```

You can customize the default options in the published config file.

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
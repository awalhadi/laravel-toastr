# Laravel Toastr Package

Laravel Toastr is a simple and elegant notification package for Laravel applications. It integrates the popular [Toastr.js](https://github.com/CodeSeven/toastr "Toastr.js") library, allowing you to display stylish and customizable toast notifications in your Laravel project with minimal effort.

## Table of Contents

- Installation
- Configuration
- Usage
- Customization
- Contributing
- License

### Installation

1. #### Install the Package
   Run the following command to install the package:

```bash
composer require awalhadi/laravel-toastr
```

2. #### Publish Assets and Configuration (Optional)
   If you want to customize the default configuration, you can publish the assets and configuration file:

```bash
php artisan vendor:publish --provider="AwalHadi\LaravelToastr\ToastrServiceProvider"

```

### Configuration

After publishing, you can customize the Toastr options by editing the **config/toastr.php** file.

### Usage

#### In Controllers

Use the **Toastr** facade to add Toastr notifications in your controllers:

```php
use Toastr;

public function updateProfile(Request $request)
{
    // Update the user's profile...

    Toastr::showSuccess('Profile updated successfully!');

    return redirect()->route('profile');
}

```

#### In Views

Include the _Toastr_ assets and display the notifications by using the** @h_toastr** directive in your Blade views:

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Other head elements... -->
  </head>
  <body>
    <!-- Body elements... -->
    @h_toastr
  </body>
</html>
```

### Customization

You can customize the appearance and behavior of the Toastr notifications by editing the **config/toastr.php** file.

### Contributing

Contributions are welcome! Please read the contributing guide to learn how to contribute to this project.

### License

Laravel Toastr is open-sourced software licensed under the MIT license.

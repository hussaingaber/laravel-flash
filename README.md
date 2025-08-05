# Granada Pride Laravel Flash

A beautiful, feature-rich Laravel package for flash notifications with support for both Bootstrap and Tailwind CSS frameworks. Create elegant success, error, warning, and info messages with animations, icons, and customizable styling.

## Features

- 🎨 **Dual Framework Support**: Bootstrap 5+ and Tailwind CSS
- 🚀 **Easy Integration**: Simple Blade component and Facade
- 🎭 **Multiple Message Types**: Success, Error, Warning, Info, and Custom
- 💫 **Rich Animations**: Smooth slide-in effects and auto-dismiss
- 🔧 **Highly Configurable**: Extensive configuration options
- 📱 **Responsive Design**: Mobile-friendly notifications
- 🎯 **Overlay Support**: Modal-style important messages
- ⏱️ **Auto-dismiss Control**: Configurable timing or persistent messages
- 🎪 **Icon Support**: Beautiful icons for each message type
- 🧪 **Fully Tested**: Comprehensive test suite


## Requirements

- PHP 8.0+
- Laravel 9.0+
- Bootstrap 5+ or Tailwind CSS 3+ (depending on your choice)

## Installation

You can install the package via Composer:

```bash
composer require granada-pride/laravel-flash
```

### Publish Configuration (Optional)

Publish the configuration file to customize the package behavior:

```bash
php artisan vendor:publish --tag=flash-config
```

### Publish Views (Optional)

If you want to customize the view templates:

```bash
php artisan vendor:publish --tag=flash-views
```

## Configuration

### Environment Variables

Add these variables to your `.env` file:

```env
# Framework choice: bootstrap or tailwind
FLASH_FRAMEWORK=bootstrap

# Auto-dismiss duration in milliseconds (0 = no auto-dismiss)
FLASH_ANIMATION_DURATION=5000

# Enable/disable dismissible buttons
FLASH_DISMISSIBLE=true

# Show icons in messages
FLASH_SHOW_ICONS=true

# Default position
FLASH_POSITION=top-right
```

### Configuration File

The published configuration file (`config/flash-notifications.php`) provides extensive customization options:

```php
return [
    // CSS Framework: 'bootstrap' or 'tailwind'
    'framework' => env('FLASH_FRAMEWORK', 'bootstrap'),
    
    // Auto-dismiss duration in milliseconds
    'animation_duration' => env('FLASH_ANIMATION_DURATION', 5000),
    
    // Allow manual dismissal
    'dismissible' => env('FLASH_DISMISSIBLE', true),
    
    // Show icons
    'show_icons' => env('FLASH_SHOW_ICONS', true),
    
    // Position: top-right, top-left, top-center, bottom-right, bottom-left, bottom-center
    'position' => env('FLASH_POSITION', 'top-right'),
    
    // z-index for layering
    'z_index' => env('FLASH_Z_INDEX', 1050),
];
```

## Usage

### Include CSS Framework

Make sure you have Bootstrap or Tailwind CSS included in your project.

#### For Bootstrap:
```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
```

#### For Tailwind:
```html
<script src="https://cdn.tailwindcss.com"></script>
```

### Display Flash Messages

Add the component to your Blade layout:

```blade
<!DOCTYPE html>
<html>
<head>
    <!-- Your CSS frameworks -->
</head>
<body>
    <!-- Flash Messages Component -->
    <x-flash-messages />
    
    <!-- Your content -->
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
```

### Basic Usage

#### In Controllers

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GranadaPride\LaravelFlash\Facades\Flash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Your logic here...
        
        Flash::success('User created successfully!', 'Success');
        
        return redirect()->route('users.index');
    }
    
    public function update(Request $request, User $user)
    {
        try {
            // Update logic...
            
            Flash::success('User profile updated successfully!');
            
        } catch (\Exception $e) {
            Flash::error('Failed to update user: ' . $e->getMessage(), 'Error');
        }
        
        return redirect()->back();
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        
        Flash::warning('User account has been permanently deleted!', 'Account Deleted')
             ->important(); // Won't auto-dismiss
        
        return redirect()->route('users.index');
    }
}
```

#### In Routes

```php
use GranadaPride\LaravelFlash\Facades\Flash;

Route::get('/welcome', function () {
    Flash::info('Welcome to our application!', 'Welcome');
    return view('welcome');
});
```

#### In Middleware

```php
public function handle($request, Closure $next)
{
    $response = $next($request);
    
    if (auth()->check() && auth()->user()->hasUnreadNotifications()) {
        Flash::info('You have ' . auth()->user()->unreadNotifications()->count() . ' new notifications.');
    }
    
    return $response;
}
```

### Advanced Usage

#### Message Types

```php
// Basic message types
Flash::success('Operation completed successfully!');
Flash::error('Something went wrong!');
Flash::warning('Please be careful!');
Flash::info('Here is some information.');

// With custom titles
Flash::success('User created successfully!', 'Success');
Flash::error('Validation failed!', 'Error');
```

#### Important Messages (No Auto-dismiss)

```php
Flash::error('Critical system error!')
     ->important();
```

#### Custom Duration

```php
Flash::info('Custom timing message')
     ->duration(10000); // 10 seconds
```

#### Overlay/Modal Messages

```php
Flash::overlay(
    'This is a very important system announcement that requires your immediate attention.',
    'System Maintenance Notice',
    'warning'
);
```

#### Custom CSS Classes

```php
Flash::success('Styled message')
     ->addClass('custom-flash-class');
```

### Method Chaining

All methods support fluent chaining:

```php
Flash::warning('System maintenance scheduled')
     ->important()
     ->addClass('maintenance-notice');
```

### AJAX Usage

For AJAX requests, you can handle flash messages in JavaScript:

```php
// Controller
public function ajaxAction(Request $request)
{
    try {
        // Your logic...
        
        if ($request->expectsJson()) {
            Flash::success('AJAX operation completed!');
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard')
            ]);
        }
        
        Flash::success('Operation completed!');
        return redirect()->back();
        
    } catch (\Exception $e) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
        
        Flash::error('Operation failed!');
        return redirect()->back();
    }
}
```

```javascript
// JavaScript
$.post('/ajax-endpoint', data)
    .done(function(response) {
        if (response.redirect) {
            window.location.href = response.redirect;
        }
    })
    .fail(function(xhr) {
        // Handle error
    });
```

## Customization

### Custom Views

After publishing views, you can customize the templates:

- `resources/views/vendor/flash-notifications/bootstrap/flash.blade.php`
- `resources/views/vendor/flash-notifications/tailwind/flash.blade.php`

### Custom Message Types

Extend the Flash class with custom message types:

```php
// In your AppServiceProvider boot method
use GranadaPride\LaravelFlash\Facades\Flash;

Flash::macro('critical', function ($message, $title = null) {
    return $this->message($message, 'critical', $title);
});

// Usage
Flash::critical('Critical system alert!', 'Critical');
```

### Custom Positioning

You can position flash messages anywhere in your layout:

```blade
<!-- Fixed position -->
<div class="fixed top-4 right-4 z-50 max-w-sm">
    <x-flash-messages />
</div>

<!-- Centered -->
<div class="flex justify-center">
    <div class="w-full max-w-md">
        <x-flash-messages />
    </div>
</div>
```

### Custom Styling Examples

#### Bootstrap Custom Styles
```css
.flash-alert {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.flash-alert.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left: 4px solid #28a745;
}
```

#### Tailwind Custom Classes
```blade
<!-- In your custom view -->
<div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-4 rounded-lg shadow-lg">
    {{ $message['message'] }}
</div>
```

## API Reference

### Flash Class Methods

| Method | Parameters | Description |
|--------|------------|-------------|
| `success($message, $title = null)` | `string $message`, `string $title` | Create success message |
| `error($message, $title = null)` | `string $message`, `string $title` | Create error message |
| `warning($message, $title = null)` | `string $message`, `string $title` | Create warning message |
| `info($message, $title = null)` | `string $message`, `string $title` | Create info message |
| `message($message, $type, $title = null)` | `string $message`, `string $type`, `string $title` | Create custom message |
| `overlay($message, $title, $type)` | `string $message`, `string $title`, `string $type` | Create overlay message |
| `important()` | - | Mark message as important (no auto-dismiss) |
| `duration($milliseconds)` | `int $milliseconds` | Set custom auto-dismiss duration |
| `addClass($classes)` | `string $classes` | Add custom CSS classes |

### Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `framework` | `string` | `'bootstrap'` | CSS framework ('bootstrap' or 'tailwind') |
| `animation_duration` | `int` | `5000` | Auto-dismiss duration in milliseconds |
| `dismissible` | `bool` | `true` | Allow manual dismissal |
| `show_icons` | `bool` | `true` | Display icons in messages |
| `position` | `string` | `'top-right'` | Default position for messages |
| `z_index` | `int` | `1050` | z-index value for layering |


## Troubleshooting

### Common Issues

#### Flash messages not appearing
1. Ensure you've included the `<x-flash-messages />` component in your layout
2. Check that your CSS framework is properly loaded
3. Verify the configuration framework matches your CSS framework

#### Styling issues
1. Make sure Bootstrap/Tailwind CSS is loaded before the flash messages
2. Check for CSS conflicts in your custom styles
3. Verify the framework configuration is correct

#### Auto-dismiss not working
1. Ensure JavaScript is enabled
2. Check browser console for JavaScript errors
3. Verify the animation duration is greater than 0

### Debug Mode

Enable debug information by setting:

```php
// In config/flash-notifications.php
'debug' => env('FLASH_DEBUG', false),
```

## Security

If you discover any security-related issues, please email security@granadapride.com instead of using the issue tracker.

## Testing

Soon...

## Contribution

Contributions are welcome! If you’d like to contribute to this package, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Write your code and ensure it is well-documented.
4. Submit a pull request with a clear description of your changes.

## License

This package is open-source software licensed under the MIT License. Please see the `License` File for more information.

## Support

- 📧 Email: support@granadapride.com
- 🐛 Issues: [GitHub Issues](https://github.com/granada-pride/laravel-flash/issues)
- 💬 Discussions: [GitHub Discussions](https://github.com/granada-pride/laravel-flash/discussions)
- 📖 Documentation: [Full Documentation](https://docs.granadapride.com/laravel-flash)



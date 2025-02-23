# Socialite drivers for LINE

## Available drivers
- LINE Login `line-login`
  - https://developers.line.biz/en/docs/line-login/
### Unavailable
- LINE WORKS
  - https://developers.worksmobile.com/

## Configuration

### .env
LINE Login
```
LINE_LOGIN_CLIENT_ID=
LINE_LOGIN_CLIENT_SECRET=
LINE_LOGIN_REDIRECT=
```

## Usage(LINE Login)

### routes/web.php
```php
use App\Http\Controllers\SocialiteController;

Route::get('login', [SocialiteController::class, 'login']);
Route::get('callback', [SocialiteController::class, 'callback']);
```

### Controller

```php
<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function login()
    {
        return Socialite::driver('line-login')->redirect();
    }

    public function callback(Request $request)
    {
        if ($request->missing('code')) {
            dd($request);
        }

        /**
        * @var \Laravel\Socialite\Two\User
        */
        $user = Socialite::driver('line-login')->user();

        $loginUser = User::updateOrCreate([
            'line_id' => $user->id,
        ], [
            'name' => $user->nickname,
            'avatar' => $user->avatar,
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
        ]);

        auth()->login($loginUser, true);

        return redirect()->route('home');
    }
}
```

with optional parameters.

```php
    public function login()
    {
        return Socialite::driver('line-login')->with([
            'prompt'     => 'consent',
            'bot_prompt' => 'normal',
        ])->redirect();
    }
```

### Scopes

https://developers.line.biz/en/docs/line-login/integrate-line-login/#scopes

```php
    public function login()
    {
        return Socialite::driver('line-login')
                        ->setScopes(['profile', 'openid'])
                        ->redirect();
    }
```

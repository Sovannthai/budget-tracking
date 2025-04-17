<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ThemeController extends Controller
{
    public function updateTheme(Request $request)
    {
        $request->validate([
            'dark_mode' => 'required|boolean'
        ]);
        
        Config::set('app.dark_mode', $request->dark_mode);

        $envFile    = base_path('.env');
        $envContent = file_get_contents($envFile);
        $envContent = preg_replace(
            '/APP_DARK_MODE=.*/',
            'APP_DARK_MODE=' . ($request->dark_mode ? 'true' : 'false'),
            $envContent
        );
        file_put_contents($envFile, $envContent);

        return response()->json(['success' => true]);
    }
}

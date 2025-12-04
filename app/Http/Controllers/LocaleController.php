<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function setLocale($locale)
    {
        if (in_array($locale, ['en', 'id'])) {
            session(['locale' => $locale]);
            cookie()->queue('locale', $locale, 525600); // 1 year
        }

        return redirect()->back();
    }
}

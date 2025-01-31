<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->lang ?$request->lang : 'en';
        app()->setlocale($locale);              // يقوم هذا السطر بتعيين لغة التطبيق على قيمة $locale. تقوم الدالة المساعدة app() بإرجاع نسخة التطبيق، ويقوم الأسلوب setLocale بتعيين لغة التطبيق.
        return $next($request);
    }
}

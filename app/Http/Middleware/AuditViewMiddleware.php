<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Symfony\Component\HttpFoundation\Response;

class AuditViewMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // سجل فقط إذا كان المستخدم مسجل دخول وطلب صفحة (GET request)
        if (auth()->check() && $request->isMethod('GET')) {
            $routeName = $request->route() ? $request->route()->getName() : null;
            
            // تجاهل المسارات غير المهمة أو ملفات الـ Debug
            if (!$routeName || str_contains($routeName, 'debugbar')) {
                return $response;
            }

            $pages = [
                'properties.index' => 'قائمة العقارات المتاحة',
                'properties.sold'  => 'قائمة العقارات المباعة',
                'properties.show'  => 'عرض تفاصيل وحدة',
                'properties.create'=> 'صفحة إضافة وحدة جديدة',
                'properties.edit'  => 'صفحة تعديل وحدة',
                'users.index'      => 'إدارة الموظفين',
                'audit.index'      => 'سجل المراقبة',
            ];

            $actionDescription = $pages[$routeName] ?? 'زيارة صفحة: ' . $routeName;
            $target = $request->fullUrl();

            // لتجنب تسجيل الدخول المتكرر لنفس الصفحة في ثوانٍ بسيطة (اختياري)
            AuditLog::log(
                auth()->user()->name,
                'فتح صفحة',
                'تصفح',
                $actionDescription
            );
        }

        return $response;
    }
}

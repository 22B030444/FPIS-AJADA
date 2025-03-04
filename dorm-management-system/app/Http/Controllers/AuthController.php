<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Показать страницу входа
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Логин
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

//        if (Auth::attempt($credentials)) {
//            return redirect()->route('admin.users.create'); // После входа перенаправляем на регистрацию юзера
//        }
        if (\Auth::attempt($credentials)) {
            // Пользователь авторизован
            $user = \Auth::user();

            // Проверяем роль
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard'); // маршрут для админа
                case 'manager':
                    return redirect()->route('manager.dashboard'); // маршрут для менеджера
                case 'student':
                    return redirect()->route('student.dashboard'); // маршрут для студента
                default:
                    return redirect('/'); // или другая страница по умолчанию
            }
        }

        return back()->withErrors(['email' => 'Неверные данные'])->withInput();
    }

    // Выход
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

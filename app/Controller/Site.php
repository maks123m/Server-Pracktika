<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;

class Site
{
    public function hello(): string {
        return new View('site.hello');
    }

    public function login(Request $request): string {
        if ($request->method === 'GET') return new View('site.login');
        if (Auth::attempt($request->all())) app()->route->redirect('/hello');
        return new View('site.login', ['message' => 'Неверный логин или пароль']);
    }

    public function signup(Request $request): string {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/login');
        }
        return new View('site.signup');
    }

    public function logout(): void {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function users(): string
    {
        $users = \Model\User::all();
        return new View('site.users', ['users' => $users]);
    }
    public function userAdd(): string
    {
        $subdivisions = \Model\Subdivision::all();
        return new View('site.userAdd', ['subdivisions' => $subdivisions]);
    }

    public function userCreate(Request $request): void
    {
        if ($request->method === 'POST') {
            if (\Model\User::create($request->all())) {
                app()->route->redirect('/users');
            }
        }
    }

    public function userDelete(Request $request): void
    {
        \Model\User::destroy($request->get('id'));
        app()->route->redirect('/users');
    }

    public function subdivisions(): string
    {
        if (app()->auth->user()->role !== 'admin') {
            app()->route->redirect('/hello');
        }

        $subdivisions = \Model\Subdivision::all();
        return new View('site.subdivisions', ['subdivisions' => $subdivisions]);
    }

    public function subdivisionAdd(): string
    {
        if (app()->auth->user()->role !== 'admin') {
            app()->route->redirect('/hello');
        }
        return new View('site.subdivisionAdd');
    }

    public function subdivisionCreate(Request $request): void
    {
        if ($request->method === 'POST') {
            if (\Model\Subdivision::create($request->all())) {
                app()->route->redirect('/subdivisions');
            }
        }
    }
    public function subdivisionDelete(Request $request): void
    {
        
        if (app()->auth->user()->role !== 'admin') {
            app()->route->redirect('/hello');
        }

        $subdivision = \Model\Subdivision::find($request->get('id'));

        if ($subdivision) {
            $subdivision->delete();
        }

        app()->route->redirect('/subdivisions');
    }
}
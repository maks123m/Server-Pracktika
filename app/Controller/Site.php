<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Site
{
    public function hello(): string
    {
        $totalItems = \Model\Product::sum('quantity') ?? 0;

        $lowStockProducts = \Model\Product::whereRaw('quantity <= min_norm')->get();
        $lowStockCount = $lowStockProducts->count();
        
        $recentDeliveries = \Model\Delivery::orderBy('id', 'desc')->limit(5)->get();
        $recentWriteOffs = \Model\WriteOff::orderBy('id', 'desc')->limit(5)->get();
        $totalWriteOffs = \Model\WriteOff::count();
        $totalSuppliers = \Model\Supplier::count();

        return new View('site.hello', [
            'totalItems' => $totalItems,
            'lowStockCount' => $lowStockCount,
            'totalSuppliers' => $totalSuppliers,
            'ordersToRequest' => $lowStockProducts,
            'recentDeliveries' => $recentDeliveries,
            'monthlyWriteOffs' => $totalWriteOffs,
            'recentWriteOffs' => $recentWriteOffs,
        ]);
    }

    public function suppliers(): string
    {
        $suppliers = \Model\Supplier::all();
        return new View('site.suppliers', ['suppliers' => $suppliers]);
    }

    public function login(Request $request): string {
        if ($request->method === 'GET') return new View('site.login');
        if (Auth::attempt($request->all())) app()->route->redirect('/hello');
        return new View('site.login', ['message' => 'Неверный логин или пароль']);
    }

    public function signup(Request $request): string
    {
    if ($request->method === 'POST') {

        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'login' => ['required', 'unique:users,login'],
            'password' => ['required']
        ], [
            'required' => 'Поле :field пусто',
            'unique' => 'Поле :field должно быть уникально'
        ]);

        if($validator->fails()){
            return new View('site.signup',
                ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
        }

        if (User::create($request->all())) {
            app()->route->redirect('/login');
        }
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
        $subdivisions = \Model\Subdivision::all();
        return new View('site.subdivisions', ['subdivisions' => $subdivisions]);
    }

    public function subdivisionAdd(): string
    {
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
        $subdivision = \Model\Subdivision::find($request->get('id'));

        if ($subdivision) {
            $subdivision->delete();
        }

        app()->route->redirect('/subdivisions');
    }

    public function orderAdd(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();
            $product = \Model\Product::find($data['product_id']);
            
            if ($product) {
                \Model\Delivery::create([
                    'name' => $product->name,
                    'quantity' => $data['quantity'],
                    'price' => $product->price,
                    'supplier' => $data['supplier'],
                    'date' => date('Y-m-d')
                ]);
                $product->increment('quantity', $data['quantity']);
                app()->route->redirect('/hello');
            }
        }

        return new View('site.orderAdd', [
            'suppliers' => \Model\Supplier::all(),
            'products' => \Model\Product::all()
        ]);
    }

    public function writeOffAdd(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new \Src\Validator\Validator($request->all(), [
                'product_id' => ['required'],
                'quantity'   => ['required'],
                'employee'   => ['required'],
                'department' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'number'   => 'Поле :field должно быть числом',
            ]);

            if ($validator->fails()) {
                return new View('site.writeOffAdd', [
                    'products' => \Model\Product::all(),
                    'subdivisions' => \Model\Subdivision::all(),
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            $data = $request->all();
            $product = \Model\Product::find($data['product_id']);

            if ($product && $product->quantity >= $data['quantity']) {
                $product->decrement('quantity', $data['quantity']);
                \Model\WriteOff::create([
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'quantity'   => $data['quantity'],
                    'employee'   => $data['employee'],
                    'department' => $data['department'],
                    'date'       => date('Y-m-d')
                ]);
                app()->route->redirect('/hello');
            }
            return new View('site.writeOffAdd', [
                'products' => \Model\Product::all(),
                'subdivisions' => \Model\Subdivision::all(),
                'message' => 'Недостаточно товара на складе'
            ]);
        }

        return new View('site.writeOffAdd', [
            'products' => \Model\Product::all(),
            'subdivisions' => \Model\Subdivision::all()
        ]);
    }
}
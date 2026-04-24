<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Src\Validator\Validator;
use function Collect\collection;

class Site
{
    public function hello(): string
    {
        $totalItems = \Model\Product::sum('quantity') ?? 0;

        $lowStockProducts = \Model\Product::whereRaw('quantity <= min_norm')->get();
        $lowStockCount = $lowStockProducts->count();
        
        $recentDeliveries = collect(\Model\Delivery::orderBy('id', 'desc')->limit(5)->get()->toArray())
            ->map(function ($delivery) {
                $product = \Model\Product::where('name', $delivery['name'])->first();
                $delivery['unit'] = $product ? $product->unit : 'ед.';
                $delivery['formatted_price'] = number_format($delivery['price'], 2, '.', ' ') . ' ₽';
                $delivery['formatted_date'] = date('d.m.Y', strtotime($delivery['date']));
                return (object)$delivery;
            })->all();

        $recentWriteOffs = collect(\Model\WriteOff::orderBy('id', 'desc')->limit(5)->get()->toArray())
            ->map(function ($wo) {
                $product = \Model\Product::where('name', $wo['name'])->first();
                $wo['unit'] = $product ? $product->unit : '';
                $wo['formatted_date'] = date('d.m.Y', strtotime($wo['date']));
                return (object)$wo;
            })->all();
            
        $totalWriteOffs = \Model\WriteOff::count();
        $totalSuppliers = \Model\Supplier::count();

        return new View('site.hello', [
            'totalItems' => $totalItems,
            'lowStockCount' => $lowStockProducts->count(),
            'totalSuppliers' => \Model\Supplier::count(),
            'ordersToRequest' => $lowStockProducts,
            'recentDeliveries' => $recentDeliveries,
            'monthlyWriteOffs' => \Model\WriteOff::count(),
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
            $data = $request->all();

            $validator = new Validator($data, [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
                'image' => ['img_size', 'img_ext'],
            ], [
                'required' => 'Поле :field обязательно',
                'unique' => 'Логин уже занят',
            ]);

            if ($validator->fails()) {
                return new View('site.signup', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }
            unset($data['image']);

            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
                $file = $_FILES['image'];
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = time() . '.' . $extension;
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
                    $data['image'] = '/public/uploads/' . $fileName;
                }
            }

            if (User::create($data)) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    public function logout(): void {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function users(Request $request): string
    {
        $search = $request->get('search');

        if ($search) {
            $users = \Model\User::where('name', 'like', "%$search%")
                                ->orWhere('login', 'like', "%$search%")
                                ->get();
        } else {
            $users = \Model\User::all();
        }

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
            $data = $request->all();

            $validator = new Validator($data, [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
                'image' => ['img_size', 'img_ext'],
            ], [
                'required' => 'Поле :field обязательно',
                'unique' => 'Логин уже занят',
            ]);

            if ($validator->fails()) {
                die(json_encode($validator->errors(), JSON_UNESCAPED_UNICODE));
            }

            unset($data['image']);

            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
                $file = $_FILES['image'];
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = time() . '.' . $extension;

                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
                    $data['image'] = '/public/uploads/' . $fileName;
                }
            }
            if (\Model\User::create($data)) {
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
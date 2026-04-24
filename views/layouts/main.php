<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin: 0; padding: 0; background-color: #ffffff; font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; }
        .header { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 25px 50px; box-sizing: border-box; }
        .logo { font-size: 18px; color: #000; }
        .nav-menu { display: flex; gap: 40px; border: 2px solid #4F90FF; border-radius: 15px; padding: 15px 45px; align-items: center; }
        .nav-item { text-decoration: none; color: #000; font-size: 18px; display: flex; align-items: center; gap: 10px; }
        .nav-item.active { color: #4F90FF; font-weight: bold; }
        .main-content { width: 100%; display: flex; flex-direction: column; align-items: center; margin-top: 60px; }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #4F90FF;
        }
        .no-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #ebebeb;
            border: 1px solid #4F90FF;
            display: inline-block;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">Склад канцелярии</div>
            <nav class="nav-menu">
                <a href="<?= app()->route->getUrl('/hello') ?>" class="nav-item <?= $_SERVER['REQUEST_URI'] == '/hello' ? 'active' : '' ?>">Главная</a>
                
                <?php if (!\Src\Auth\Auth::check()): ?>
                    <a href="<?= app()->route->getUrl('/login') ?>" class="nav-item <?= $_SERVER['REQUEST_URI'] == '/login' ? 'active' : '' ?>">Авторизация</a>
                    <a href="<?= app()->route->getUrl('/signup') ?>" class="nav-item <?= $_SERVER['REQUEST_URI'] == '/signup' ? 'active' : ''?>">Регистрация</a>
                <?php else: ?>
                    <?php if (app()->auth->user()->role === 'admin'): ?>
                        <a href="<?= app()->route->getUrl('/users') ?>" class="nav-item <?= $_SERVER['REQUEST_URI'] == '/users' ? 'active' : '' ?>">Сотрудники</a>
                        <a href="<?= app()->route->getUrl('/subdivisions') ?>" class="nav-item <?= $_SERVER['REQUEST_URI'] == '/subdivisions' ? 'active' : '' ?>">Подразделения</a>
                    <?php endif; ?>

                    <div class="nav-item">
                        <span><?= app()->auth->user()->name ?? 'Профиль' ?></span>
                        <?php if (app()->auth->user()->image): ?>
                            <img src="<?= app()->auth->user()->image ?>" alt="avatar" class="user-avatar">
                        <?php else: ?>
                            <span class="no-avatar"></span>
                        <?php endif; ?>
                        
                    </div>
                    
                    <a href="<?= app()->route->getUrl('/logout') ?>" class="nav-item">Выход</a>
                    
                <?php endif; ?>
            </nav>
    </header>
    <main class="main-content">
        <?= $content ?? '' ?>
    </main>
</body>
</html>
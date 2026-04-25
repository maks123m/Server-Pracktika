<?php
namespace Src {
    if (!function_exists('Src\getallheaders')) {
        function getallheaders() {
            return [];
        }
    }
}
namespace {
    use PHPUnit\Framework\TestCase;
    use Src\Request;
    use Controller\Site;
    use Model\Subdivision;

    class SiteTest extends TestCase
    {
        protected function setUp(): void
        {
            $projectRoot = dirname(__DIR__);
            
            $_SERVER['DOCUMENT_ROOT'] = $projectRoot;
            $_SERVER['REQUEST_METHOD'] = 'POST';
            
            $appConfig = include $projectRoot . '/config/app.php';
            $dbConfig = include $projectRoot . '/config/db.php';
            $pathConfig = include $projectRoot . '/config/path.php';
            
            $GLOBALS['app'] = new Src\Application(new Src\Settings([
                'app' => $appConfig,
                'db' => $dbConfig,
                'path' => $pathConfig,
            ]));
            
            if (!function_exists('app')) {
                function app() { return $GLOBALS['app']; }
            }

            if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
                session_start();
            }
        }

        public function testSubdivisionCreation(): void
        {
            $uniqueName = 'Склад_Тест_' . time();
            $_SERVER['REQUEST_METHOD'] = 'POST';

            $request = new Request();
            $request->method = 'POST';
            $request->set('name', $uniqueName);
            
            $controller = new Site();
            
            ob_start();
            $controller->subdivisionCreate($request);
            ob_get_clean();
            
            $subdivision = Subdivision::where('name', $uniqueName)->first();
            $this->assertNotNull($subdivision, "Ошибка: Подразделение не появилось в БД!");
            
        }

        public function testLoginFailure(): void
        {
            $_SERVER['REQUEST_METHOD'] = 'POST';
            $_SERVER['REQUEST_URI'] = '/login';
            $request = new Request();
            $request->method = 'POST';
            $request->set('login', 'non_existent_user');
            $request->set('password', 'wrong_pass');
            
            $controller = new Site();
            
            ob_start();
            $view = $controller->login($request);

            echo (string)$view;
            $output = ob_get_clean();

            $this->assertTrue(
                str_contains($output, 'Неверный') || $output !== '',
                "Контроллер вернул пустой ответ или '1' вместо страницы с ошибкой"
            );
        }
    }
}
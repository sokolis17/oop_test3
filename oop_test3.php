<?php
/**
 * ООП В PHP - НЕДЕЛЯ 3: ИНТЕРФЕЙСЫ И ТРЕЙТЫ
 * 
 * Темы:
 * - Интерфейсы (interface)
 * - Множественная реализация интерфейсов
 * - Трейты (trait)
 * - Разрешение конфликтов трейтов
 * - Комбинирование интерфейсов и трейтов
 * 
 * Запуск: php week3_tasks.php
 */

echo "=== ООП В PHP - НЕДЕЛЯ 3 ===\n\n";

// ============================================
// ДЕНЬ 1-3: ИНТЕРФЕЙСЫ
// ============================================

echo "--- ЗАДАНИЕ 1: Базовые интерфейсы (15 баллов) ---\n";
/**
 * Создай интерфейс Drawable с методом:
 * - draw() - рисовать объект
 * 
 * Создай классы, реализующие Drawable:
 * 
 * Square (квадрат):
 * - private $size
 * - конструктор
 * - draw() - возвращает "Рисую квадрат размером {size}"
 * 
 * Circle (круг):
 * - private $radius
 * - конструктор
 * - draw() - возвращает "Рисую круг радиусом {radius}"
 */

// ТВОЙ КОД ЗДЕСЬ:
interface Drawable {
    public function draw();
}

class Square implements Drawable {
    private $size;

    public function __construct($size)
        {
            $this -> size = $size;
        }
    public function draw()
        {
            return "Рисую квадрат размером {$this->size}";
        }
}

class Circle implements Drawable {
    
    private $radius;

    public function __construct($radius)
        {
            $this -> radius = $radius;
        }
    public function draw()
        {
            return "Рисую круг радиусом {$this->radius}";
        }
}

// Проверка:
try {
    $square = new Square(10);
    $circle = new Circle(5);
    
    $tests = [
        'square_draw' => $square->draw() === "Рисую квадрат размером 10",
        'circle_draw' => $circle->draw() === "Рисую круг радиусом 5",
        'square_is_drawable' => $square instanceof Drawable,
        'circle_is_drawable' => $circle instanceof Drawable
    ];
    
    // Проверка что Drawable это интерфейс
    $reflection = new ReflectionClass('Drawable');
    $tests['is_interface'] = $reflection->isInterface();
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ Задание 1 выполнено!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}
echo "--- ЗАДАНИЕ 2: Множественная реализация (20 баллов) ---\n";
/**
 * Создай интерфейсы:
 * 
 * Movable:
 * - move() - двигаться
 * - stop() - остановиться
 * 
 * Soundable:
 * - makeSound() - издать звук
 * 
 * Создай класс Car, реализующий ОБА интерфейса:
 * - private $brand
 * - конструктор
 * - move() - возвращает "{brand} едет"
 * - stop() - возвращает "{brand} остановился"
 * - makeSound() - возвращает "{brand} сигналит: Бип-бип!"
 */

// ТВОЙ КОД ЗДЕСЬ:
interface Movable {
    public function move();
    public function stop();
}

interface Soundable {
    public function makeSound();
}

class Car implements Movable, Soundable {
    private $brand;

    public function __construct($brand)
        {
            $this->brand = $brand;
        }

    public function move(){
        return "{$this->brand} едет";
    }

    public function stop(){
        return "{$this->brand} остановился";
    }

    public function makeSound(){
        return "{$this->brand} сигналит: Бип-бип!";
    }
}

// Проверка:
try {
    $car = new Car("Toyota");
    
    $tests = [
        'move' => $car->move() === "Toyota едет",
        'stop' => $car->stop() === "Toyota остановился",
        'makeSound' => $car->makeSound() === "Toyota сигналит: Бип-бип!",
        'is_movable' => $car instanceof Movable,
        'is_soundable' => $car instanceof Soundable
    ];
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ Задание 2 выполнено!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}

echo "--- ЗАДАНИЕ 3: Интерфейсы с константами (15 баллов) ---\n";
/**
 * Создай интерфейс Logger с:
 * - константами:
 *   - LEVEL_INFO = "INFO"
 *   - LEVEL_WARNING = "WARNING"
 *   - LEVEL_ERROR = "ERROR"
 * - методом log($level, $message)
 * 
 * Создай класс FileLogger реализующий Logger:
 * - log($level, $message) - возвращает "[{level}] {message}"
 */

// ТВОЙ КОД ЗДЕСЬ:
interface Logger {
    public const LEVEL_INFO = "INFO";
    public const LEVEL_WARNING = "WARNING";
    public const LEVEL_ERROR = "ERROR";

    public function log($level,$message);
}

class FileLogger implements Logger {
    public function log($level, $message)
        {
            return "[{$level}] {$message}";
        }
}

// Проверка:
try {
    $logger = new FileLogger();
    
    $tests = [
        'info_constant' => Logger::LEVEL_INFO === "INFO",
        'warning_constant' => Logger::LEVEL_WARNING === "WARNING",
        'error_constant' => Logger::LEVEL_ERROR === "ERROR",
        'log_info' => $logger->log(Logger::LEVEL_INFO, "Всё ок") === "[INFO] Всё ок",
        'log_error' => $logger->log(Logger::LEVEL_ERROR, "Ошибка!") === "[ERROR] Ошибка!",
        'is_logger' => $logger instanceof Logger
    ];
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ Задание 3 выполнено!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}

// ============================================
// ДЕНЬ 4-5: ТРЕЙТЫ
// ============================================

echo "--- ЗАДАНИЕ 4: Базовые трейты (20 баллов) ---\n";
/**
 * Создай трейт Timestampable с:
 * - private $createdAt
 * - private $updatedAt
 * - методом setCreatedAt($time) - устанавливает время создания
 * - методом setUpdatedAt($time) - устанавливает время обновления
 * - методом getCreatedAt() - возвращает время создания
 * - методом getUpdatedAt() - возвращает время обновления
 * 
 * Создай класс Post, использующий трейт Timestampable:
 * - private $title
 * - конструктор ($title)
 * - getTitle()
 */

// ТВОЙ КОД ЗДЕСЬ:
trait Timestampable {
    private $createdAt;
    private $updatedAt;

    public function setCreatedAt($time){
        $this->createdAt = $time;
    }
    public function setUpdatedAt($time){
        $this->updatedAt = $time;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }
    public function getUpdatedAt(){
        return $this->updatedAt;
    }
    
}


class Post {
    use Timestampable;
    private $title;

    public function __construct($title)
        {
            $this->title=$title;
        }
    public function getTitle(){
        return $this->title;
    }
}

// Проверка:
try {
    $post = new Post("Заголовок поста");
    $post->setCreatedAt("2024-01-01 10:00:00");
    $post->setUpdatedAt("2024-01-02 15:30:00");
    
    $tests = [
        'title' => $post->getTitle() === "Заголовок поста",
        'created_at' => $post->getCreatedAt() === "2024-01-01 10:00:00",
        'updated_at' => $post->getUpdatedAt() === "2024-01-02 15:30:00"
    ];
    
    // Проверка что Timestampable это трейт
    $reflection = new ReflectionClass('Timestampable');
    $tests['is_trait'] = $reflection->isTrait();
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ Задание 4 выполнено!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}

echo "--- ЗАДАНИЕ 5: Множественные трейты (20 баллов) ---\n";
/**
 * Создай трейты:
 * 
 * Loggable:
 * - метод log($message) - возвращает "[LOG] {message}"
 * 
 * Validatable:
 * - метод validate() - возвращает true
 * 
 * Создай класс User, использующий ОБА трейта:
 * - private $email
 * - конструктор ($email)
 * - getEmail()
 */

// ТВОЙ КОД ЗДЕСЬ:
trait Loggable {
    public function log($message){
    return "[LOG] {$message}";
    }
}

trait Validatable {
    public function validate(){
        return true;
    }
}

class User {
    use Loggable, Validatable;
    
    private $email;
    public function __construct($email)
        {
            $this->email = $email;
        }
    public function getEmail(){
        return $this->email;
    }    
}

// Проверка:
try {
    $user = new User("user@test.com");
    
    $tests = [
        'email' => $user->getEmail() === "user@test.com",
        'log' => $user->log("Пользователь создан") === "[LOG] Пользователь создан",
        'validate' => $user->validate() === true
    ];
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ Задание 5 выполнено!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}

echo "--- ЗАДАНИЕ 6: Разрешение конфликтов трейтов (25 баллов) ---\n";
/**
 * Создай два трейта с одинаковым методом:
 * 
 * EmailFormatter:
 * - метод format($text) - возвращает "Email: {text}"
 * 
 * SmsFormatter:
 * - метод format($text) - возвращает "SMS: {text}"
 * 
 * Создай класс Message, использующий оба трейта:
 * - Разреши конфликт: используй format из EmailFormatter как formatEmail
 * - И format из SmsFormatter как formatSms
 * - private $content
 * - конструктор ($content)
 * - getContent()
 */

// ТВОЙ КОД ЗДЕСЬ:
trait EmailFormatter {
    // Твой код
}

trait SmsFormatter {
    // Твой код
}

class Message {
    use EmailFormatter, SmsFormatter {
        // Здесь разреши конфликт
    }
    // Твой код
}

// Проверка:
try {
    $message = new Message("Привет!");
    
    $tests = [
        'content' => $message->getContent() === "Привет!",
        'email_format' => $message->formatEmail("Тест") === "Email: Тест",
        'sms_format' => $message->formatSms("Тест") === "SMS: Тест"
    ];
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ Задание 6 выполнено!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}

// ============================================
// ДЕНЬ 6-7: КОМБИНИРОВАНИЕ КОНЦЕПЦИЙ
// ============================================

echo "--- ЗАДАНИЕ 7: Интерфейсы + Трейты (25 баллов) ---\n";
/**
 * Создай интерфейс Serializable с методами:
 * - toArray() - преобразовать в массив
 * - toJson() - преобразовать в JSON
 * 
 * Создай трейт JsonSerializable с методом:
 * - toJson() - возвращает json_encode($this->toArray())
 * 
 * Создай класс Product, реализующий Serializable и использующий JsonSerializable:
 * - private $name
 * - private $price
 * - конструктор ($name, $price)
 * - toArray() - возвращает ["name" => $name, "price" => $price]
 * - toJson() берётся из трейта
 */

// ТВОЙ КОД ЗДЕСЬ:
interface Serializable {
    // Твой код
}

trait JsonSerializable {
    // Твой код
}

class Product implements Serializable {
    use JsonSerializable;
    // Твой код
}

// Проверка:
try {
    $product = new Product("Ноутбук", 50000);
    
    $array = $product->toArray();
    $json = $product->toJson();
    
    $tests = [
        'array_name' => $array['name'] === "Ноутбук",
        'array_price' => $array['price'] === 50000,
        'json_valid' => json_decode($json, true) === $array,
        'is_serializable' => $product instanceof Serializable
    ];
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ Задание 7 выполнено!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}

// ============================================
// ИТОГОВОЕ ЗАДАНИЕ НЕДЕЛИ 3
// ============================================

echo "--- ИТОГОВОЕ ЗАДАНИЕ: CMS система (40 баллов) ---\n";
/**
 * Создай компоненты для CMS (системы управления контентом):
 * 
 * Интерфейс Publishable:
 * - publish() - опубликовать
 * - unpublish() - снять с публикации
 * - isPublished() - проверить опубликован ли
 * 
 * Трейт Timestampable (можешь использовать из задания 4):
 * - private $createdAt, $updatedAt
 * - setCreatedAt(), setUpdatedAt()
 * - getCreatedAt(), getUpdatedAt()
 * 
 * Трейт Sluggable:
 * - private $slug
 * - setSlug($slug)
 * - getSlug()
 * - generateSlug($text) - заменяет пробелы на дефисы и переводит в нижний регистр
 * 
 * Абстрактный класс Content реализует Publishable, использует Timestampable и Sluggable:
 * - protected $title
 * - protected $isPublished = false
 * - конструктор ($title)
 * - publish() - устанавливает isPublished = true
 * - unpublish() - устанавливает isPublished = false
 * - isPublished() - возвращает isPublished
 * - getTitle()
 * - абстрактный метод getType() - тип контента
 * 
 * Класс Article наследует Content:
 * - private $body (текст статьи)
 * - конструктор ($title, $body)
 * - getType() - возвращает "article"
 * - getBody()
 * 
 * Класс Page наследует Content:
 * - private $content (содержимое страницы)
 * - конструктор ($title, $content)
 * - getType() - возвращает "page"
 * - getContent()
 * 
 * Функция publishContent($items) - принимает массив Content объектов,
 * публикует все и возвращает массив их заголовков
 */

// ТВОЙ КОД ЗДЕСЬ:
interface Publishable {
    // Твой код
}

trait Timestampable {
    // Можешь скопировать из задания 4 или написать заново
}

trait Sluggable {
    // Твой код
}

abstract class Content implements Publishable {
    use Timestampable, Sluggable;
    // Твой код
}

class Article extends Content {
    // Твой код
}

class Page extends Content {
    // Твой код
}

function publishContent($items) {
    // Твой код
}

// Проверка:
try {
    $article = new Article("Новая статья", "Текст статьи");
    $article->setCreatedAt("2024-01-01");
    $article->setSlug($article->generateSlug("Новая статья"));
    
    $page = new Page("О нас", "Информация о компании");
    $page->setCreatedAt("2024-01-02");
    
    $tests = [
        'article_title' => $article->getTitle() === "Новая статья",
        'article_body' => $article->getBody() === "Текст статьи",
        'article_type' => $article->getType() === "article",
        'article_not_published' => $article->isPublished() === false,
        
        'page_title' => $page->getTitle() === "О нас",
        'page_content' => $page->getContent() === "Информация о компании",
        'page_type' => $page->getType() === "page",
        
        'slug_generated' => $article->getSlug() === "новая-статья",
        'created_at' => $article->getCreatedAt() === "2024-01-01"
    ];
    
    $article->publish();
    $tests['article_published'] = $article->isPublished() === true;
    
    $article->unpublish();
    $tests['article_unpublished'] = $article->isPublished() === false;
    
    $titles = publishContent([$article, $page]);
    $tests['publish_function'] => $titles === ["Новая статья", "О нас"];
    $tests['all_published'] = $article->isPublished() && $page->isPublished();
    
    $tests['article_is_publishable'] = $article instanceof Publishable;
    $tests['article_is_content'] = $article instanceof Content;
    
    if (array_sum($tests) === count($tests)) {
        echo "✓ ИТОГОВОЕ ЗАДАНИЕ выполнено! Превосходная работа!\n\n";
    } else {
        echo "✗ Не все тесты пройдены:\n";
        foreach ($tests as $test => $result) {
            echo ($result ? "✓" : "✗") . " $test\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Ошибка: " . $e->getMessage() . "\n\n";
}

echo "=== ИТОГИ НЕДЕЛИ 3 ===\n";
echo "Если все задания выполнены - поздравляю! Ты освоил:\n";
echo "✓ Интерфейсы (interface)\n";
echo "✓ Множественную реализацию интерфейсов\n";
echo "✓ Трейты (trait)\n";
echo "✓ Использование множественных трейтов\n";
echo "✓ Разрешение конфликтов трейтов\n";
echo "✓ Комбинирование интерфейсов и трейтов\n\n";
echo "Готов к Неделе 4: Продвинутые темы ООП!\n";

/*
 * ============================================
 * ПОДСКАЗКИ (не смотри пока не попробуешь сам!)
 * ============================================
 * 
 * Задание 1:
 * - interface Drawable { public function draw(); }
 * - class Square implements Drawable { public function draw() {...} }
 * 
 * Задание 2:
 * - class Car implements Movable, Soundable { ... }
 * - Реализуй все методы из обоих интерфейсов
 * 
 * Задание 3:
 * - interface Logger { const LEVEL_INFO = "INFO"; ... }
 * - Доступ к константам: Logger::LEVEL_INFO
 * 
 * Задание 4:
 * - trait Timestampable { private $createdAt; ... }
 * - class Post { use Timestampable; ... }
 * 
 * Задание 5:
 * - class User { use Loggable, Validatable; ... }
 * - Просто перечисли трейты через запятую
 * 
 * Задание 6:
 * - use EmailFormatter, SmsFormatter {
 *     EmailFormatter::format as formatEmail;
 *     SmsFormatter::format as formatSms;
 *   }
 * 
 * Задание 7:
 * - Трейт может использовать метод класса (toArray)
 * - public function toJson() { return json_encode($this->toArray()); }
 * 
 * Итоговое задание:
 * - abstract class Content implements Publishable { use Timestampable, Sluggable; ... }
 * - В generateSlug: return strtolower(str_replace(" ", "-", $text));
 * - publishContent: цикл foreach, вызывай publish() для каждого
 */
?>
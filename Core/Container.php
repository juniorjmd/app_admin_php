<?php
namespace Core;
use App\Repositories\UserRepository ;
use App\Services\sessionService;
use Core\SessionManager;
use Core\DataBase;

/**
 * Description of Container
 *
 * @author JosédeJesúsDomínguez
 */
class Container {
 
    private static $instances = [];

    public static function get($key)
    {
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = self::createInstance($key);
        }
        return self::$instances[$key];
    }

    private static function createInstance($key)
    {
        switch ($key) {
            case 'db':
                return DataBase::getInstance();

            case 'userRepository':
                return new UserRepository(self::get('db'));

            case 'sessionService':
                return new sessionService(self::get('userRepository'));

            case 'sessionManager':
                return new SessionManager(self::get('sessionService'));

            default:
                throw new \Exception("No se puede crear una instancia para la clave: $key");
        }
    }
}

<?php

class Root
{
    public static function connect(string $url)
    {
        $url = htmlspecialchars($url);
        $url = trim($url, '/');
        $parts = explode('/', $url);
        $className = ucfirst($parts[0]);
        $params = array_slice($parts, 2);
        if (class_exists($className)) {
            if (count($parts) == 1) {
                $reflect = new ReflectionMethod($className, 'index');
                $reflect->invoke(new $className());
            } else if (count($parts) == 2) {
                $methodName = $parts[1];

                if (method_exists($className, $methodName)) {
                    $reflect = new ReflectionMethod($className, $methodName);
                    $reflect->invoke(new $className());
                } else {
                    echo "Method" . $methodName . " not found";
                }
            } else {
                // with parameters
                $methodName = $parts[1];

                if (method_exists($className, $methodName)) {
                    $reflect = new ReflectionMethod($className, $methodName);
                    $reflect->invokeArgs(new $className(), $params);
                } else {
                    echo "Method" . $methodName . " not found";
                }
            }
        } else {
            echo "Class" . $className . " not found";
        }
    }
}

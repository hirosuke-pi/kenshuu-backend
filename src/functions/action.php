<?php

class ActionPage {
    private array $actionMethods;

    function __construct(bool $isCheckCsrfToken = true) {
        session_start();
        $this->actionMethods = [];

        if ($isCheckCsrfToken) {
            $this->checkCsrfToken();
        }
    }

    private function checkCsrfToken () {
        if (!isset($_SESSION[CSRF_NAME]) || !isset($_REQUEST[CSRF_NAME])) {
            throw new Exception('CSRF token is not set');
        }
        if ($_SESSION[CSRF_NAME] !== $_REQUEST[CSRF_NAME]) {
            throw new Exception('CSRF token is invalid');
        }
        unset($_SESSION[CSRF_NAME]);
        unset($_REQUEST[CSRF_NAME]);
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($_REQUEST[METHOD_NAME]) && in_array(strtoupper($_REQUEST[METHOD_NAME]), ['PUT', 'DELETE'])) {
            $method = strtoupper($_REQUEST[METHOD_NAME]);
        }

        if (!isset($this->actionMethods[$method])) {
            throw new Exception('Invalid method: ' . $method);
        }
        
        $actionMethod = $this->actionMethods[$method];
        $requireParams = $actionMethod->getRequireParams();
        checkKeyTypes($_REQUEST, $requireParams);

        $response = $actionMethod->action($_REQUEST);

        $_SESSION['action_response'] = [
            'data' => $response->getData(),
            'isError' => $response->getError(),
        ];

        header('Location: ' . $response->getLocation());
    }

    public function get(Closure $getAction, array $requireParams = []) {
        $this->actionMethods['GET'] = new ActionMethod('GET', $getAction, $requireParams);
    }

    public function post(Closure $postAction, array $requireParams = []) {
        $this->actionMethods['POST'] = new ActionMethod('POST', $postAction, $requireParams);
    }

    public function delete(Closure $deleteAction, array $requireParams = []) {
        $this->actionMethods['DELETE'] = new ActionMethod('DELETE', $deleteAction, $requireParams);
    }

    public function put(Closure $patchAction, array $requireParams = []) {
        $this->actionMethods['PUT'] = new ActionMethod('PUT', $patchAction, $requireParams);
    }
}

class ActionMethod {
    private string $method;
    private Closure $action;
    private array $requireParams;

    function __construct(string $method, Closure $action, array $requireParams) {
        $this->method = $method;
        $this->action = $action;
        $this->requireParams = $requireParams;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getRequireParams(): array {
        return $this->requireParams;
    }

    public function action(array $params = []): ActionResponse {
        return ($this->action)($params);
    }
}

class ActionResponse {
    private string $location;
    private bool $isError;
    private array $data;

    function __construct(string $location, array $data = [], bool $isError = false) {
        $this->location = $location;
        $this->data = $data;
        $this->isError = $isError;
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function getData(): array {
        return $this->data;
    }

    public function getError(): bool {
        return $this->isError;
    }
}

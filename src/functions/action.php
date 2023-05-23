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
        if (!isset($_SESSION['csrf_token']) || !isset($_REQUEST['csrf_token'])) {
            throw new Exception('CSRF token is not set');
        }
        if ($_SESSION['csrf_token'] !== $_REQUEST['csrf_token']) {
            throw new Exception('CSRF token is invalid');
        }
        unset($_SESSION['csrf_token']);
        unset($_REQUEST['csrf_token']);
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->actionMethods[$method])) {
            throw new Exception('Invalid method: ' . $method);
        }
        
        $actionMethod = $this->actionMethods[$method];
        $response = $actionMethod->action();

        $_SESSION['action_response'] = [
            'data' => $response->getData(),
            'isError' => $response->getError(),
        ];

        header('Location: ' . $response->getLocation());
    }

    public function get(Closure $getAction) {
        $this->actionMethods['GET'] = new ActionMethod('GET', $getAction);
    }

    public function post(Closure $postAction) {
        $this->actionMethods['POST'] = new ActionMethod('POST', $postAction);
    }

    public function delete(Closure $deleteAction) {
        $this->actionMethods['DELETE'] = new ActionMethod('DELETE', $deleteAction);
    }

    public function put(Closure $patchAction) {
        $this->actionMethods['PUT'] = new ActionMethod('PUT', $patchAction);
    }
}

class ActionMethod {
    private string $method;
    private Closure $action;

    function __construct(string $method, Closure $action) {
        $this->method = $method;
        $this->action = $action;
    }

    public function getMethod(): string {
        return $this->method;
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

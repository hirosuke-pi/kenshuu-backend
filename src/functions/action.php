<?php

class Action {
    private array $actionMethods;

    function __construct() {
        session_start();
        $this->actionMethods = [];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->actionMethods[$method])) {
            throw new Exception('Invalid method: ' . $method);
        }
        
        $actionMethod = $this->actionMethods[$method];
        $response = $actionMethod->action($_REQUEST);

        $_SESSION['action_response'] = [
            'data' => $response->getData(),
            'status' => $response->getStatus(),
        ];

        header('Location: ' . $actionMethod->getUrl());
    }

    public function get(string $jumpUrl, Closure $getAction) {
        $this->actionMethods['GET'] = new ActionMethod('GET', $jumpUrl, $getAction);
    }

    public function post(string $jumpUrl, Closure $postAction) {
        $this->actionMethods['POST'] = new ActionMethod('POST', $jumpUrl, $postAction);
    }

    public function delete(string $jumpUrl, Closure $deleteAction) {
        $this->actionMethods['DELETE'] = new ActionMethod('DELETE', $jumpUrl, $deleteAction);
    }

    public function patch(string $jumpUrl, Closure $patchAction) {
        $this->actionMethods['PATCH'] = new ActionMethod('PATCH', $jumpUrl, $patchAction);
    }
}

class ActionMethod {
    private string $method;
    private string $url;
    private Closure $action;

    function __construct(string $method, string $url, Closure $action) {
        $this->method = $method;
        $this->url = $url;
        $this->action = $action;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function action(array $params = []): ActionResponse {
        return ($this->action)($params);
    }
}

enum ActionResponseStatus {
    case Success;
    case Error;
}

class ActionResponse {
    private ActionResponseStatus $status;
    private array $data;

    function __construct(ActionResponseStatus $status, array $data = []) {
        $this->status = $status;
        $this->data = $data;
    }

    public function getStatus(): ActionResponseStatus {
        return $this->status;
    }

    public function getData(): array {
        return $this->data;
    }
}

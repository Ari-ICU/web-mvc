<?php
namespace Lib;

class Request {
    private $method;
    private $data;
    private $query;
    private $headers;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = $_GET;
        $this->headers = getallheaders();
        $this->data = $this->parseInput();
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function isMethod(string $method): bool {
        return strtoupper($method) === $this->method;
    }

    public function all(): array {
        return array_merge($this->query, $this->data);
    }

    public function input(string $key, $default = null) {
        return $this->data[$key] ?? $this->query[$key] ?? $default;
    }

    public function query(string $key = null, $default = null) {
        if ($key === null) {
            return $this->query;
        }
        return $this->query[$key] ?? $default;
    }

    public function header(string $key, $default = null) {
        $key = ucwords(strtolower(str_replace('_', '-', $key)), '-');
        return $this->headers[$key] ?? $default;
    }

    private function parseInput(): array {
        $contentType = $this->header('Content-Type', '');
        if (strpos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');
            return json_decode($input, true) ?? [];
        }
        if (strpos($contentType, 'multipart/form-data') !== false || 
            strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
            return $_POST;
        }
        $input = file_get_contents('php://input');
        return $input ? (array) json_decode($input, true) : $_POST;
    }

    public function validate(array $fields): array {
        $validated = [];
        $missing = [];

        foreach ($fields as $field) {
            $value = $this->input($field);
            if ($value === null) {
                $missing[] = $field;
            } else {
                $validated[$field] = $value;
            }
        }

        if (!empty($missing)) {
            throw new \Exception('Missing required fields: ' . implode(', ', $missing));
        }

        return $validated;
    }
}
?>
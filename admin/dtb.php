<?php
include_once "config.php";

if (!class_exists('Database')) {
    class Database {
        public $host = DB_HOST;
        public $user = DB_USER;
        public $pass = DB_PASS;
        public $dbname = DB_NAME;

        public $link;
        public $error;

        public function __construct() {
            $this->connectDB();
        }

        private function connectDB() {
            $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            if (!$this->link) {
                $this->error = "Connection fail: " . $this->link->connect_error;
                return false;
            }
        }

        private function getParamTypes($params) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param) || is_double($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
            return $types;
        }

        public function select($query, $params = []) {
            $stmt = $this->link->prepare($query);
            if (!$stmt) {
                $this->error = "Prepare failed: " . $this->link->error;
                return false;
            }

            if (!empty($params)) {
                $types = $this->getParamTypes($params);
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            return $result->num_rows > 0 ? $result : false;
        }

        public function insert($query, $params = []) {
            $stmt = $this->link->prepare($query);
            if (!$stmt) {
                $this->error = "Prepare failed: " . $this->link->error;
                return false;
            }

            if (!empty($params)) {
                $types = $this->getParamTypes($params);
                $stmt->bind_param($types, ...$params);
            }

            $result = $stmt->execute();
            $insert_id = $stmt->insert_id;
            $stmt->close();

            return $result ? $insert_id : false;
        }

        public function update($query, $params = []) {
            $stmt = $this->link->prepare($query);
            if (!$stmt) {
                $this->error = "Prepare failed: " . $this->link->error;
                return false;
            }

            if (!empty($params)) {
                $types = $this->getParamTypes($params);
                $stmt->bind_param($types, ...$params);
            }

            $result = $stmt->execute();
            $affected_rows = $stmt->affected_rows;
            $stmt->close();

            return $result ? $affected_rows : false;
        }

        public function delete($query, $params = []) {
            return $this->update($query, $params);
        }
    }
}
?>
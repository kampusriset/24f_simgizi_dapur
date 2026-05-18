<?php
    class mitra {
        private $conn;
        private $table = "mitra";

        public function __construct($db) {
            $this->conn = $db;
        }

        public function getAll() {
            $query = "SELECT id_mitra, nama_mitra FROM " . $this->table . " ORDER BY nama_mitra ASC";

            // Ikat Parameter
            $stmt = $this->conn->prepare($query);
            // Eksekusi Query
            $stmt->execute();

            return $stmt->get_result();
        }
    }
?>
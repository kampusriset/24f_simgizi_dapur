<?php
    class mitra {
        private $koneksi;
        private $table = "mitra";

        public function __construct($db) {
            $this->koneksi = $db;
        }

        public function getAll() {
            $query = "SELECT id_mitra, nama_mitra FROM " . $this->table . " ORDER BY nama_mitra ASC";

            return mysqli_query($this->koneksi, $query);
        }
    }   
?>
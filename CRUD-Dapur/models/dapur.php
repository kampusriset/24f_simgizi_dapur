<?php
    class dapur {
        private $conn;
        private $table = "dapur";

        public function __construct($db) {
            $this->conn = $db;
        }

        // Untuk mengambil semua data dapur
        public function getAll() {
            $query = "SELECT " . $this->table . ".*, mitra.nama_mitra FROM " . $this->table . 
                    " LEFT JOIN mitra ON " . $this->table . 
                        ".id_mitra = mitra.id_mitra WHERE " . $this->table . 
                    ".id_dapur = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            return $stmt->get_result();
        }
        // Untuk mengambil satu data dapur dan data mitra | ? untuk placeholder
        public function getById($id) {
            $query = "SELECT " . $this->table . ".*, mitra.nama_mitra FROM " . $this->table . 
                    " LEFT JOIN mitra ON " . $this->table . 
                        ".id_mitra = mitra.id_mitra WHERE " . $this->table . 
                    ".id_dapur = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $res = $stmt->get_result();
            return $res->fetch_assoc();
            }

        // FUNGSI UPDATE
        public function update($id_dapur, $nama_dapur, $alamat, $penanggung_jawab, $kontak, $id_mitra) {
            $query = "UPDATE " . $this->table ."
                        SET nama_dapur = ?, 
                        alamat = ?, 
                        penanggung_jawab = ?,
                        kontak = ?,
                        id_mitra = ?
                        WHERE id_dapur = ?";

            $stmt = $this->conn->prepare($query);

            // Ikat Parameter
            $stmt->bind_param("sssiii", $nama_dapur, $alamat, $penanggung_jawab, $kontak, $id_mitra, $id_dapur);
            // Eksekusi Query
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        // FUNGSI DELETE
        public function delete($id) {
            $query = "DELETE FROM " . $this->table . " WHERE id_dapur =?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
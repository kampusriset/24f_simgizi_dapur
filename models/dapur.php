<?php
    class dapur {
        private $koneksi;
        private $table = "dapur";

        public function __construct($db) {
            $this->koneksi = $db;
        }

        // Untuk mengambil semua data dapur
        public function getAll() {
            $query = "SELECT dapur.*, mitra.nama_mitra
                    FROM dapur
                    LEFT JOIN mitra ON dapur.id_mitra = mitra.id_mitra
                    ORDER BY dapur.id_dapur DESC";

            return mysqli_query($this->koneksi, $query);
        }

        public function getById($id) {
            $query = "SELECT dapur.*, mitra.nama_mitra
                    FROM dapur
                    LEFT JOIN mitra ON dapur.id_mitra = mitra.id_mitra
                    WHERE dapur.id_dapur = '$id'";

            $res = mysqli_query($this->koneksi, $query);
            return mysqli_fetch_assoc($res);
        }

        // FUNGSI CREATE
        public function tambahDapur($data){
            $nama_dapur = $data['nama_dapur'];
            $alamat = $data['alamat'];
            $penanggung_jawab = $data['penanggung_jawab'];
            $kontak = $data['kontak'];
            $id_mitra = $data['id_mitra'];

            mysqli_query($this->koneksi, "
                INSERT INTO dapur
                (nama_dapur, alamat, penanggung_jawab, kontak, id_mitra)
                VALUES
                ('$nama_dapur', '$alamat', '$penanggung_jawab', '$kontak', '$id_mitra')
            ");
        }

        // FUNGSI READ
        public function tampilDapur (){
            return mysqli_query($this->koneksi, "
            SELECT dapur.*, mitra.nama_mitra
            FROM dapur            
            LEFT JOIN MITRA
            ON dapur.id_mitra = mitra.id_mitra
            ");
        }

        // FUNGSI UPDATE
        public function update($id_dapur, $nama_dapur, $alamat, $penanggung_jawab, $kontak, $id_mitra) {
            $query = "UPDATE " . $this->table ."
                        SET nama_dapur = '$nama_dapur', 
                        alamat = '$alamat, 
                        penanggung_jawab = '$penanggung_jawab',
                        kontak = '$kontak',
                        id_mitra = '$id_mitra'
                        WHERE id_dapur = '$id_dapur'";

            return mysqli_query($this->koneksi, $query);
        }

        // FUNGSI DELETE
        public function delete($id) {
            $query = "DELETE FROM " . $this->table . " WHERE id_dapur = '$id'";

            return mysqli_query($this->koneksi, $query);
        }
    }
?>
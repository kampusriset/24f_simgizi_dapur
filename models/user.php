<?php
    class user {
        private $koneksi;

        public function __construct($db) {
            $this->koneksi=$db;
        }

        // FUNGSI REGISTER
        public function register($nama, $username, $password, $role) {
            $cek = $this->koneksi->query (
                "SELECT id_user FROM users 
                WHERE username = '$username'"
            );

            if ($cek->num_rows > 0) {
                return false;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);

            return $this->koneksi->query(
                "INSERT INTO users(nama, username, password, role)
                VALUES ('$nama', '$username', '$password', '$role')"
            );
        }

        // FUNGSI LOGIN
        public function login($username, $password) {
            $res = $this->koneksi->query (
                "SELECT * FROM users
                WHERE username = '$username'"
            );

            if ($res->num_rows > 0) {
                $user = $res->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    return $user;
                }
            }
            return false;
        }

        public function getAll() {
            $query = "SELECT nama, username, role, created_at FROM users ORDER BY created_at DESC";
            return $this->koneksi->query($query);
        }

        public function cekUsername($username) {
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = $this->koneksi->query($query);
            return $result->num_rows > 0;
        }

        public function resetPass ($username, $newPass) {
            $password_hash = password_hash($newPass, PASSWORD_BCRYPT);

            $query = "UPDATE users SET password = '$password_hash' WHERE username = '$username'";
            return $this->koneksi->query($query);
        }
    }
?>
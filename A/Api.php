<?php
require_once 'Db.php';

class Api {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    // Get all students
    public function getStudents() {
        $stmt = $this->db->prepare("SELECT * FROM horizonstudents");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single student by index_no
    public function getStudent($index_no) {
        $stmt = $this->db->prepare("SELECT * FROM horizonstudents WHERE index_no = ?");
        $stmt->execute([$index_no]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new student
    public function createStudent($data) {
        $stmt = $this->db->prepare("INSERT INTO horizonstudents (first_name, last_name, city, district, province, email_address, mobile_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['city'],
            $data['district'],
            $data['province'],
            $data['email_address'],
            $data['mobile_number']
        ]);
    }

    // Update a student
    public function updateStudent($index_no, $data) {
        $stmt = $this->db->prepare("UPDATE horizonstudents SET first_name = ?, last_name = ?, city = ?, district = ?, province = ?, email_address = ?, mobile_number = ? WHERE index_no = ?");
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['city'],
            $data['district'],
            $data['province'],
            $data['email_address'],
            $data['mobile_number'],
            $index_no
        ]);
    }

    // Delete a student
    public function deleteStudent($index_no) {
        $stmt = $this->db->prepare("DELETE FROM horizonstudents WHERE index_no = ?");
        return $stmt->execute([$index_no]);
    }
}

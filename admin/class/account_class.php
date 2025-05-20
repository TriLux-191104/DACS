<?php
include_once "dtb.php";

?>

<?php
class account
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }



    // Thêm tài khoản mới
    public function insert_account($email, $password, $fullname, $phone, $role)
    {
        $query = "INSERT INTO account (email, password, fullname, phone, role) 
                  VALUES ('$email', '$password', '$fullname', '$phone', '$role')";
        $result = $this->db->insert($query);
        header('Location: accountlist.php');
        return $result;
    }

    // Hiển thị danh sách tài khoản
    public function show_account()
    {
        $query = "SELECT * FROM account ORDER BY id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    // Xóa tài khoản
    public function delete_account($id)
    {
        $query = "DELETE FROM account WHERE id = '$id'";
        $result = $this->db->delete($query);
        header('Location: accountlist.php');
        return $result;
    }

    // Lấy thông tin tài khoản theo ID
    public function get_account($id)
    {
        $query = "SELECT * FROM account WHERE id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    // Cập nhật tài khoản
    public function update_account($email, $password, $fullname, $phone, $role, $id)
    {
        $query = "UPDATE account 
                  SET email = '$email', 
                      password = '$password', 
                      fullname = '$fullname', 
                      phone = '$phone', 
                      role = '$role' 
                  WHERE id = '$id'";
        $result = $this->db->update($query);
        header('Location: accountlist.php');
        return $result;
    }
    public function getAllUsers() {
        $query = "SELECT id, fullname, email FROM account WHERE role = 'user' ORDER BY fullname";
        return $this->db->select($query);
    }
}
?>


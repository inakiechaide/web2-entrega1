<?php
require_once 'app/models/Model.php';

class UserModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }
 
    public function getUserByEmail($email) {    
        $query = $this->db->prepare("SELECT * FROM usuario WHERE email = ?");
        $query->execute([$email]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}

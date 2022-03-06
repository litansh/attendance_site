<?php

/*
 * Tutorial: Google Multi factor authentication in PHP
 *
 * Page: Application library
 * */

class DemoLib
{

    protected $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function __destruct()
    {
        $this->db = null;
    }

    /*
     * Register New User
     *
     * @param $name, $email, $username, $password, $auth_code
     * @return ID
     * */
    public function Register($name, $email, $username, $password, $google_secret_code, $badge, $perm, $IdEmp, $BDAY)
    {
        $query = $this->db->prepare("INSERT INTO clockin.users(name, email, username, password, google_secret_code, badge, perm, IdEmp, BDAY) VALUES (:name,:email,:username,:password,:google_secret_code,:badge,:perm,:IdEmp,:BDAY)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        // $enc_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $query->bindParam("password", $hash, PDO::PARAM_STR);
        $query->bindParam("google_secret_code", $google_secret_code, PDO::PARAM_STR);
        $query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->bindParam("perm", $perm, PDO::PARAM_STR);
        $query->bindParam("IdEmp", $IdEmp, PDO::PARAM_STR);
        $query->bindParam("BDAY", $BDAY, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function AdminRegister($name, $email, $username, $password, $google_secret_code, $badge)
    {
        $query = $this->db->prepare("INSERT INTO clockin.admin(name, email, username, password, google_secret_code, badge) VALUES (:name,:email,:username,:password,:google_secret_code,:badge)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        // $enc_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $query->bindParam("password", $hash, PDO::PARAM_STR);
        $query->bindParam("google_secret_code", $google_secret_code, PDO::PARAM_STR);
		$query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function isBadge($badge)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.users WHERE badge=:badge");
        $query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isEmpID($IdEmp)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.users WHERE IdEmp=:IdEmp");
        $query->bindParam("IdEmp", $IdEmp, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function isAdminBadge($badge)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.admin WHERE badge=:badge");
        $query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isBadgeToDisable($badge)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.users WHERE badge=:badge");
        $query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }
   

    public function ChangePassword($username, $badge, $password)
    {
        $query = $this->db->prepare("UPDATE clockin.users SET password=:password WHERE username=:username AND badge=:badge");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        // $enc_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $query->bindParam("password", $hash, PDO::PARAM_STR);
		$query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function AdminPromotion($username, $badge, $perm)
    {
        $query = $this->db->prepare("UPDATE clockin.users SET perm=:perm WHERE username=:username AND badge=:badge");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("perm", $perm, PDO::PARAM_STR);
        $query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    
    public function DisableUser($username, $badge, $password)
    {
        $query = $this->db->prepare("UPDATE clockin.users SET password=:password WHERE username=:username AND badge=:badge");
        $query->bindParam("password", $password, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
    /*
     * Check Username
     *
     * @param $username
     * @return boolean
     * */
    public function isUsername($username)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdminUsername($username)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.admin WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isUsernameToDisable($username)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /*
     * Check Email
     *
     * @param $email
     * @return boolean
     * */
    public function isEmail($email)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.users WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdminEmail($email)
    {
        $query = $this->db->prepare("SELECT id FROM clockin.admin WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Login
     *
     * @param $username, $password
     * @return $mixed
     * */
    public function Login($username, $password)
    {
        $query = $this->db->prepare("SELECT id, password FROM clockin.users WHERE username=:username OR email=:email");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("email", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            $enc_password = $result->password;
            if (password_verify($password, $enc_password)) {
                return $result->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function AdminLogin($username, $password, $perm)
    {
        $query = $this->db->prepare("SELECT id, password FROM clockin.users WHERE perm=:perm AND username=:username OR email=:email");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("email", $username, PDO::PARAM_STR);
        $query->bindParam("perm", $perm, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            $enc_password = $result->password;
            if (password_verify($password, $enc_password)) {
                return $result->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * get User Details
     *
     * @param $user_id
     * @return $mixed
     * */

    public function UserDetails($user_id)
    {
        $query = $this->db->prepare("SELECT id, name, username, email, google_secret_code, badge FROM clockin.users WHERE id=:user_id");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }
   
    
    public function LastUserDetails($lusername)
    {
        $query = $this->db->prepare("SELECT id, name, username, email, password, google_secret_code, badge FROM clockin.users ORDER BY id DESC LIMIT 1");
        $query->bindParam("lusername", $lusername, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("password", $password, PDO::PARAM_STR);
        $query->bindParam("badge", $badge, PDO::PARAM_STR);

        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

    public function LastAdminDetails($lusername)
    {
        $query = $this->db->prepare("SELECT id, name, username, email, password, google_secret_code, badge FROM clockin.users ORDER BY id DESC LIMIT 1");
        $query->bindParam("lusername", $lusername, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("password", $password, PDO::PARAM_STR);
        $query->bindParam("badge", $badge, PDO::PARAM_STR);

        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

}
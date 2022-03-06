<?php

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

    public function Register($name, $email, $username, $password, $google_secret_code, $badge, $IdEmp)
    {
        $query = $this->db->prepare("INSERT INTO clockin.users(name, email, username, password, google_secret_code, badge, IdEmp) VALUES (:name,:email,:username,:password,:google_secret_code,:badge,:IdEmp)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        // $enc_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $query->bindParam("password", $hash, PDO::PARAM_STR);
        $query->bindParam("google_secret_code", $google_secret_code, PDO::PARAM_STR);
        $query->bindParam("badge", $badge, PDO::PARAM_STR);
        $query->bindParam("IdEmp", $IdEmp, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function Attend($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal)
    {
        $query = $this->db->prepare("INSERT INTO clockin.attend(DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal) VALUES ('$DateRecord', '$TimeRecord', '$TypeInOut', '$IdEmp', '$BadgeNum', '$ClockNum', '$ManualRec', '$EventId', '$Event_Time', '$Note', '$ProjectId', '$Meal')");     
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("IdEmp", $IdEmp, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("ClockNum", $ClockNum, PDO::PARAM_STR);
        $query->bindParam("ManualRec", $ManualRec, PDO::PARAM_STR);
        $query->bindParam("EventId", $EventId, PDO::PARAM_STR);
        $query->bindParam("Event_Time", $Event_Time, PDO::PARAM_STR);
        $query->bindParam("Note", $Note, PDO::PARAM_STR);
        $query->bindParam("ProjectId", $ProjectId, PDO::PARAM_STR);
        $query->bindParam("Meal", $Meal, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function AttendBreak($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal)
    {
        $query = $this->db->prepare("INSERT INTO clockin.break(DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal) VALUES ('$DateRecord', '$TimeRecord', '$TypeInOut', '$IdEmp', '$BadgeNum', '$ClockNum', '$ManualRec', '$EventId', '$Event_Time', '$Note', '$ProjectId', '$Meal')");     
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("IdEmp", $IdEmp, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("ClockNum", $ClockNum, PDO::PARAM_STR);
        $query->bindParam("ManualRec", $ManualRec, PDO::PARAM_STR);
        $query->bindParam("EventId", $EventId, PDO::PARAM_STR);
        $query->bindParam("Event_Time", $Event_Time, PDO::PARAM_STR);
        $query->bindParam("Note", $Note, PDO::PARAM_STR);
        $query->bindParam("ProjectId", $ProjectId, PDO::PARAM_STR);
        $query->bindParam("Meal", $Meal, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function AttendBreakEnd($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal)
    {
        $query = $this->db->prepare("INSERT INTO clockin.break(DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal) VALUES ('$DateRecord', '$TimeRecord', '$TypeInOut', '$IdEmp', '$BadgeNum', '$ClockNum', '$ManualRec', '$EventId', '$Event_Time', '$Note', '$ProjectId', '$Meal')");     
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("IdEmp", $IdEmp, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("ClockNum", $ClockNum, PDO::PARAM_STR);
        $query->bindParam("ManualRec", $ManualRec, PDO::PARAM_STR);
        $query->bindParam("EventId", $EventId, PDO::PARAM_STR);
        $query->bindParam("Event_Time", $Event_Time, PDO::PARAM_STR);
        $query->bindParam("Note", $Note, PDO::PARAM_STR);
        $query->bindParam("ProjectId", $ProjectId, PDO::PARAM_STR);
        $query->bindParam("Meal", $Meal, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function isSelect($BadgeNum, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT BadgeNum FROM clockin.attend WHERE BadgeNum=:BadgeNum AND DateRecord=:DateRecord AND TypeInOut=:TypeInOut");
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
          return false;
        }
        else {
          return true;
        }
    }

    public function isSelectBreak($BadgeNum, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT BadgeNum FROM clockin.break WHERE BadgeNum=:BadgeNum AND DateRecord=:DateRecord AND TypeInOut=:TypeInOut");
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
          return false;
        }
        else {
          return true;
        }
    }

    public function isSelectOut($BadgeNum, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT BadgeNum FROM clockin.attend WHERE BadgeNum=:BadgeNum AND DateRecord=:DateRecord AND TypeInOut=:TypeInOut");
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() < 0) {
          return false;
        }
        else {
          return true;
        }
    }

    public function BreakTime($BadgeNum, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT Rec_Time FROM clockin.break WHERE BadgeNum=:BadgeNum AND DateRecord=:DateRecord AND TypeInOut=:TypeInOut");
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function isSelectOutBreak($BadgeNum, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT BadgeNum FROM clockin.break WHERE BadgeNum=:BadgeNum AND DateRecord=:DateRecord AND TypeInOut=:TypeInOut");
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
          return false;
        }
        else {
          return true;
        }
    }


    public function isSelectOutBreakEnd($BadgeNum, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT BadgeNum FROM clockin.break WHERE BadgeNum=:BadgeNum AND DateRecord=:DateRecord AND TypeInOut=:TypeInOut");
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
          return false;
        }
        else {
          return true;
        }
    }

    public function OutUpdate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("UPDATE clockin.attend SET TimeRecord=:TimeRecord WHERE TypeInOut=:TypeInOut AND BadgeNum=:BadgeNum ORDER BY id DESC LIMIT 1");
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function OutUpdateDate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("UPDATE clockin.attend SET DateRecord=:DateRecord WHERE TypeInOut=:TypeInOut AND BadgeNum=:BadgeNum ORDER BY id DESC LIMIT 1");
        // $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function OutUpdateBreak($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("UPDATE clockin.break SET TimeRecord=:TimeRecord WHERE TypeInOut=:TypeInOut AND BadgeNum=:BadgeNum AND DateRecord=:DateRecord");
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function OutUpdateBreakEnd($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut)
    {
        $query = $this->db->prepare("UPDATE clockin.break SET TimeRecord=:TimeRecord WHERE TypeInOut=:TypeInOut AND BadgeNum=:BadgeNum AND DateRecord=:DateRecord");
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function Entrance($Username, $ENT_Time, $ENT_Date)
    {
        $query = $this->db->prepare("INSERT INTO clockin.entrance(Username, ENT_Time, ENT_Date) VALUES ('$Username','$ENT_Time','$ENT_Date')");     
        $query->bindParam("Username", $Username, PDO::PARAM_STR);
        $query->bindParam("ENT_Time", $ENT_Time, PDO::PARAM_STR);
        $query->bindParam("ENT_Date", $ENT_Date, PDO::PARAM_STR);
        $query->execute();
        return $ENT_Time;
    }

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


    public function UserDetails($user_id)
    {
        $query = $this->db->prepare("SELECT id, name, username, email, google_secret_code, badge, IdEmp FROM clockin.users WHERE id=:user_id");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

    public function UserDetailsBreak($user_id)
    {
        $query = $this->db->prepare("SELECT TypeInOut, BadgeNum, DateRecord, TimeRecord FROM clockin.break WHERE BadgeNum=:user_id");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }
    

    public function UserEnter($Username)
    {
        // $ENT_Date = date('Y-m-d', time());
        $query = $this->db->prepare("SELECT id, Username, ENT_Time, ENT_Date FROM clockin.entrance WHERE Username=:Username ORDER BY id DESC LIMIT 1");
        $query->bindParam("Username", $Username, PDO::PARAM_STR);
        // $query->bindParam("ENT_Date", $ENT_Date, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

    
    public function UserEnterBreak($BadgeNum)
    {
        $query = $this->db->prepare("SELECT TimeRecord FROM clockin.break WHERE BadgeNum=:BadgeNum");
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

    public function CheckLogAttend($BadgeNum, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal FROM clockin.attend WHERE BadgeNum=:BadgeNum AND TypeInOut=:TypeInOut ORDER BY id DESC LIMIT 1");
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

    public function CheckLogOut($BadgeNum, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal FROM clockin.attend WHERE BadgeNum=:BadgeNum AND TypeInOut=:TypeInOut ORDER BY id DESC LIMIT 1");
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }
	
	    public function CheckLogBreak($BadgeNum, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal FROM clockin.break WHERE BadgeNum=:BadgeNum AND TypeInOut=:TypeInOut ORDER BY id DESC LIMIT 1");
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

    public function CheckLogBreakStart($TimeRecord, $DateRecord, $BadgeNum, $TypeInOut)
    {
        $query = $this->db->prepare("SELECT DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal FROM clockin.break WHERE BadgeNum=:BadgeNum AND TypeInOut=:TypeInOut AND DateRecord=:DateRecord AND TimeRecord=:TimeRecord ORDER BY id DESC LIMIT 1");
        $query->bindParam("TypeInOut", $TypeInOut, PDO::PARAM_STR);
        $query->bindParam("BadgeNum", $BadgeNum, PDO::PARAM_STR);
        $query->bindParam("DateRecord", $DateRecord, PDO::PARAM_STR);
        $query->bindParam("TimeRecord", $TimeRecord, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

    public function CheckLogEntrance($Username)
    {
        $query = $this->db->prepare("SELECT Username, ENT_Time, ENT_Date FROM clockin.entrance WHERE Username=:Username ORDER BY id DESC LIMIT 1");
        $query->bindParam("Username", $Username, PDO::PARAM_STR);
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }





}
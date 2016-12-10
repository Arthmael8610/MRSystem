<?php

/**
 * Created by PhpStorm.
 * User: msqua
 * Date: 12/6/2016
 * Time: 8:13 PM
 */
class mrsystem
{
    public function DBConnect()
    {
        $host = 'localhost';
        $user = 'MRS_root';
        $pass = 'AAdksfK8+dry';
        $DB = 'MRSystem';

        try{
            $mysqli = new mysqli($host, $user, $pass, $DB);
        }catch(Exception $e){
            return array('status'=>'Could not connect to '.$DB.' on '.$host);
        }
        return $mysqli;
    }
    public function register($first_name, $last_name, $username, $password, $confirm_password, $email, $role='1', $reference_number='000000000') //Roles: 1:selector, 2:moderator, 3:Admin
    {
        $mysqli = self::DBConnect();
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO MRSystem.users (user_name, password, email, role) VALUES('.$username.', '.$password.', '.$email.', '.$role.')';
        if ($mysqli->query($sql) == true){
            $last_id = $mysqli->insert_id;
            $sql2 = 'INSERT INTO MRSystem.members (user_id, first_name, last_name, date_created) VALUES('.$last_id.', '.$first_name.', '.$last_name.', NOW())';
            if($mysqli->query($sql2)){
                return true;
            }
        }
        return false;
    }
    public function Login($username, $password)
    {
    	$mysqli = self::DBConnect();
    	$sql = 'SELECT password FROM users WHERE user_name='.mysqli_real_escape_string($username);
    	$pass = $mysqli->query($sql);
    	$result = password_verify(mysqli_real_escape_string($password), $pass);
    	$sql2 = 'SELECT role FROM users WHERE user_name='.mysqli_real_escape_string($username);
    	if($result){
    	    $role = $mysqli->query($sql2);
    	    return $role;
        }else{
    	    return false;
        }

    }
    public function EditMember($user_id)
    {
        //Reference has to be all numeric!
    }
    public function RemoveMember($user_id)
    {

    }
    public function CreateMember($first_name, $last_name, $username, $password, $confirm_password, $email, $role='1', $reference_number='0')
    {
        $mysqli = self::DBConnect();
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO MRSystem.users (user_name, password, email, role) VALUES($username, $password, $email, $role)';
        $sql2 = 'INSERT INTO MRSystem.members (user_id, first_name, last_name, date_created) VALUES($last_id, $first_name, $last_name, NOW())';
        if ($mysqli->query($sql) == true){
            $last_id = $mysqli->insert_id;
            if($mysqli->query($sql2)){
                return true;
            }
        }
        return false;
    }
    public function GetRandom($num)
    {
		$sql = 'SELECT column FROM members ORDER BY RAND() LIMIT '.$num;
		$mysqli = self::DBConnect();
		$results = $mysqli->query($sql);

		return $results;
    }
    public function ViewSelected()
    {

    }
    public function Export2PDF()
    {

    }
}
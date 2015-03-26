<?php

class CUser{

private $db = null;

public function __construct($db) {
	$this->db = $db;
}

public function __destruct() {}

//Check if session has user.
public function StatusCheck(){
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
$admin = isset($_SESSION['admin']) ? $_SESSION['admin']->acronym : null;
if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "Du är INTE inloggad.";
}

return $output;
}

//Save user in session. If admin - save admin in session.
public function LogIn(){
$output = null;
$sql = "SELECT id, acronym, name, favfilm, favactor FROM USER WHERE acronym = ? AND password = md5(concat(?, salt))";
  $res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($_POST['acronym'], $_POST['password']));
  if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
    header("Location: member.php");
  }
  if (isset($_SESSION['user']) && $_SESSION['user']->acronym=='admin'){
      $_SESSION['admin'] = $res[0];
    }
  else{
    $output = "<p>Du verkar ha skrivit in fel användarnamn eller lösenord. Var god försök igen!</p>";
  }
  return $output;
}

//unsets user/admin.
public function LogOut(){
	unset($_SESSION['user']);
  unset($_SESSION['admin']);
  	header('Location: login.php');
}

}
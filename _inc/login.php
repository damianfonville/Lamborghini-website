<?php
if(isset($_SESSION['id'])){
echo "<h1>welkom ".klant("vnaam")."</h1>";
}else{
?>

<h1>Login</h1>
<div class="login">
<?php



$form = '<form method="post" action="">
<input type="text" name="email" placeholder="e-mail" />
<input type="password" name="wachtwoord" placeholder="wachtwoord" />
<input type="submit" name="submit" value="Login"/>
</form>';

if(isset($_POST['submit'])){
$error = "";
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];
$query = "SELECT klantnr, wachtwoord FROM klanten WHERE email = :email";
$loginquery = $db->prepare($query);
$loginquery->bindParam(':email', $email, PDO::PARAM_STR);
$loginquery->execute();
$gegevens = $loginquery->fetch(PDO::FETCH_ASSOC);
if(empty($email)){
$error = "E-mail is leeg";
}elseif(empty($wachtwoord)){
$error = "Wachtwoord is leeg";
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
$error = "E-mail is geen emailadress";
}elseif($loginquery->rowCount() != 1){
$error = "foute gegevens";
}elseif(!password_verify($wachtwoord, $gegevens['wachtwoord'])){
$error = "fout wachtwoord";
}

if($error == ""){
$_SESSION['id'] = $gegevens['klantnr'];
header('Location: ?page=login');
}else{
echo "<p>".$error."</p>";
echo $form;
}

}else
echo $form;


 ?>
</div>

<?php } ?>
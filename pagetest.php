<!DOCTYPE html>

<?php 

$bdd = new PDO('mysql:host=localhost;port:3308;dbname=abcd','root','');

if( isset($_POST['sub2']))
{
	$prenom = htmlspecialchars($_POST['prenom']);
	$nom = htmlspecialchars($_POST['nom']);
	$phone1 = htmlspecialchars($_POST['mail1']);
	$phone2 = htmlspecialchars($_POST['mail2']);
	$pass = htmlspecialchars($_POST['pass']);
	if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail1']) AND !empty($_POST['mail2']) AND !empty($_POST['pass']))
	{
		if(filter_var($phone1,FILTER_VALIDATE_EMAIL))
		{
			$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail = ?");
			$reqmail-> execute(array($phone1));
			$mailexist = $reqmail->rowCount();
			if($mailexist == 0)
			{
				if($phone1 == $phone2)
				{
					$insertmbr = $bdd ->prepare("INSERT INTO membre(nom, prenom, mail, motdepasse) VALUES( ?, ?, ?, ?)");
					$insertmbr->execute(array($nom, $prenom, $phone1, $pass));
					$erreur = "Votre compte a bien été créer";
							header("pagetest.php");
				}
				else
				{
					$erreur = "Vos E-mails ne sont pas identiques";
				}
			}
			else
			{
				$erreur = "Adresse mail déja utilisé";
			}
		}
		else
		{
			$erreur = "Votre email est invalide";
		}
	}
}

?>

<html>
<head>
	<title> Page test</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="page.css">
</head>
<body>
<header>
	<form method="post" action="profil.php" name="connexion">
		<div id="base">
			<p> <label> Adresse e-mail ou mobile </br><input type="email" name="mail" placeholder="Votre Login"><br></label> </p>
			<p><label>Mot de Passe </br><input type="password" name="pass" placeholder="Votre mot de passe"> <br> <a href="oublie.php">Informations de compte oubliées ? </a></label> </p> <br> <br>
			<input type="submit" name="submit" value="Connexion" style="padding : 10px, margin: 5px;">
		</div>
	</form>
</header>


<form method="post" name="form2" action="pagetest.php">
	<div id="boite">
		<h1> Inscription </h1>
		<h2> C'est gratuit (et ça le restera toujours) </h2>
		<div id="boite2">
			<p><input type="text" name="prenom" placeholder="Prénom"> </p>
			<p>      </p>
			<p><input type="text" name="nom" placeholder="Nom de famille"> </p>
		</div>
		<p><input type="mail" name="mail1" placeholder="Numéro de mobile ou email"> </p>
		<p><input type="mail" name="mail2" placeholder="Confirmer numéro de mobile ou email"> </p>
		<p><input type="password" name="pass" placeholder="Nouveau mot de passe"> </p>
		<h4> Date de Naissance </h4>
		<div id="date">
			<input type="date" name="date">
			<a href="explication.php">¨Pourquoi indiquer ma date de naissance</a>
		</div>
		<br>
		<div id="sexe">
			<label><input type="radio" name="sexe" id="Femme" value="Femme"> Femme </label>
			<label><input type="radio" name="sexe" id="Homme" value="Homme"> Homme </label>
		</div>
		<div id="conditions">
			<p> En cliquant sur Inscription, vous acceptez nos <a href="conditions.php">Conditions</a> et indiquez que vous avez lu notre <a href="confidentialite.php"> Politique d'utilisation des données</a>, y compris notre <a href="cookie.php"> Utilisation des cookies.</a> Vous pourrez recevoir des notifications par texto de la part de Facebook et pouvez vous désabonner à tout moment. </p>
		</div>
		<input type="submit" name="sub2" value="Inscription">
	</div>
</form>

</body>
</html>


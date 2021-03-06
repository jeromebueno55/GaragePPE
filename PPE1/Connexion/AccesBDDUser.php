<?php
	include('../Modele/modele.class.php');

	/* GetOS */

	$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

	function getOS() { 

	    global $user_agent;

	    $os_platform    =   "Unknown OS Platform";

	    $os_array       =   array(
	                            '/windows nt 10/i'     =>  'Windows 10',
	                            '/windows nt 6.3/i'     =>  'Windows 8.1',
	                            '/windows nt 6.2/i'     =>  'Windows 8',
	                            '/windows nt 6.1/i'     =>  'Windows 7',
	                            '/windows nt 6.0/i'     =>  'Windows Vista',
	                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	                            '/windows nt 5.1/i'     =>  'Windows XP',
	                            '/windows xp/i'         =>  'Windows XP',
	                            '/windows nt 5.0/i'     =>  'Windows 2000',
	                            '/windows me/i'         =>  'Windows ME',
	                            '/win98/i'              =>  'Windows 98',
	                            '/win95/i'              =>  'Windows 95',
	                            '/win16/i'              =>  'Windows 3.11',
	                            '/macintosh|mac os x/i' =>  'Mac OS X',
	                            '/mac_powerpc/i'        =>  'Mac OS 9',
	                            '/linux/i'              =>  'Linux',
	                            '/ubuntu/i'             =>  'Ubuntu',
	                            '/iphone/i'             =>  'iPhone',
	                            '/ipod/i'               =>  'iPod',
	                            '/ipad/i'               =>  'iPad',
	                            '/android/i'            =>  'Android',
	                            '/blackberry/i'         =>  'BlackBerry',
	                            '/webos/i'              =>  'Mobile'
	                        );

	    foreach ($os_array as $regex => $value) { 

	        if (preg_match($regex, $user_agent)) {
	            $os_platform    =   $value;
	        }

	    }   

	    return $os_platform;

	}

	function getBrowser() {

	    global $user_agent;

	    $browser        =   "Unknown Browser";

	    $browser_array  =   array(
	                            '/msie/i'       =>  'Internet Explorer',
	                            '/firefox/i'    =>  'Firefox',
	                            '/safari/i'     =>  'Safari',
	                            '/chrome/i'     =>  'Chrome',
	                            '/edge/i'       =>  'Edge',
	                            '/opera/i'      =>  'Opera',
	                            '/netscape/i'   =>  'Netscape',
	                            '/maxthon/i'    =>  'Maxthon',
	                            '/konqueror/i'  =>  'Konqueror',
	                            '/mobile/i'     =>  'Handheld Browser'
	                        );

	    foreach ($browser_array as $regex => $value) { 

	        if (preg_match($regex, $user_agent)) {
	            $browser    =   $value;
	        }

	    }

	    return $browser;

	}


	$user_os        =   getOS();
	$user_browser   =   getBrowser();

	function connexionBDD()
	{
		$user_os = getOS();

		if ($user_os != 'Mac OS X') { return $unModele = new Modele("localhost", "Garage", "root", ""); }
		else { return $unModele = new Modele("localhost", "Garage", "root", "root"); }
	}

/* General */

	function dateFormatJJMMAAAA($date)
	{
	    list($year, $month, $day) = explode('-', $date);

	    return "$day / $month / $year";
	}

	function dateFormatAAAAMMJJ($date)
	{
	    list($day, $month, $year) = explode('/', $date);

	    return "$year-$month-$day";
	}

	function timeFormatNh($heure)
	{
		list($h, $min, $s) = explode(':', $heure);

		return "$h";
	}

/* CONNEXION */

	function Inscription()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Particuliers");

		$tab = array(
				"civilite_Particulier"=>$_POST['civilite_Particulier'],
				"prenom_Particulier"=>$_POST['prenom_Particulier'],
				"dateNaiss_Particulier"=>$_POST['dateNaiss_Particulier'],
				"nom_Client"=>$_POST['nom_Client'],
				"mail_Client"=>$_POST['mail_Client'],
				"mdp_Client"=> sha1(sha1($_POST['mdp_Client'])),
				"adr_Client"=>$_POST['adr_Client'],
				"CP_Client"=>$_POST['CP_Client'],
				"ville_Client"=>$_POST['ville_Client'],
				"tel_Client"=>$_POST['tel_Client'],
				"etat_Client"=>$_POST['etat_Client']
			);

		$unModele->insert($tab);
	}

	function InscriptionEntreprise()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Entreprises");

		$tab = array(
				"numSIRET_Entreprise"=>$_POST['numSIRET_Entreprise'],
				"activite_Entreprise"=>$_POST['activite_Entreprise'],
				"nom_Client"=>$_POST['nom_Client'],
				"mail_Client"=>$_POST['mail_Client'],
				"mdp_Client"=> sha1(sha1($_POST['mdp_Client'])),
				"adr_Client"=>$_POST['adr_Client'],
				"CP_Client"=>$_POST['CP_Client'],
				"ville_Client"=>$_POST['ville_Client'],
				"tel_Client"=>$_POST['tel_Client'],
				"etat_Client"=>$_POST['etat_Client']
			);

		$unModele->insert($tab);
	}

	function Connexion()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Particuliers");

		$tab = array(
				"mail_Client" => $_POST['mail_Client'],
				"mdp_Client"=>sha1(sha1($_POST['mdp_Client']))
			);

		$resultat = $unModele->selectCount($tab);
		
		return $resultat;
	}

	function ConnexionEntreprise()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Entreprises");

		$tab = array(
				"mail_Client" => $_POST['mail_Client'],
				"mdp_Client"=> sha1(sha1($_POST['mdp_Client']))
			);

		$resultat = $unModele->selectCount($tab);
		
		return $resultat;
	}

	function selectInfo()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Particuliers");

		$champs = array("ID_Client", "nom_Client", "mail_Client", "prenom_Particulier", "civilite_Particulier", "dateNaiss_Particulier", "adr_Client", "CP_Client", "ville_Client", "tel_Client", "etat_Client");

		$tab = array("mail_Client"=>$_POST['mail_Client']);

		$resultatID = $unModele->selectWhere($champs, $tab);

		return $resultatID;
	}

	function selectInfoEnt()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Entreprises");

		$champs = array("ID_Client", "nom_Client", "mail_Client", "numSIRET_Entreprise", "activite_Entreprise", "adr_Client", "CP_Client", "ville_Client", "tel_Client", "etat_Client");

		$tab = array("mail_Client"=>$_POST['mail_Client']);

		$resultatID = $unModele->selectWhere($champs, $tab);

		return $resultatID;
	}
	
	function verifInscription()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Clients");

		$tab = array(
				"mail_Client" => $_POST['mail_Client']
			);

		$resultat = $unModele->selectCount($tab);

		return $resultat;
	}

/* PROFIL */

	function selectMarque()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("TypeVehicules");

		$resultatMarque = $unModele->selectDistinct("marque_Vehicule");

		return $resultatMarque;
	}

	function selectModele($marque)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("TypeVehicules");

		$champs = array("modele_Vehicule");
 
		$tab = array( 
			"marque_Vehicule"=>$marque
			);

		$resultatModele = $unModele->selectWhereAll($champs, $tab);

		return $resultatModele;
	}

	function selectNbModele($marque)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("TypeVehicules");

		$tab = array(
				"marque_Vehicule" => $marque
			);

		$resultatModele = $unModele->selectCount($tab);

		return $resultatModele;
	}

	function selectIDTypeVehicule()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("TypeVehicules");

		$champs = array("ID_TypeVehicule");
 
		$tab = array(
			"marque_Vehicule"=>$_POST['marque_Vehicule'], 
			"modele_Vehicule"=>$_POST['modele_Vehicule']
			);

		$resultatTypeVehicule = $unModele->selectWhere($champs, $tab);

		return $resultatTypeVehicule;
	}

	function selectIDClient()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Clients");

		$champs = array("ID_Client");
 
		$tab = array(
			"mail_Client"=>$_POST['mail_Client']
			);

		$resultatIDClient = $unModele->selectWhere($champs, $tab);

		return $resultatIDClient;
	}

	function ajoutVehicule($idtv, $idc)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Vehicules");

		$tab = array(
				"ID_TypeVehicule"=>$idtv,
				"ID_Client"=>$idc,
				"immat_Vehicule"=>$_POST['immat_Vehicule'],
				"dateachat_Vehicule"=>$_POST['dateachat_Vehicule'],
				"km_Vehicule"=>$_POST['km_Vehicule'],
				"couleur_Vehicule"=>$_POST['couleur_Vehicule']
			);

		$unModele->insert($tab);
	}

	function vehiculeClient($idc)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("v_ClientAndVehicule");

		$champs = array(
				"ID_Vehicule",
				"marque_Vehicule",
				"modele_Vehicule",
				"immat_Vehicule",
				"km_Vehicule",
				"dateachat_Vehicule",
				"couleur_Vehicule"
			);
 
		$tab = array(
				"ID_Client"=>$idc
			);

		$resultatVehicule = $unModele->selectWhereAll($champs, $tab);

		return $resultatVehicule;
	}

	function nbVehicule()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Vehicules");

		$tab = array(
				"ID_Client" => $_SESSION['ID_Client']
			);

		$resultat = $unModele->selectCount($tab);
		
		return $resultat;
	}

	function selectRDV()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("v_RDVClientVehicule");

		$champs = array(
				"ID_RDV",
				"ID_Vehicule",
				"marque_Vehicule",
				"modele_Vehicule",
				"immat_Vehicule",
				"date_RDV",
				"heure_RDV"
			);
 
		$tab = array(
				"ID_Client"=>$_SESSION['ID_Client']
			);

		$resultatVehicule = $unModele->selectWhereAll($champs, $tab);

		return $resultatVehicule;
	}

	function nbRDV()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("v_RDVClientVehicule");

		$tab = array(
				"ID_Client" => $_SESSION['ID_Client']
			);

		$resultat = $unModele->selectCount($tab);
		
		return $resultat;
	}

	function deleteVehicule($idv)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Vehicules");

		$tab = array(
				"ID_Vehicule" => $idv
			);

		$resultat = $unModele->delete($tab);
	}

	function deleteRDV($idrdv)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("RDV");

		$tab = array(
				"ID_RDV" => $idrdv
			);

		$resultat = $unModele->delete($tab);
	}

	function selectNbDevis()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Devis");

		$tab = array(
				"ID_Client" => $_SESSION['ID_Client']
			);

		$resultat = $unModele->selectCount($tab);
		
		return $resultat;
	}

	function selectDevis()
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Devis");

		$champs = array(
				"Num_Devis",
				"ID_Vehicule",
				"ID_Operation",
				"date_Devis"
			);
 
		$tab = array(
				"ID_Client"=>$_SESSION['ID_Client']
			);

		$resultatVehicule = $unModele->selectWhereAll($champs, $tab);

		return $resultatVehicule;
	}

	function vehiculeDevis($idV)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("v_ClientAndVehicule");

		$champs = array(
				"marque_Vehicule",
				"modele_Vehicule",
				"immat_Vehicule"
			);
 
		$tab = array(
				"ID_Vehicule"=>$idV
			);

		$resultatVehicule = $unModele->selectWhere($champs, $tab);

		return $resultatVehicule;
	}

	function operationDevis($idO)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Operations");

		$champs = array(
				"libelle_Operation"
			);
 
		$tab = array(
				"ID_Operation"=>$idO
			);

		$resultatOperation = $unModele->selectWhere($champs, $tab);

		return $resultatOperation;
	}

	function deleteDevis($idD)
	{
		$unModele = connexionBDD();

		$unModele->renseigner("Devis");

		$tab = array(
				"NUM_Devis" => $idD
			);

		$resultat = $unModele->delete($tab);
	}
?>
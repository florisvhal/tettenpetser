<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<style>
table, tr, td {
	border: 1px solid black;
}
table {
	border-collapse: collapse;
}
</style>
</head>
<body>
<?php
$item = array (
	array('Tettenpetser ','/img/npo1.png','100','1'),
	array('Tettenpetser2000 ','/img/npo2.png','200','3'),
	array('Tettenpetser69 ','/img/npo3.png','300','6')
);

echo '<h1>Webshop</h1>';

if(isset($_GET['actie']) && (isset($_GET['id'])) && $_GET['id'] != '') {
	if (isset($_SESSION['bestel'])){
		$bestelItem = explode('[@]', $_SESSION['bestel']);
		if (!in_array($_GET['id'], $bestelItem)){
			$_SESSION['bestel'] = $_GET['id'].'[@]'.$_SESSION['bestel'];
		}
		
		echo $_SESSION['bestel'];
	}
	else {
		$_SESSION['bestel'] = $_GET['id'].'[@]';
	}
} else if(isset($_GET['actie']) && ($_GET['actie'] == 'winkelwagen')){
	if (isset($_SESSION['bestel'])){
		$winkelwageniItem = explode('[@]', trim($_SESSION['bestel'], '[@]'));
		echo '<table><form method="post">';
		$rekenprijs = 0;
		foreach($winkelwageniItem AS $itemInWagen){
			if (isset($_POST['aantal-'.$itemInWagen])){
				$aantal = $_POST['aantal-'.$itemInWagen];
			}else{$aantal = 1;}
			foreach($item AS $itemInfo) {
				if ($itemInWagen == $itemInfo[3]){
					$itemNaam = $itemInfo[0];
					$itemPrijs = ($itemInfo[2]*$aantal);
					$rekenprijs = $itemPrijs+$rekenprijs;
				}
			}
			echo '<tr><td><input type="text" value="'.$aantal.'" name="aantal-'.$itemInWagen.'"/><input type="submit" value=">>" /></td><td>'.$itemNaam.'</td><td>&euro; '.($itemPrijs/100).'</td></tr>';
		}
		echo '<tr><td colspan="2">Totaal</td><td>&euro;'.($rekenprijs/100).'</td></tr>';
		echo '</form></table>';
	}else{
		echo 'Er ging iets mis';
	}
} else
	{
	foreach($item AS $itemInfo) {
		echo '<p><strong>'.$itemInfo[0].'</strong><br /><img src="'.$itemInfo[1].'" height ="150" /></p>';
		echo '<p>&euro; '.($itemInfo[2]/100).'</p>';
		echo '<a href="?actie=bestel&id='.$itemInfo[3].'">Bestellen</a>';
	}
}
echo '<br /><a href="?actie=winkelwagen">winkelwagen</a>';
echo '<br /><a href="webshop.php">home</a>';
?>
</body>
</html>
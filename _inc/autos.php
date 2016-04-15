<script>
		$(function(){
			$(".auto a").fancybox({
    	openEffect	: 'elastic',
    	closeEffect	: 'elastic',
		padding : 0,
    	helpers : {
    		title : {
    			type : 'inside'
    		}
    	}
    });
});
	</script>
<div class="auto">
<?php
if(isset($_GET['id'])){
$query = "SELECT *, autonr AS id FROM auto WHERE autonr = ?";
$auto = $db->prepare($query);
$auto->bindValue(1, $_GET['id'], PDO::PARAM_INT);
$auto->execute();
if($auto->rowCount() == 1){
$result = $auto->fetch(PDO::FETCH_ASSOC);
$prijs = explode(".", $result['prijs']);
echo "<script>document.title += ' - ".$result['naam']."';</script>";
$fotos = glob("foto/".$result['id']."/*.jpg");
?>
<h1><?php echo $result['naam']; ?></h1>
<?php foreach($fotos as $foto){
echo "<a rel=\"auto\" href=\"".$foto."\"><img src=\"".$foto."\" /></a>\n";
}
?>
<div class="clear"></div>
<?php echo nl2br($result['details']); ?>
<h2>Specificaties</h2>	
<table>
	<tr>
		<td>Prijs</td>
		<td>&euro; <?php echo number_format($prijs[0], 0, ',', '.'); ?>,<sup><?php echo $prijs[1]; ?></sup></td>
	</tr>
	<tr>
		<td>Maximale snelheid</td>
		<td><?php echo $result['snelheid']; ?>Km/H</td>
	</tr>
	<tr>
		<td>0 tot 100km/h</td>
		<td><?php echo $result['acceleratie'];?>s</td>
	</tr>
</table>
<table>
	<tr>
		<td>Verbruik</td>
		<td><?php echo $result['verbruik']; ?>l/100km</td>
	</tr>
	<tr>
		<td>uitstoot</td>
		<td><?php echo $result['uitstoot']; ?>g</td>
	</tr>
	<tr>
		<td>kracht</td>
		<td><?php echo $result['pk']; ?>g</td>
	</tr>
</table>
<?php 
}else
echo "Er is een fout opgetreden";

} ?>
</div>
<div class="clear"></div>
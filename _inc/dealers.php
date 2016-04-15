<h1>dealers</h1>
<?php

$dealerquery = $db->prepare("SELECT * FROM dealers");
$dealerquery->execute();

while($dealer = $dealerquery->fetch(PDO::FETCH_ASSOC)){
?>
<div class="dealer">
<?=$dealer['naam']; ?><br/>
<?=$dealer['adres']; ?><br/>
<?=$dealer['postcode']; ?> <?=$dealer['stad']; ?><br/>
<?=$dealer['land']; ?><br/>
tel: <a href="tel:<?=$dealer['telnr']; ?>"><?=$dealer['telnr']; ?></a><br/>
E-mail: <a href="mailto:<?=$dealer['email']; ?>"><?=$dealer['email']; ?></a><br/>
</div>
<hr />
<?php
}
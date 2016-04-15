<?php
require_once("config/config.php");
$q = $_GET['q'];
$hint="";
$autos = $db->prepare("
SELECT *, auto.naam AS autonaam, dealers.naam AS dealernaam FROM autoklant, auto, dealers
WHERE auto.autonr = autoklant.autonr
AND dealers.dealernr = dealers.dealernr
AND klantnr = {$_SESSION['id']} AND auto.naam LIKE ?");
$autos->bindValue(1, "$q%", PDO::PARAM_STR);
$autos->execute();
//get the q parameter from URL
while($result = $autos->fetch(PDO::FETCH_ASSOC)){
      if ($hint=="")
        {
        $hint="<a href='#" .
        $result['id'] .
        "' >" .
        $result['autonaam'] . "</a>";
        }
      else
        {
        $hint.="<br /><a href='#" .
        $result['id'] .
        "' >" .
        $result['autonaam'] . "</a>";
        }
      
    }
  


// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint=="")
  {
  $response="no suggestion";
  }
else
  {
  $response=$hint;
  }

//output the response
echo $response;
?> 
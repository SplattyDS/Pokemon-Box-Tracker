<?php
define('TITLE', 'PokeBox - Rare');

require('config.php');
require('includes/navbar.php');

function Gallery($title, $arr, $type)
{
	if (count($arr) == 0)
		return;
	
	global $folders;
	
	print('<div class="center gallery">');
	print('<h1>'.$title.'</h1>');
	
	for ($i = 0; $i < count($arr); $i++)
	{
		print('<img class="lock" src="images/'.$folders[$type].'/'.$arr[$i].'.png">');
	}
	
	print('</div>');
}

$rare = array(670,1073,1074,1121,1123,1205,1269,1286,1288);

Gallery("Rare Shiny Pokémon", $rare, TYPE_SHINY);
?>

</body>
</html>
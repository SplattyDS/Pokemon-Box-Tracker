<?php
define('TITLE', 'PokeBox - Unboxable');

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

Gallery("Locked Pokémon", $lockList[TYPE_NORMAL], TYPE_NORMAL);
Gallery("Shiny Locked Pokémon", $lockList[TYPE_SHINY], TYPE_SHINY);
Gallery("Locked Gigantamax Pokémon", $lockList[TYPE_GMAX], TYPE_GMAX);
Gallery("Shiny Locked Gigantamax Pokémon", $lockList[TYPE_SHINY_GMAX], TYPE_SHINY_GMAX);
?>

</body>
</html>
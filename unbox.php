<?php
define('TITLE', 'PokeBox - Unboxable');

require('config.php');
require('includes/navbar.php');

function Gallery($title, $arr)
{
	print('<div class="center gallery">');
	
	print('<h1>'.$title.'</h1>');
	
	for ($i = 0; $i < count($arr); $i++)
	{
		print('<img class="unbox" data-src="images/normal_unbox/'.$arr[$i].'.png" src="images/0.png" onmouseenter="OnImgHover(event)" onmouseleave="OnImgNoHover(event)" style="background-image: url(\'images/normal_unbox/'.$arr[$i].'.png\');">');
	}
	
	print('</div>');
}
?>

<script>
function OnImgHover(event)
{
	console.log("hover");
	
	var e = event.target;
	
	SwapBackgroundImage(e);
}

function OnImgNoHover(event)
{
	console.log("no hover");
	
	var e = event.target;
	
	SwapBackgroundImage(e);
}

function SwapBackgroundImage(e)
{
	// e.style.backgroundImage = `url(${src})`;
	
	var src = e.getAttribute('data-src');
	
	if (e.style.backgroundImage.includes("normal_unbox"))
		src = src.replace("normal_unbox", "shiny_unbox");
	
	e.style.backgroundImage = `url(${src})`;
}
</script>

<?php
$egg = array(1,119);
$mega = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49);
$primal = array(50,51);
$ultra = array(52);
$eternamax = array(53);
$fusion = array(54,55,56,57,58,59);
$item = array(120,121,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,123,124,125);
$battle = array(99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,122);

Gallery("Eggs", $egg);
Gallery("Mega Evolution", $mega);
Gallery("Primal Reversion", $primal);
Gallery("Ultra Burst", $ultra);
Gallery("Eternamax", $eternamax);
Gallery("Fusions", $fusion);
Gallery("Held Item", $item);
Gallery("Battle Only", $battle);

return;

for ($i = 99; $i <= 118; $i++)
{
	print(',');
	print($i);
}
?>

</body>
</html>
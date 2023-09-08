<?php
define('TITLE', 'PokeBox');

require('config.php');
require('includes/navbar.php');

$list = array();
$slist = array();

if (isset($_POST['list'][0]))
{
	$list = JSON_decode('['.($_POST['list'][0]).']');
	$slist = JSON_decode('['.($_POST['slist'][0]).']');
}

for ($i = count($list); $i < NUM_NORMAL_POKEMON; $i++)
	array_push($list, false);

for ($i = count($slist); $i < NUM_SHINY_POKEMON; $i++)
	array_push($slist, false);

if ($_SESSION['LOGIN_OK'])
{
	$sql1 = 'SELECT Username, NormalData, ShinyData FROM users WHERE Id = '.$_SESSION['Id'];
	$sql2 = 'UPDATE users SET NormalData = :normal, ShinyData = :shiny WHERE Id = '.$_SESSION['Id'];
	$sql3 = 'UPDATE users SET NormalData = :normal, ShinyData = :shiny WHERE Id = '.$_SESSION['Id'];
	
	$results1 = $dbh->query($sql1);
	
	foreach ($results1 as $resultaat)
	{
		if ($resultaat['NormalData'] == null || $resultaat['ShinyData'] == null)
		{
			if ($stmt2 = $dbh->prepare($sql2))
			{
				$JS1_1 = JSON_encode($list);
				$JS1_2 = JSON_encode($slist);
				
				$stmt2->bindParam(":normal", $JS1_1, PDO::PARAM_STR);
				$stmt2->bindParam(":shiny", $JS1_2, PDO::PARAM_STR);
				
				$stmt2->execute();
			}
		}
		
		if (isset($_POST['list']) && isset($_POST['slist']))
		{
			if ($stmt3 = $dbh->prepare($sql3))
			{
				$JS3_1 = $_POST['list'][0];
				$JS3_2 = $_POST['slist'][0];
				
				$stmt3->bindParam(":normal", $JS3_1, PDO::PARAM_STR);
				$stmt3->bindParam(":shiny", $JS3_2, PDO::PARAM_STR);
				
				$stmt3->execute();
			}
		}
		
		if (isset($_POST['load']))
		{
			$enlist = $resultaat[1];
			$enslist = $resultaat[2];
			
			$list = JSON_decode('['.$enlist.']');
			$slist = JSON_decode('['.$enslist.']');
		}
	}
}

$totalNormal = 0;
$totalNotNormal = 0;
$totalShiny = 0;
$totalNotShiny = 0;

foreach ($list as $pokemon)
	($pokemon == true ? $totalNormal++ : $totalNotNormal++);

foreach ($slist as $pokemon)
	($pokemon == true ? $totalShiny++ : $totalNotShiny++);
?>

<form action="dex.php" method="post">
	<input type="hidden" id="load" name="load" value="true">
	<input type="submit" value="Load">
</form>

<form action="dex.php" method="post">
	<input type="hidden" id="list" name="list[]" value="">
	<input type="hidden" id="slist" name="slist[]" value="">
	<input type="submit" value="Update">
</form>

<?php
print('<p class="left">Pokémon: '.$totalNormal);
print('<br>Pokémon nodig: '.$totalNotNormal.'</p>');
print('<p class="right">Shiny Pokémon: '.$totalShiny);
print('<br>Shiny Pokémon nodig: '.$totalNotShiny.'</p>');
?>

<br>
<br>
<br>
<br>
<br>

<style>
.stripe-through {
	text-decoration: line-through;
}
</style>

<p>Todo:</p>
<ul>
	<li class="stripe-through">Make a repo for this</li>
	<li class="stripe-through">Add page for unboxable pokemon (merge with special)</li>
	<li class="stripe-through">Add BDSP Manaphy Egg</li>
	<li class="stripe-through">Move Furfrou forms (Normal + Shiny) and Sky Shaymin out of unboxable</li>
	<li class="stripe-through">Add new Pokémon (Legends Arceus)</li>
	<li class="stripe-through">Add new Pokémon (SV)</li>
	<li>Add new Pokémon (SV Teal Mask)</li>
</ul>

<?php
function Box($start, $shiny)
{
	$current = $start;
	
	if (!$shiny)
		print('<tr><th colspan="6">Box '.ceil($start / 30).'</th></tr>');
	else
		print('<tr><th colspan="6">Shiny Box '.ceil($start / 30).'</th></tr>');

	for ($i = 1; $i <= 5; $i++)
	{
		print('<tr>');
		
		for ($j = 1; $j <= 6; $j++)
		{
			if (!$shiny)
			{
				if ($current > NUM_NORMAL_POKEMON)
					print('<td><img src="images/0.png"></td>');
				else
					print('<td><img onclick="change(event)" id="poke'.$current.'" src="images/normal/'.$current.'.png"></td>');
			}
			else
			{
				if ($current > NUM_SHINY_POKEMON)
					print('<td><img src="images/0.png"></td>');
				else
					print('<td><img onclick="changeS(event)" id="shiny'.$current.'" src="images/shiny/'.$current.'.png"></td>');
			}
			
			$current++;
		}
		
		print('</tr>');
	}
}

print('<table class="normal">');

for ($i = 1; $i <= NUM_NORMAL_POKEMON; $i += 30)
	Box($i, false);

print('</table>');

print('<table class="shiny">');

for ($i = 1; $i <= NUM_SHINY_POKEMON; $i += 30)
	Box($i, true);

print('</table>');
print('');
?>
<p id="test69"></p>
<script>
var LockList = <?php echo JSON_encode($lockList[TYPE_SHINY]); ?>;
var NormalLockList = <?php echo JSON_encode($lockList[TYPE_NORMAL]); ?>;
var OtLockList = <?php echo JSON_encode($otLockList[TYPE_NORMAL]); ?>;
var ShinyOtLockList = <?php echo JSON_encode($otLockList[TYPE_SHINY]); ?>;

var List = <?php echo JSON_encode($list); ?>;
var ShinyList = <?php echo JSON_encode($slist); ?>;

for (var i = 0; i < <?php echo NUM_NORMAL_POKEMON; ?>; i++)
{
	var pokeID = "poke" + (i + 1);
	if (!NormalLockList.includes(i + 1))
	{
		if (!OtLockList.includes(i + 1))
		{
			document.getElementById(pokeID).className = List[i];
		}
		else
		{
			document.getElementById(pokeID).className = List[i] + "Ot";
		}
	}
	else
	{
		document.getElementById(pokeID).className = "lock";
	}
}

for (var i = 0; i < <?php echo NUM_SHINY_POKEMON; ?>; i++)
{
	var pokeID = "shiny" + (i + 1);
	
	if (LockList.includes(i + 1))
		document.getElementById(pokeID).className = "lock";
	else if (!ShinyOtLockList.includes(i + 1))
		document.getElementById(pokeID).className = ShinyList[i];
	else
		document.getElementById(pokeID).className = ShinyList[i] + "Ot";
}

function change(e)
{
	var NormalLockList = <?php echo JSON_encode($lockList[TYPE_NORMAL]); ?>;
	var OtLockList = <?php echo JSON_encode($otLockList[TYPE_NORMAL]); ?>;
	
	var element = e.target;
	var lid = element.id.substr(4);
	
	if (NormalLockList.includes(parseInt(lid)))
	{
		element.className = "lock";
		List[lid - 1] = false;
	}
	else if (OtLockList.includes(parseInt(lid)))
	{
		if (element.className == "falseOt")
		{
			element.className = "trueOt";
			List[lid - 1] = true;
		}
		else
		{
			element.className = "falseOt";
			List[lid - 1] = false;
		}
	}
	else
	{
		if (element.className == "false")
		{
			element.className = "true";
			List[lid - 1] = true;
		}
		else
		{
			element.className = "false";
			List[lid - 1] = false;
		}
	}
	
	document.getElementById("list").setAttribute("value", List);
}

function changeS(e)
{
	var LockList = <?php echo JSON_encode($lockList[TYPE_SHINY]); ?>;
	var ShinyOtLockList = <?php echo JSON_encode($otLockList[TYPE_SHINY]); ?>;
	
	var element = e.target;
	var slid = element.id.substr(5);
	
	if (LockList.includes(parseInt(slid)))
	{
		element.className = "lock";
		ShinyList[slid - 1] = false;
	}
	else if (ShinyOtLockList.includes(parseInt(slid)))
	{
		if (element.className == "falseOt")
		{
			element.className = "trueOt";
			ShinyList[slid - 1] = true;
		}
		else
		{
			element.className = "falseOt";
			ShinyList[slid - 1] = false;
		}
	}
	else
	{
		if (element.className == "false")
		{
			element.className = "true";
			ShinyList[slid - 1] = true;
		}
		else
		{
			element.className = "false";
			ShinyList[slid - 1] = false;
		}
	}
	
	document.getElementById("slist").setAttribute("value", ShinyList);
}

document.getElementById("list").setAttribute("value", List);
document.getElementById("slist").setAttribute("value", ShinyList);
</script>
</body>
</html>
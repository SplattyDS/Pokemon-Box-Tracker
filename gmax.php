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

for ($i = count($list); $i < NUM_GMAX_POKEMON; $i++)
	array_push($list, false);

for ($i = count($slist); $i < NUM_SHINY_GMAX_POKEMON; $i++)
	array_push($slist, false);

if ($_SESSION['LOGIN_OK'])
{
	$sql1 = 'SELECT Username, NormalGmaxData, ShinyGmaxData FROM users WHERE Id = '.$_SESSION['Id'];
	$sql2 = 'UPDATE users SET NormalGmaxData = :normal, ShinyGmaxData = :shiny WHERE Id = '.$_SESSION['Id'];
	$sql3 = 'UPDATE users SET NormalGmaxData = :normal, ShinyGmaxData = :shiny WHERE Id = '.$_SESSION['Id'];
	
	$results1 = $dbh->query($sql1);
	
	foreach ($results1 as $resultaat)
	{
		if ($resultaat['NormalGmaxData'] == null || $resultaat['ShinyGmaxData'] == null)
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

<form action="gmax.php" method="post">
	<input type="hidden" id="load" name="load" value="true">
	<input type="submit" value="Load">
</form>

<form action="gmax.php" method="post">
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

<?php
function Box($start, $shiny)
{
	$current = $start;
	
	$boxNum = ceil($start / 30);
	
	if (!$shiny)
		print('<tr onclick="batchChange(event)" id="boxTitle'.$boxNum.'"><th colspan="6">Gigantamax Box '.$boxNum.'</th></tr>');
	else
		print('<tr onclick="batchChangeS(event)" id="boxTitleS'.$boxNum.'"><th colspan="6">Shiny Gigantamax Box '.$boxNum.'</th></tr>');

	for ($i = 1; $i <= 5; $i++)
	{
		print('<tr>');
		
		for ($j = 1; $j <= 6; $j++)
		{
			if (!$shiny)
			{
				if ($current > NUM_GMAX_POKEMON)
					print('<td><img src="images/0.png"></td>');
				else
					print('<td><img onclick="change(event)" id="poke'.$current.'" src="images/normal_gmax/'.$current.'.png"></td>');
			}
			else
			{
				if ($current > NUM_SHINY_GMAX_POKEMON)
					print('<td><img src="images/0.png"></td>');
				else
					print('<td><img onclick="changeS(event)" id="shiny'.$current.'" src="images/shiny_gmax/'.$current.'.png"></td>');
			}
			
			$current++;
		}
		
		print('</tr>');
	}
}

print('<table class="normal">');

for ($i = 1; $i <= NUM_GMAX_POKEMON; $i += 30)
	Box($i, false);

print('</table>');

print('<table class="shiny">');

for ($i = 1; $i <= NUM_SHINY_GMAX_POKEMON; $i += 30)
	Box($i, true);

print('</table>');
print('');
?>
<p id="test69"></p>
<script>
var LockList = <?php echo JSON_encode($lockList[TYPE_SHINY_GMAX]); ?>;
var NormalLockList = <?php echo JSON_encode($lockList[TYPE_GMAX]); ?>;
var OtLockList = <?php echo JSON_encode($otLockList[TYPE_GMAX]); ?>;
var ShinyOtLockList = <?php echo JSON_encode($otLockList[TYPE_SHINY_GMAX]); ?>;

var List = <?php echo JSON_encode($list); ?>;
var ShinyList = <?php echo JSON_encode($slist); ?>;

for (var i = 0; i < <?php echo NUM_GMAX_POKEMON; ?>; i++)
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

for (var i = 0; i < <?php echo NUM_SHINY_GMAX_POKEMON; ?>; i++)
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
	doChange(e.target);
}

function changeS(e)
{
	doChangeS(e.target);
}

function batchChange(e)
{
	doBatchChange(e.target);
}

function batchChangeS(e)
{
	doBatchChangeS(e.target);
}

function doChange(element)
{
	var NormalLockList = <?php echo JSON_encode($lockList[TYPE_GMAX]); ?>;
	var OtLockList = <?php echo JSON_encode($otLockList[TYPE_GMAX]); ?>;
	
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

function doChangeS(element)
{
	var LockList = <?php echo JSON_encode($lockList[TYPE_SHINY_GMAX]); ?>;
	var ShinyOtLockList = <?php echo JSON_encode($otLockList[TYPE_SHINY_GMAX]); ?>;
	
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

function doBatchChange(e)
{
	var boxNum = parseInt(e.parentElement.id.substr(8));
	// console.log(boxNum);
	
	var table = e.parentElement.parentElement;
	// console.log(table.children);
	
	var startRowID = (boxNum - 1) * 5 + boxNum;
	
	for (var i = startRowID; i < startRowID + 5; i++)
	{
		var row = table.children[i];
		// console.log(row);
		
		for (var j = 0; j < 6; j++)
		{
			// console.log(row.children[j].firstChild);
			doChange(row.children[j].firstChild);
		}
	}
}

function doBatchChangeS(e)
{
	var boxNum = parseInt(e.parentElement.id.substr(9));
	// console.log(boxNum);
	
	var table = e.parentElement.parentElement;
	// console.log(table.children);
	
	var startRowID = (boxNum - 1) * 5 + boxNum;
	
	for (var i = startRowID; i < startRowID + 5; i++)
	{
		var row = table.children[i];
		// console.log(row);
		
		for (var j = 0; j < 6; j++)
		{
			// console.log(row.children[j].firstChild);
			doChangeS(row.children[j].firstChild);
		}
	}
}

document.getElementById("list").setAttribute("value", List);
document.getElementById("slist").setAttribute("value", ShinyList);
</script>
</body>
</html>
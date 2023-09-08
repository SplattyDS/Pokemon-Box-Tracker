<?php
require('config.php');
require('includes/navbar.php');
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>SWSH Dex Cut</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<h1>SWSH Dex Cut</h1>
<hr>

<?php
$dexLimit = 1211;

//Gen 1
$cutList = array(15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,71,72,73,74,86,87,101,102,103,106,107,108,109,110,111,124,125,126,127,128,129,130,131,132,133,140,141,142,145,146);

//Gen 2
array_push($cutList, 212,213,214,215,216,217,218,219,220,221,222,223,226,227,228,229,230,231,243,244,245,253,254,255,256,257,258,259,260,267,268,271);

for ($i = 272; $i <= 299; $i++) //Unown
{
    array_push($cutList, $i);
}

array_push($cutList, 302,303,304,305,307,308,311,312,321,322,323,324,325,337,338,339,341,342,343,345,346);

//Gen 3
array_push($cutList, 375,376,381,382,383,384,385,386,387,397,398,404,405,406,407,408,409,410,417,418,420,421,422,428,429,430,431,434,435,436,437,440,441,442,443,448,449,450,451,453,454,455,459,460,461,464,465,481,482,483,484,487,488,496,497,498,501,517,518,519,520);

//Gen 4
for ($i = 521; $i <= 543; $i++) //Starters + Begin Route Pokes
{
    array_push($cutList, $i);
}

for ($i = 553; $i <= 563; $i++) //Fossils + Burmy line
{
    array_push($cutList, $i);
}

array_push($cutList, 567,568,569,570,571,572,579,580,585,586,587,588,589,597,618,619,620,621,622,639,642,647,665,666,667,668,669);

//Gen 5
for ($i = 671; $i <= 681; $i++) //Starters + Patrat line
{
    array_push($cutList, $i);
}

array_push($cutList, 687,688,689,670,671,672,699,670,717,718,719,761,762);

for ($i = 766; $i <= 773; $i++) //Deerling line
{
    array_push($cutList, $i);
}

array_push($cutList, 783,791,792,793,842);

//Gen 6
for ($i = 844; $i <= 852; $i++) //Starters
{
    array_push($cutList, $i);
}

for ($i = 858; $i <= 899; $i++) //Scatterbug line + Pyroar line + Flabébé line + Skiddo line
{
    array_push($cutList, $i);
}

array_push($cutList, 902,954,955);

//Gen 7
array_push($cutList, 966,967,968,969,970,974,975,976,977,978,979);

for ($i = 1014; $i <= 1021; $i++) //Minior + Komala
{
    array_push($cutList, $i);
}

array_push($cutList, 1025);

$box = 1;

for ($i = 1; $i <= $dexLimit; $i = $i + 30)
{
    $count = $i + 1;

    print('<table><tr><th colspan="6">Box '.$box.'</th></tr>');
	for ($j = 0; $j < 5; $j++)
    {
        print('<tr>');
        for ($k = 0; $k < 6; $k++)
        {
			if ($count > $dexLimit)
			{
				print('<td class="none"><img src="images/0.png"></td>');
			}
			else
			{
				print('<td class="'.(in_array($count, $cutList) ? 'false' : 'true').'"><img src="images/'.$count.'.png"></td>');
			}
			$count++;
        }
        print('</tr>');
    }
    print('</table>');
	$box++;
}
?>
</body>
</html>
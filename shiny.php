<style>
img {
	width: 150px;
}
</style>
<?php
print('<table>');

for ($i = 0; $i < 1356; $i++)
{
	print('<tr>');
	
	if ($i == 0)
	{
		print('<td colspan="2"><img src="images/'.$i.'.png"></td>');
	}
	elseif ($i == 42 || $i == 43 || $i == 44 || $i == 45 || $i == 46 || $i == 47 || $i == 48)
	{
		print('<td><img src="images/'.$i.'.png"></td><td></td>');
	}
	elseif ($i == 284 || $i == 286 || $i == 589 || $i == 591 || $i == 624 || $i == 626 || $i == 628 || $i == 630)
	{
		print('<td><img src="images/'.($i + 1).'.png"><img src="images/'.$i.'.png"></td>');
		print('<td><img src="Shiny/'.($i + 1).'.png"><img src="Shiny/'.$i.'.png"></td>');
	}
	elseif ($i == 285 || $i == 287 || $i == 590 || $i == 592 || $i == 625 || $i == 627 || $i == 629 || $i == 631)
	{
		
	}
	else
	{
		print('<td><img src="images/'.$i.'.png"></td>');
		print('<td><img src="Shiny/'.$i.'.png"></td>');
	}
	
	print('</tr>');
}

print('</table>');
?>
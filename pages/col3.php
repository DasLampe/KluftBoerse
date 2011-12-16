<h1>Infos</h1>
<h2>Einnahmen</h2>
<table >
	<tr>
		<td>Letztes Jahr</td>
		<td align="right"><?= invoice::get_gain_last_time(mktime(0, 0, 0, 1, 1, date('Y')-1), mktime(23, 59, 59, 12, 31, date('Y')-1));?> €</td>
	</tr>
	<tr>
		<td>Letzten 4 Wochen</td>
		<td align="right"><?= invoice::get_gain_last_time(mktime() - 30*3600*24, mktime());?> €</td>
	</tr>
	<tr>
		<td>Letzte Woche</td>
		<td align="right"><?= invoice::get_gain_last_time(mktime(0, 0, 0, date('n'), date('j')-6, date('Y')) - ((date('N'))*3600*24), mktime(23, 59, 59, date('n'), date('j'), date('Y')) - ((date('N'))*3600*24));?> €</td>
	</tr>
	<tr>
		<td>Dieses Jahr</td>
		<td align="right"><?= invoice::get_gain_last_time(mktime(0, 0, 0, 1, 1, date('Y')), time()); ?> €</td>
	</tr>
</table>
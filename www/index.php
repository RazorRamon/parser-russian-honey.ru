<?php

set_time_limit(0);
include 'simple_html_dom.php';

// Функция, удаляющая из строки всё после встречи с определённым символом
function delete44($str,$symbol='') 
{ 
    return($strpos=mb_strpos($str,$symbol))!==false?mb_substr($str,0,$strpos,'utf8'):$str;
}

// Create DOM from URL or file
$html = file_get_html('http://www.medolubov.ru/prays-list/');
$count = 0;

echo '<table class="price2" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="first"><strong>Наименование товаров</strong></th>
				<th><br /></th>
				<th><strong>Цена</strong></th>
			</tr>
		</thead> 
		<tbody>';
echo '<tr class="title"><td class="first" colspan="3"><strong>МЁД НАТУРАЛЬНЫЙ ВЕСОВОЙ В АССОРТИМЕНТЕ</strong></td></tr>';

foreach($html->find('//table.prays-list/tbody/tr/') as $element_price)
{
	foreach($element_price->find('//td.level/') as $element_mane)
	{
		$element_mane = iconv('UTF-8', 'CP1251', $element_mane);
		echo '<tr class="title"><td class="first" colspan="3" style="text-align: left;"><strong>' . strip_tags($element_mane) . '</strong></td></tr>';
	}
	
	if($count%2 == 0){
		echo '<tr class="next">';
	} else {
		echo '<tr>';
	}
	
	foreach($element_price->find('//a.link_for_export/') as $element_link)
	{
		// Перевод кодировки информации элемента массива $massiv_name[$count] из CP1251 в UTF-8
		$element_link = 'http://www.medolubov.ru' . $element_link->href;
		$element_link = iconv('UTF-8', 'CP1251', $element_link);
		$massiv_link[$count] = $element_link;
	}
	
	foreach($element_price->find('//td.name_item/') as $element_name)
	{
		// Перевод кодировки информации элемента массива $massiv_name[$count] из CP1251 в UTF-8
		$element_name = iconv('UTF-8', 'CP1251', $element_name);
		if (in_array($element_name, $massiv_name)){
			// совпадение
		} else {
			$massiv_name[$count] = $element_name;
			echo '<td class="first"><a href="' . $massiv_link[$count] .'">' . strip_tags($massiv_name[$count]) . '</a></td><td class="melkopt"></td>';
		}
	}

	foreach($element_price->find('//td.right/') as $element_tsena)
	{
		$element_tsena = iconv('UTF-8', 'CP1251', $element_tsena);
		echo '<td>' . strip_tags($element_tsena) . '</td>';
		
		$count++;
		//echo $count ;
	}
	echo '</tr>';
}
echo '</tbody></table><p>&nbsp;</p>';

?>
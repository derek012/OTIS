<?php

//for loops thtough the cells in sheet 1 to find the given name
function getCol($name)
{
	$r = 1;
	$c = 2;
	$cellVal = getCell($r, $c, 1);
	while ($cellVal != $name)
	{
		if (empty($cellVal))
		{
			return "error";
		}
		$c++;
		$cellVal = getCell($r, $c, 1);
		//echo $c;
	}
	return $c;
}

// for loops thtough the rows in sheet 1 to find the given name
//
function getRow($name)
{
	$r = 2;
	$c = 1;
	$cellVal = getCell($r, $c, 1);
	while ($cellVal != $name)
	{
		if (empty($cellVal))
		{
			return "error";
		}
		$r++;
		$cellVal = getCell($r, $c, 1);
		//echo $c;
	}
	return $r;
}

//Does exactly what it says,
//Gets the cell specified from sheet num
function getCell($r, $c, $sheetnum)
{
	//$ssid = "0AnhvV5acDaAvdGVrdmFpWkpNbnVYdXZUeFRwSHE0SkE";
    $ssid = "0AtfdiGhuBtR4dENyNVZGV25RbkZoTmlLNXVERFd1LVE";
	$baseurl = "http://spreadsheets.google.com/feeds/cells/";
	$spreadsheet = $ssid . "/";
	$sheetID = $sheetnum . "/";
	$vis = "public/";
	$proj = "basic/";
	//$cell = "R3C2";
	$cell = "R" . $r . "C" . $c;

	$url = $baseurl . $spreadsheet . $sheetID . $vis . $proj . $cell . "";

	$xml = file_get_contents($url);

	//Sometimes the data is not xml formatted,
	//so lets try to remove the url, from the xml not formatted
	$urlLen = strlen($url);
	$xmlWOurl = substr($xml, $urlLen);

	//then find the Z (in the datestamp, assuming its always there)
	$posZ = strrpos($xmlWOurl, "Z");
	//then substr from z2end
	$data = substr($xmlWOurl, $posZ + 1);

	//if the result has more than ten characters then something went wrong
	if (strlen($data) > 10)
	{
		//Asuming we have xml
		$datapos = strrpos($xml, "<content type='text'>");
		$datapos += 21;
		$datawj = substr($xml, $datapos);
		$endcont = strpos($datawj, "</content>");
		return substr($datawj, 0, $endcont);
	}
	else
		return $data;
}

function getHours($name, $sheet)
{
	$r = 1;
	$c = 2;
	$curCell = getCell("R" . $r . "C" . $c, $sheet);
	$count = 0;
	//echo $curCell;

	while ($count < 25)
	{
		//echo "'".$curCell. "' " .$name." ".$count." ".empty($curCell). "<br/>\n";
		$count++;
		if ($curCell === $name)
		{
			return getCell("R" . "3" . "C" . $c, $sheet); //This is the value of the cell
		} else
		{
			$c++;
			$curCell = getCell("R" . $r . "C" . $c, $sheet);
		}
	}
	return "not found";
}

/* This function takes two arrays returned from two DB queries and
 * merges them together into one array.
 *
 * @param1 $ar1 first array
 * @param2 $ar2 second array
 * @return array
 */

function mergeDBqry($ar1, $ar2 = null)
{
	$out = array();
	foreach ($ar1 as $row)
	{
		foreach ($row as $key => $value)
		{
			$out[$key] = $value;
		}
	}
	if (isset($ar2))
	{
		foreach ($ar2 as $row)
		{
			foreach ($row as $key => $value)
			{
				$out[$key] = $value;
			}
		}
	}
	return $out;
}

?>
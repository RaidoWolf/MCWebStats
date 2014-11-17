<?php

/*
 *  MCWebStats Unit Handling Functions
 *
 *  FUNCTION LIST:
 *
 *  str distance_fancify (double $inputDistance, [str $inputUnit="cm", bool $imperial=false])
 *  	Convert the value of a specific input unit to another value of an appropriate output value with an appended unit suffix.
 *  	The returned value is not useable in mathematic operations without stripping the unit suffix.
 *
 */

function distance_fancify ($inputDistance, $inputUnit="cm", $imperial=false)
{
	$inputUnit = strtolower($inputUnit);
	if ($inputUnit == "cm")
	{
		$thisAsKm = ($inputDistance / 100000);
		$thisAsM = ($inputDistance / 100);
		$thisAsMi = ($inputDistance / 160934);
		$thisAsFt = ($inputDistance / 30.48);
		$thisAsIn = ($inputDistance / 2.54);
		if ($imperial == true)
		{
			if ($thisAsMi >= 1)
			{
				return round($thisAsMi,4)."mi";
			}
			else
			{
				if ($thisAsFt >= 1)
				{
					return round($thisAsFt,2)."ft";
				}
				else
				{
					return round($thisAsIn,0)."in";
				}
			}
		}
		elseif ($imperial == false)
		{
			if ($thisAsKm >= 1)
			{
				return round($thisAsKm,4)."km";
			}
			else
			{
				if ($thisAsM >= 1)
				{
					return round($thisAsM,2)."m";
				}
				else
				{
					return round($inputDistance,0)."cm";
				}
			}
		}
		else
		{
			$imperialDataType = gettype($imperial);
			trigger_error("function distance_fancify expected third parameter to be boolean, got $imperialDataType", E_USER_WARNING);
			return null;
		}
	}
	elseif ($inputUnit == "m")
	{
		$thisAsKm = ($inputDistance / 1000);
		$thisAsCm = ($inputDistance * 100);
		$thisAsMi = ($inputDistance / 1609.34);
		$thisAsFt = ($inputDistance * 3.28);
		$thisAsIn = ($inputDistance * 39.37);
		if ($imperial == true)
		{
			if ($thisAsMi >= 1)
			{
				return round($thisAsMi,4)."mi";
			}
			else
			{
				if ($thisAsFt >= 1)
				{
					return round($thisAsFt,2)."ft";
				}
				else
				{
					return round($thisAsIn,0)."in";
				}
			}
		}
		elseif ($imperial == false)
		{
			if ($thisAsKm >= 1)
			{
				return $thisAsKm."km";
			}
			else
			{
				if ($thisAsM >= 1)
				{
					return $inputDistance."m";
				}
				else
				{
					return $thisAsCm."cm";
				}
			}
		}
		else
		{
			$imperialDataType = gettype($imperial);
			trigger_error("function distance_fancify expected third parameter to be boolean, got $imperialDataType", E_USER_WARNING);
			return null;
		}
	}
	elseif ($inputUnit == "km")
	{
		$thisAsM = ($inputDistance * 1000);
		$thisAsCm = ($inputDistance * 100000);
		$thisAsMi = ($inputDistance / 1.60934);
		$thisAsFt = ($inputDistance * 3280.84);
		$thisAsIn = ($inputDistance * 39370.08);
		if ($imperial == true)
		{
			if ($thisAsMi >= 1)
			{
				return round($thisAsMi,4)."mi";
			}
			else
			{
				if ($thisAsFt >= 1)
				{
					return round($thisAsFt,2)."ft";
				}
				else
				{
					return round($thisAsIn,0)."in";
				}
			}
		}
		elseif ($imperial == false)
		{
			if ($inputDistance >= 1)
			{
				return round($inputDistance,4)."km";
			}
			else
			{
				if ($thisAsM >= 1)
				{
					return round($thisAsM,2)."m";
				}
				else
				{
					return round($thisAsCm,0)."cm";
				}
			}
		}
		else
		{
			$imperialDataType = gettype($imperial);
			trigger_error("function distance_fancify expected third parameter to be boolean, got $imperialDataType", E_USER_WARNING);
			return null;
		}
	}
	else
	{
		trigger_error("function distance_fancify expected second parameter to be a valid unit", E_USER_WARNING);
		return null;
	}
}

?>

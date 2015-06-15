<?php

	/*
	 *	The MIT License (MIT)
	 *
	 *	Copyright (c) 2015 Ben Poulson <ben@terravita.co.uk>
	 *
	 *	Permission is hereby granted, free of charge, to any person obtaining a copy
	 *	of this software and associated documentation files (the "Software"), to deal
	 *	in the Software without restriction, including without limitation the rights
	 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	 *	copies of the Software, and to permit persons to whom the Software is
	 *	furnished to do so, subject to the following conditions:
	 *
	 *	The above copyright notice and this permission notice shall be included in all
	 *	copies or substantial portions of the Software.
	 *
	 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	 *	SOFTWARE.
	 *
	 */

	function convexHull($points)
	{
		/* Ensure point doesn't rotate the incorrect direction as we process the hull halves */
		$cross = function($o, $a, $b) {
			return ($a[0] - $o[0]) * ($b[1] - $o[1]) - ($a[1] - $o[1]) * ($b[0] - $o[0]);
		};

 		$pointCount = count($points);
 		sort($points);
		if ($pointCount > 1) {

			$n = $pointCount;
			$k = 0;
			$h = array();
 
			/* Build lower portion of hull */
			for ($i = 0; $i < $n; ++$i) {
				while ($k >= 2 && $cross($h[$k - 2], $h[$k - 1], $points[$i]) <= 0)
					$k--;
				$h[$k++] = $points[$i];
			}
 
			/* Build upper portion of hull */
			for ($i = $n - 2, $t = $k + 1; $i >= 0; $i--) {
				while ($k >= $t && $cross($h[$k - 2], $h[$k - 1], $points[$i]) <= 0)
					$k--;
				$h[$k++] = $points[$i];
			}

			/* Remove all vertices after k as they are inside of the hull */
			if ($k > 1) {

				/* If you don't require a self closing polygon, change $k below to $k-1 */
				$h = array_splice($h, 0, $k); 
			}

			return $h;

		}
		else if ($pointCount <= 1)
		{
			return $points;
		}
		else
		{
			return null;
		}
	}

?>

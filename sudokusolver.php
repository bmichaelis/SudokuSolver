<?php

class SudokuSolver
{
	var $board;
	var $statusboard;
	
	function __construct() 
	{

	}

	public function play($board)
	{		
		$this->display($board);
		if($this->solve($board))
		{
			echo "Found a solution!\n";
			$this->display($this->board);
		}
		else
		{
			echo "No solution found.\n";
		}
	}
	
	private function display($board = array())
	{
		for($i = 0; $i < 9; $i++)
		{
			for($j = 0; $j < 9; $j++)
			{
				echo $board[$i][$j] . "  ";
			}
			echo "\n";
		}
	}
	
	private function solve($board = array())
	{
		$this->statusboard = array();
		$this->board = $board;
		for($i = 0; $i < 9; $i++)
		{
			for($j = 0; $j < 9; $j++)
			{
				$this->statusboard[$i][$j] = $this->board[$i][$j] > 0 ? 2 : 0;
			}
		}
		return $this->solveStep(0, 0);
	}
	
	private function solveStep($x, $y)
	{
		if($x == 9)
		{
			$count = 0;
			for($i = 0; $i < 9; $i++)
			{
				for($j = 0; $j < 9; $j++)
				{
					$count += $this->statusboard[$i][$j] > 0 ? 1 : 0;
				}
			}
			if($count == 81)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		if($this->statusboard[$x][$y] >= 1) 
		{
			$nextX = $x;
			$nextY = $y + 1;
			if($nextY == 9)
			{
				$nextX = $x + 1;
				$nextY = 0;
			}
			return $this->solveStep($nextX, $nextY);
		}
		else
		{
			$used = array(0,0,0,0,0,0,0,0,0);
			for($i = 0; $i < 9; $i++)
			{
				if($this->statusboard[$x][$i] >= 1)
				{
					$used[$this->board[$x][$i]-1] = true;
				}
			}
			
			for($i = 0; $i < 9; $i++)
			{
				if($this->statusboard[$i][$y] >= 1)
				{
					$used[$this->board[$i][$y]-1] = true;
				}
			}
			
			for($i = $x - ($x %3); $i < $x - ($x % 3) + 3; $i++)
			{
				for($j = $y - ($y %3); $j < $y - ($y % 3) + 3; $j++)
				{
					if($this->statusboard[$i][$j] >= 1)
					{
						$used[$this->board[$i][$j]-1] = true;
					}
				}
			}
			for($i = 0; $i < count($used); $i++)
			{
				if(!$used[$i])
				{
					$this->statusboard[$x][$y] = 1;	
					$this->board[$x][$y] = $i + 1;	
					
					$nextX = $x;
					$nextY = $y + 1;
					if($nextY == 9)
					{
						$nextX = $x + 1;
						$nextY = 0;
					}

					if($this->solveStep($nextX, $nextY))
					{
						return true;
					}

					for($m = 0; $m < 9; $m++)
					{
						for($n = 0; $n < 9; $n++)
						{
							if($m > $x || ($m == $x && $n >= $y))
							{
								if($this->statusboard[$m][$n] == 1)
								{
									$this->statusboard[$m][$n] = 0;
									$this->board[$m][$n] = 0;
								}
							}
						}
					}
				}		
			}
		}
		return false;
	}
}

$ss = new SudokuSolver();
$board = array(
				array(0,0,0, 0,0,0, 0,0,0,),
				array(0,0,0, 0,0,0, 0,0,0,),
				array(0,0,0, 0,0,0, 0,0,0,),
				
				array(0,0,0, 0,0,0, 0,0,0,),
				array(0,0,0, 0,0,0, 0,0,0,),
				array(0,0,0, 0,0,0, 0,0,0,),
				
				array(0,0,0, 0,0,0, 0,0,0,),
				array(0,0,0, 0,0,0, 0,0,0,),
				array(0,0,0, 0,0,0, 0,0,0,),
);

$ss->play($board);
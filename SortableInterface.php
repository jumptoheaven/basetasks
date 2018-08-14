<?php

interface SortableInterface
{
	public function sort(
		array $a,
		$descendDirect = false
	): array;
}

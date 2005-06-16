<?php
/***************************************************************************
 *   Copyright (C) 2004-2005 by Konstantin V. Arkhipov                     *
 *   voxus@gentoo.org                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	class PrimitiveDate extends ComplexPrimitive
	{
		const DAY		= 'day';
		const MONTH		= 'month';
		const YEAR		= 'year';

		const HOURS		= 'hrs';
		const MINUTES	= 'min';
		const SECONDS	= 'sec';
		
		// typeHinting commented out due to stupid E_STRICT
		public function setValue(/* Timestamp */ $date)
		{
			if (!$date instanceof Timestamp)
				throw new WrongArgumentException();
			
			$this->value = $date;
			
			return $this;
		}
		
		public function setMin(/* Timestamp */ $stamp)
		{
			if (!$stamp instanceof Timestamp)
				throw new WrongArgumentException();

			$this->min = $stamp;
			
			return $this;
		}
		
		public function setMax(/* Timestamp */ $stamp)
		{
			if (!$stamp instanceof Timestamp)
				throw new WrongArgumentException();
			
			$this->max = $stamp;
			
			return $this;
		}
		
		public function setDefault(/* Timestamp */ $stamp)
		{
			if (!$stamp instanceof Timestamp)
				throw new WrongArgumentException();
			
			$this->default = $stamp;
			
			return $this;
		}
		
		public function importSingle(&$scope)
		{
			if (isset($scope[$this->name]) &&
				is_string($scope[$this->name]) &&
				$time = strftime($scope[$this->name])
			) {
				$this->value = new Timestamp($time);
				return true;
			}
			
			return false;
		}

		public function isEmpty(&$scope)
		{
			if ($this->getState()->isFalse()) {
				return 
					empty($scope[$this->name][self::DAY])
					|| empty($scope[$this->name][self::MONTH])
					|| empty($scope[$this->name][self::YEAR]);
			} else 
				return empty($scope[$this->name]);
		}
		
		public function importMarried(&$scope)
		{
			if (
				isset(
					$scope[$this->name][self::DAY], 
					$scope[$this->name][self::MONTH], 
					$scope[$this->name][self::YEAR]
				)
				&& !empty($scope[$this->name][self::DAY])
				&& !empty($scope[$this->name][self::MONTH])
				&& !empty($scope[$this->name][self::YEAR])
			) {
				$hours = $minutes = 0;
				
				if (isset($scope[$this->name][self::HOURS]))
					$hours = (int) $scope[$this->name][self::HOURS];

				if (isset($scope[$this->name][self::MINUTES]))
					$minutes = (int) $scope[$this->name][self::MINUTES];

				try {
					$stamp = mktime(
						$hours, $minutes, 0,
						$scope[$this->name][self::MONTH],
						$scope[$this->name][self::DAY],
						(int) $scope[$this->name][self::YEAR]
					);
				} catch (BaseException $e) {
					// fsck wrong stamps
					return false;
				}

				if (!($this->min && $this->min->toStamp() < $stamp) &&
					!($this->max && $this->max->toStamp() > $stamp)
				) {
					$this->value = new Timestamp($stamp);

					return true;
				}
			}

			return false;
		}
		
		public function import(&$scope)
		{
			if ($this->isEmpty($scope))
				return null;

			return parent::import($scope);
		}
	}
?>
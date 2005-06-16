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

	class ArrayUtils
	{
		public static function convertObjectList(&$list = null)
		{
			$out = array();

			if (!$list)
				return $out;
				
			foreach ($list as &$obj)
				$out[$obj->getId()] = $obj;

			return $out;
		}
		
		public static function getIdsArray($objectsList)
		{
			$out = array();
			
			foreach ($objectsList as $object)
				if ($object instanceof Identifiable)
					$out[] = $object->getId();
				else
					throw new WrongArgumentException('only identifiable lists accepted');

			return $out;
		}
		
		public static function convertToPlainList($list, $key)
		{
			$out = array();
			
			foreach ($list as $obj)
				$out[] = $obj[$key];

			return $out;
		}
		
		public static function getArrayVar(&$array, $var)
		{
			if (isset($array[$var]) && !empty($array[$var]))
				return $array[$var];
			else
				return null;
		}
	}
?>

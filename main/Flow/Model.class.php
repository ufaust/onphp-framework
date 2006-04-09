<?php
/***************************************************************************
 *   Copyright (C) 2006 by Anton E. Lebedevich                             *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @ingroup Flow
	**/
	class Model implements Creatable
	{
		private $vars = array();
		
		public static function create()
		{
			return new self;
		}
		
		public function clean()
		{
			$this->vars = array();
			
			return $this;
		}
		
		public function isEmpty()
		{
			return ($this->vars === array());
		}
		
		public function getList()
		{
			return $this->vars;
		}
		
		public function set($name, $var)
		{
			$this->vars[$name] = $var;
			
			return $this;
		}
		
		public function get($name)
		{
			return $this->vars[$name];
		}
		
		public function has($name)
		{
			return isset($this->vars[$name]);
		}
		
		public function drop($name)
		{
			unset($this->vars[$name]);
			
			return $this;
		}
	}
?>
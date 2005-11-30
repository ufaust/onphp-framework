<?php
/***************************************************************************
 *   Copyright (C) 2005 by Konstantin V. Arkhipov                          *
 *   voxus@shadanakar.org                                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	abstract class BaseDaoWorker implements BaseDAO
	{
		const SUFFIX_LIST	= '_list_';
		const SUFFIX_INDEX	= '_lists_index';
		const SUFFIX_QUERY	= '_query_';
		const SUFFIX_RESULT	= '_result_';

		protected $dao = null;
		
		public function __construct(GenericDAO $dao)
		{
			$this->dao = $dao;
		}
		
		public function setDao(GenericDAO $dao)
		{
			$this->dao = $dao;
			
			return $this;
		}
		
		//@{
		// DAO proxy
		protected function getObjectName()
		{
			return $this->dao->getObjectName();
		}
		
		protected function getTable()
		{
			return $this->dao->getTable();
		}
		
		protected function makeSelectHead()
		{
			return $this->dao->makeSelectHead();
		}
		//@}
		
		//@{
		// cache getters
		public function getCachedById($id)
		{
			$className = $this->getObjectName();
			
			return Cache::me()->mark($className)->get($className.'_'.$id);
		}
		
		public function getCachedByQuery(Query $query)
		{
			$className = $this->getObjectName();
			
			return
				Cache::me()->mark($className)->
					get($className.self::SUFFIX_QUERY.$query->getId());
		}
		//@}
	}
?>
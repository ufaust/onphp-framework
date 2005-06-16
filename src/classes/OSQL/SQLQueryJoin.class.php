<?php
/***************************************************************************
 *   Copyright (C) 2005 by Anton Lebedevich                                *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	class SQLQueryJoin extends SQLBaseJoin
	{
		public function __construct(SelectQuery $query, LogicalObject $logic, $alias)
		{
			parent::__construct($query, $logic, $alias);
		}

		public function toString(DB $db)
		{
			return
				'JOIN ('.$this->subject->toString($db).') AS '.
				$db->quoteTable($this->alias).
				' ON '.$this->logic->toString($db);
		}

		public function getTable()
		{
			return $this->alias;
		}
	}
?>
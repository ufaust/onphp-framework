<?php
/***************************************************************************
 *   Copyright (C) 2007-2008 by Konstantin V. Arkhipov                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	/**
	 * MySQL DB connector.
	 * 
	 * @see http://www.mysql.com/
	 * @see http://www.php.net/mysqli
	 * 
	 * @ingroup DB
	**/
	final class MySQLim extends Sequenceless
	{
		/**
		 * @return MySQLim
		**/
		public function setDbEncoding()
		{
			mysqli_set_charset($this->link, $this->encoding);
			
			return $this;
		}

		/**
		 * @return MySQLim
		**/
		public function connect()
		{
			if ($this->persistent)
				throw new UnsupportedMethodException();
			
			$this->link = mysqli_init();
			
			try {
				mysqli_real_connect(
					$this->link,
					$this->hostname,
					$this->username,
					$this->password,
					$this->basename,
					$this->port,
					null,
					MYSQLI_CLIENT_FOUND_ROWS
				);
			} catch (BaseException $e) {
				throw new DatabaseException(
					'can not connect to MySQL server: '.$e->getMessage()
				);
			}
			
			if ($this->encoding)
				$this->setDbEncoding();
			
			return $this;
		}
		
		/**
		 * @return MySQLim
		**/
		public function disconnect()
		{
			if ($this->isConnected())
				mysqli_close($this->link);

			return $this;
		}
		
		public function isConnected()
		{
			return parent::isConnected() && mysqli_ping($this->link);
		}
		
		/**
		 * Same as query, but returns number of
		 * affected rows in insert/update queries
		**/
		public function queryCount(Query $query)
		{
			$this->queryNull($query);
			
			return mysqli_affected_rows($this->link);
		}
		
		public function queryRow(Query $query)
		{
			$res = $this->query($query);
			
			if ($this->checkSingle($res))
				return mysqli_fetch_assoc($res);
			else
				return null;
		}
		
		public function queryColumn(Query $query)
		{
			$res = $this->query($query);
			
			if ($res) {
				$array = array();

				while ($row = mysqli_fetch_row($res))
					$array[] = $row[0];

				return $array;
			} else
				return null;
		}
		
		public function querySet(Query $query)
		{
			$res = $this->query($query);
			
			if ($res) {
				$array = array();

				while ($row = mysqli_fetch_assoc($res))
					$array[] = $row;

				return $array;
			} else
				return null;
		}
		
		public function queryRaw($queryString)
		{
			if (!$result = mysqli_query($this->link, $queryString)) {
				
				$code = mysqli_errno($this->link);
				
				if ($code == 1062)
					$e = 'DuplicateObjectException';
				else
					$e = 'DatabaseException';
				
				throw new $e(
					mysqli_error($this->link).' - '.$queryString,
					$code
				);
			}
			
			return $result;
		}
		
		public function getTableInfo($table)
		{
			static $types = array(
				'tinyint'		=> DataType::SMALLINT,
				'smallint'		=> DataType::SMALLINT,
				'int'			=> DataType::INTEGER,
				'mediumint'		=> DataType::INTEGER,

				'bigint'		=> DataType::BIGINT,
				
				'double'		=> DataType::DOUBLE,
				'decimal'		=> DataType::NUMERIC,

				'char'			=> DataType::CHAR,
				'varchar'		=> DataType::VARCHAR,
				'text'			=> DataType::TEXT,
				'tinytext'		=> DataType::TEXT,
				'mediumtext'	=> DataType::TEXT,
				
				'date'			=> DataType::DATE,
				'time'			=> DataType::TIME,
				'timestamp'		=> DataType::TIMESTAMP,
				'datetime'		=> DataType::TIMESTAMP,

				// unhandled types
				'set'			=> null,
				'enum'			=> null,
				'year'			=> null
			);
			
			try {
				$result = $this->queryRaw('SHOW COLUMNS FROM '.$table);
			} catch (BaseException $e) {
				throw new ObjectNotFoundException(
					"unknown table '{$table}'"
				);
			}
			
			$table = new DBTable($table);
			
			while ($row = mysqli_fetch_array($result)) {
				$name = strtolower($row['Field']);
				$matches = array();
				$info = array('type' => null, 'extra' => null);
				if (
					preg_match(
						'~(\w+)(\((\d+?)\)){0,1}\s*(\w*)~',
						strtolower($row['Type']),
						$matches
					)
				) {
					$info['type'] = $matches[1];
					$info['size'] = $matches[3];
					$info['extra'] = $matches[4];
				}
				
				Assert::isTrue(
					array_key_exists($info['type'], $types),
					
					'unknown type "'
					.$types[$info['type']]
					.'" found in column "'.$name.'"'
				);
				
				if (empty($types[$info['type']]))
					continue;
				
				$column = DBColumn::create(
					DataType::create($types[$info['type']])->
						setUnsigned(
							strtolower($info['extra']) == 'unsigned'
						)->
						setNull(strtolower($row['Null']) == 'yes'),
					
					$name
				)->
				setAutoincrement(strtolower($row['Extra']) == 'auto_increment')->
				setPrimaryKey(strtolower($row['Key']) == 'pri');
				
				if ($row['Default'])
					$column->setDefault($row['Default']);
				
				$table->addColumn($column);
			}
			
			return $table;
		}
		
		public function hasQueue()
		{
			return false;
		}
		
		protected function getInsertId()
		{
			return mysqli_insert_id($this->link);
		}
		
		/**
		 * @return MyImprovedDialect
		**/
		protected function spawnDialect()
		{
			return new MyImprovedDialect();
		}
		
		private function checkSingle($result)
		{
			if (mysqli_num_rows($result) > 1)
				throw new TooManyRowsException(
					'query returned too many rows (we need only one)'
				);
			
			return $result;
		}
	}
?>
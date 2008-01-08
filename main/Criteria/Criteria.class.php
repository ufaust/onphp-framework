<?php
/****************************************************************************
 *   Copyright (C) 2006-2008 by Konstantin V. Arkhipov, Anton E. Lebedevich *
 *                                                                          *
 *   This program is free software; you can redistribute it and/or modify   *
 *   it under the terms of the GNU Lesser General Public License as         *
 *   published by the Free Software Foundation; either version 3 of the     *
 *   License, or (at your option) any later version.                        *
 *                                                                          *
 ****************************************************************************/
/* $Id$ */

	/**
	 * @see http://www.hibernate.org/hib_docs/v3/reference/en/html/querycriteria.html
	 * 
	 * @ingroup Criteria
	**/
	final class Criteria implements Stringable, DialectString
	{
		private $dao		= null;
		private $daoClass	= null;
		private $logic		= null;
		private $order		= null;
		private $strategy	= null;
		private $projection	= null;
		
		private $distinct	= false;
		
		private $limit	= null;
		private $offset	= null;
		
		private $collections = array();
		
		// dao-like behaviour: will throw ObjectNotFoundException when 'false'
		private $silent = true;
		
		/**
		 * @return Criteria
		**/
		public static function create(/* ProtoDAO */ $dao = null)
		{
			return new self($dao);
		}
		
		public function __construct(/* ProtoDAO */ $dao = null)
		{
			if ($dao)
				Assert::isTrue($dao instanceof ProtoDAO);
			
			$this->dao = $dao;
			$this->logic = Expression::andBlock();
			$this->order = new OrderChain();
			$this->strategy = FetchStrategy::join();
		}
		
		public function __clone()
		{
			$this->logic = clone $this->logic;
			$this->order = clone $this->order;
			$this->strategy = clone $this->strategy;
		}
		
		public function __sleep()
		{
			$this->daoClass = get_class($this->dao);
			
			$vars = get_object_vars($this);
			unset($vars['dao']);
			return array_keys($vars);
		}
		
		public function __wakeup()
		{
			$this->dao = Singleton::getInstance($this->daoClass);
		}
		
		/**
		 * @return ProtoDAO
		**/
		public function getDao()
		{
			return $this->dao;
		}
		
		/**
		 * @return Criteria
		**/
		public function setDao(ProtoDAO $dao)
		{
			$this->dao = $dao;
			
			return $this;
		}
		
		/**
		 * @return LogicalChain
		**/
		public function getLogic()
		{
			return $this->logic;
		}
		
		/**
		 * @return Criteria
		**/
		public function add(LogicalObject $logic)
		{
			$this->logic->expAnd($logic);
			
			return $this;
		}
		
		/**
		 * @return OrderChain
		**/
		public function getOrder()
		{
			return $this->order;
		}
		
		/**
		 * @return Criteria
		**/
		public function addOrder(/* MapableObject */ $order)
		{
			if (!$order instanceof MappableObject)
				$order = new OrderBy($order);
			
			$this->order->add($order);
			
			return $this;
		}
		
		/**
		 * @return Criteria
		**/
		public function prependOrder(/* MapableObject */ $order)
		{
			if (!$order instanceof MappableObject)
				$order = new OrderBy($order);
			
			$this->order->prepend($order);
			
			return $this;
		}
		
		/**
		 * @return Criteria
		**/
		public function dropOrder()
		{
			$this->order = new OrderChain();
			
			return $this;
		}
		
		public function getLimit()
		{
			return $this->limit;
		}
		
		/**
		 * @return Criteria
		**/
		public function setLimit($limit)
		{
			$this->limit = $limit;
			
			return $this;
		}
		
		public function getOffset()
		{
			return $this->offset;
		}
		
		/**
		 * @return Criteria
		**/
		public function setOffset($offset)
		{
			$this->offset = $offset;
			
			return $this;
		}
		
		/**
		 * @return FetchStrategy
		**/
		public function getFetchStrategy()
		{
			return $this->strategy;
		}
		
		/**
		 * @return Criteria
		**/
		public function setFetchStrategy(FetchStrategy $strategy)
		{
			$this->strategy = $strategy;
			
			return $this;
		}
		
		/**
		 * @return Criteria
		**/
		public function setProjection(ObjectProjection $chain)
		{
			$this->projection = $chain;
			
			return $this;
		}
		
		/**
		 * @return ProjectionChain
		**/
		public function getProjection()
		{
			return $this->projection;
		}
		
		/**
		 * @return Criteria
		**/
		public function dropProjection()
		{
			$this->projection = null;
			
			return $this;
		}
		
		/**
		 * @return Criteria
		**/
		public function setDistinct($orly = true)
		{
			$this->distinct = ($orly === true);
			
			return $this;
		}
		
		public function isDistinct()
		{
			return $this->distinct;
		}
		
		public function isSilent()
		{
			return $this->silent;
		}
		
		/**
		 * @return Criteria
		**/
		public function setSilent($silent)
		{
			Assert::isBoolean($silent);
			
			$this->silent = $silent;
			
			return $this;
		}
		
		/**
		 * @return Criteria
		**/
		public function fetchCollection(
			$path, // to collection
			$lazy = false, // fetching mode
			/* Criteria */ $criteria = null
		)
		{
			Assert::isBoolean($lazy);
			Assert::isTrue(
				($criteria === null)
				|| ($criteria instanceof Criteria)
			);
			
			$this->collections[$path]['lazy'] = $lazy;
			$this->collections[$path]['criteria'] = $criteria;
			$this->collections[$path]['propertyPath']
				= new PropertyPath($this->dao->getObjectName(), $path);
			
			return $this;
		}
		
		public function get()
		{
			try {
				$list = array($this->dao->getByQuery($this->toSelectQuery()));
			} catch (ObjectNotFoundException $e) {
				if (!$this->isSilent())
					throw $e;
				
				return null;
			}
			
			if (!$this->collections)
				return reset($list);
			
			$list = $this->dao->fetchCollections($this->collections, $list);
			
			return reset($list);
		}
		
		public function getList()
		{
			try {
				$list = $this->dao->getListByQuery($this->toSelectQuery());
			} catch (ObjectNotFoundException $e) {
				if (!$this->isSilent())
					throw $e;
				
				return array();
			}
			
			if (!$this->collections)
				return $list;
			
			return $this->dao->fetchCollections($this->collections, $list);
		}
		
		/**
		 * @return QueryResult
		**/
		public function getResult()
		{
			$result = $this->dao->getQueryResult($this->toSelectQuery());
			
			if (!$this->collections)
				return $result;
			
			return $result->setList(
				$this->dao->fetchCollections(
					$this->collections,
					$result->getList()
				)
			);
		}
		
		public function getCustom($index = null)
		{
			try {
				$result = $this->dao->getCustom($this->toSelectQuery());
				
				if ($index) {
					if (isset($result[$index]))
						return $result[$index];
					
					throw new MissingElementException();
				}
				
				return $result;
			} catch (ObjectNotFoundException $e) {
				if (!$this->isSilent())
					throw $e;
				
				return null;
			}
		}
		
		public function getCustomList()
		{
			try {
				return $this->dao->getCustomList($this->toSelectQuery());
			} catch (ObjectNotFoundException $e) {
				if (!$this->isSilent())
					throw $e;
				
				return array();
			}
		}
		
		public function getPropertyList()
		{
			try {
				return $this->dao->getCustomRowList($this->toSelectQuery());
			} catch (ObjectNotFoundException $e) {
				if (!$this->isSilent())
					throw $e;
				
				return array();
			}
		}
		
		public function toString()
		{
			return $this->toDialectString(
				$this->dao
					? DBPool::getByDao($this->dao)->getDialect()
					: ImaginaryDialect::me()
			);
		}
		
		public function toDialectString(Dialect $dialect)
		{
			return $this->toSelectQuery()->toDialectString($dialect);
		}
		
		/**
		 * @return SelectQuery
		**/
		public function toSelectQuery()
		{
			Assert::isNotNull($this->dao, 'DAO not set');
			
			if ($this->projection) {
				$query =
					$this->getProjection()->process(
						$this,
						OSQL::select()->from($this->dao->getTable())
					);
			} else
				$query = $this->dao->makeSelectHead();
			
			return $this->fillSelectQuery($query);
		}
		
		/**
		 * @return SelectQuery
		**/
		public function fillSelectQuery(SelectQuery $query)
		{
			$query->
				limit($this->limit, $this->offset);
			
			if ($this->distinct)
				$query->distinct();
			
			if ($this->logic->getSize()) {
				$query->
					andWhere(
						$this->logic->toMapped($this->dao, $query)
					);
			}
			
			if ($this->order) {
				$query->setOrderChain($this->order->toMapped($this->dao, $query));
			}
			
			if (
				!$this->projection
				&& (
					$this->strategy->getId() <> FetchStrategy::CASCADE
				)
			) {
				$this->joinProperties($query, $this->dao, $this->dao->getTable(), true);
			}
			
			return $query;
		}
		
		private function joinProperties(
			SelectQuery $query,
			ProtoDAO $parentDao,
			$parentTable,
			$parentRequired,
			$prefix = null
		)
		{
			$proto = call_user_func(array($parentDao->getObjectName(), 'proto'));
			
			foreach ($proto->getPropertyList() as $property) {
				if (
					($property instanceof LightMetaProperty)
					&& $property->getRelationId() == MetaRelation::ONE_TO_ONE
					&& !$property->isGenericType()
					&& $property->getFetchStrategyId() <> FetchStrategy::CASCADE
				) {
					if (
						is_subclass_of(
							$property->getClassName(),
							'Enumeration'
						)
					) {
						// field already added by makeSelectHead
						continue;
					} elseif ($property->isInner()) {
						$proto = call_user_func(
							array($property->getClassName(), 'proto')
						);
						
						foreach ($proto->getPropertyList() as $innerProperty)
							$query->get(
								new DBField(
									$innerProperty->getColumnName(),
									$parentTable
								)
							);
						
						continue;
					}
					
					$propertyDao = call_user_func(
						array($property->getClassName(), 'dao')
					);
					
					$tableAlias = $propertyDao->getJoinName(
						$property->getColumnName(),
						$prefix
					);
					
					$fields = $propertyDao->getFields();
					
					if (!$query->hasJoinedTable($tableAlias)) {
						$logic =
							Expression::eq(
								DBField::create(
									$property->getColumnName(),
									$parentTable
								),
								
								DBField::create(
									$propertyDao->getIdName(),
									$tableAlias
								)
							);
						
						if ($property->isRequired() && $parentRequired)
							$query->join($propertyDao->getTable(), $logic, $tableAlias);
						else
							$query->leftJoin($propertyDao->getTable(), $logic, $tableAlias);
					}
					
					foreach ($fields as $field) {
						$query->get(
							new DBField($field, $tableAlias),
							$propertyDao->getJoinPrefix($property->getColumnName(), $prefix)
								.$field
						);
					}
					
					$this->joinProperties(
						$query,
						$propertyDao,
						$tableAlias,
						$property->isRequired() && $parentRequired,
						$propertyDao->getJoinPrefix($property->getColumnName(), $prefix)
					);
				}
			}
		}
		
		/**
		 * @return AbstractProtoClass
		**/
		private function getProto()
		{
			return
				call_user_func(
					array($this->dao->getObjectName(), 'proto')
				);
		}
	}
?>
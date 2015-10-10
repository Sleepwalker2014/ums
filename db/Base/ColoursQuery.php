<?php

namespace Base;

use \Colours as ChildColours;
use \ColoursQuery as ChildColoursQuery;
use \Exception;
use \PDO;
use Map\ColoursTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'colours' table.
 *
 *
 *
 * @method     ChildColoursQuery orderByColour($order = Criteria::ASC) Order by the colour column
 * @method     ChildColoursQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildColoursQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildColoursQuery groupByColour() Group by the colour column
 * @method     ChildColoursQuery groupByCode() Group by the code column
 * @method     ChildColoursQuery groupByName() Group by the name column
 *
 * @method     ChildColoursQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildColoursQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildColoursQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildColoursQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildColoursQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildColoursQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildColoursQuery leftJoinAnimalsRelatedByFurcolourid($relationAlias = null) Adds a LEFT JOIN clause to the query using the AnimalsRelatedByFurcolourid relation
 * @method     ChildColoursQuery rightJoinAnimalsRelatedByFurcolourid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AnimalsRelatedByFurcolourid relation
 * @method     ChildColoursQuery innerJoinAnimalsRelatedByFurcolourid($relationAlias = null) Adds a INNER JOIN clause to the query using the AnimalsRelatedByFurcolourid relation
 *
 * @method     ChildColoursQuery joinWithAnimalsRelatedByFurcolourid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AnimalsRelatedByFurcolourid relation
 *
 * @method     ChildColoursQuery leftJoinWithAnimalsRelatedByFurcolourid() Adds a LEFT JOIN clause and with to the query using the AnimalsRelatedByFurcolourid relation
 * @method     ChildColoursQuery rightJoinWithAnimalsRelatedByFurcolourid() Adds a RIGHT JOIN clause and with to the query using the AnimalsRelatedByFurcolourid relation
 * @method     ChildColoursQuery innerJoinWithAnimalsRelatedByFurcolourid() Adds a INNER JOIN clause and with to the query using the AnimalsRelatedByFurcolourid relation
 *
 * @method     ChildColoursQuery leftJoinAnimalsRelatedByEyecolourid($relationAlias = null) Adds a LEFT JOIN clause to the query using the AnimalsRelatedByEyecolourid relation
 * @method     ChildColoursQuery rightJoinAnimalsRelatedByEyecolourid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AnimalsRelatedByEyecolourid relation
 * @method     ChildColoursQuery innerJoinAnimalsRelatedByEyecolourid($relationAlias = null) Adds a INNER JOIN clause to the query using the AnimalsRelatedByEyecolourid relation
 *
 * @method     ChildColoursQuery joinWithAnimalsRelatedByEyecolourid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AnimalsRelatedByEyecolourid relation
 *
 * @method     ChildColoursQuery leftJoinWithAnimalsRelatedByEyecolourid() Adds a LEFT JOIN clause and with to the query using the AnimalsRelatedByEyecolourid relation
 * @method     ChildColoursQuery rightJoinWithAnimalsRelatedByEyecolourid() Adds a RIGHT JOIN clause and with to the query using the AnimalsRelatedByEyecolourid relation
 * @method     ChildColoursQuery innerJoinWithAnimalsRelatedByEyecolourid() Adds a INNER JOIN clause and with to the query using the AnimalsRelatedByEyecolourid relation
 *
 * @method     \AnimalsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildColours findOne(ConnectionInterface $con = null) Return the first ChildColours matching the query
 * @method     ChildColours findOneOrCreate(ConnectionInterface $con = null) Return the first ChildColours matching the query, or a new ChildColours object populated from the query conditions when no match is found
 *
 * @method     ChildColours findOneByColour(int $colour) Return the first ChildColours filtered by the colour column
 * @method     ChildColours findOneByCode(string $code) Return the first ChildColours filtered by the code column
 * @method     ChildColours findOneByName(string $name) Return the first ChildColours filtered by the name column *

 * @method     ChildColours requirePk($key, ConnectionInterface $con = null) Return the ChildColours by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColours requireOne(ConnectionInterface $con = null) Return the first ChildColours matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildColours requireOneByColour(int $colour) Return the first ChildColours filtered by the colour column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColours requireOneByCode(string $code) Return the first ChildColours filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColours requireOneByName(string $name) Return the first ChildColours filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildColours[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildColours objects based on current ModelCriteria
 * @method     ChildColours[]|ObjectCollection findByColour(int $colour) Return ChildColours objects filtered by the colour column
 * @method     ChildColours[]|ObjectCollection findByCode(string $code) Return ChildColours objects filtered by the code column
 * @method     ChildColours[]|ObjectCollection findByName(string $name) Return ChildColours objects filtered by the name column
 * @method     ChildColours[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ColoursQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ColoursQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Colours', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildColoursQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildColoursQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildColoursQuery) {
            return $criteria;
        }
        $query = new ChildColoursQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildColours|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ColoursTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ColoursTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildColours A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT colour, code, name FROM colours WHERE colour = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildColours $obj */
            $obj = new ChildColours();
            $obj->hydrate($row);
            ColoursTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildColours|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ColoursTableMap::COL_COLOUR, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ColoursTableMap::COL_COLOUR, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the colour column
     *
     * Example usage:
     * <code>
     * $query->filterByColour(1234); // WHERE colour = 1234
     * $query->filterByColour(array(12, 34)); // WHERE colour IN (12, 34)
     * $query->filterByColour(array('min' => 12)); // WHERE colour > 12
     * </code>
     *
     * @param     mixed $colour The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function filterByColour($colour = null, $comparison = null)
    {
        if (is_array($colour)) {
            $useMinMax = false;
            if (isset($colour['min'])) {
                $this->addUsingAlias(ColoursTableMap::COL_COLOUR, $colour['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($colour['max'])) {
                $this->addUsingAlias(ColoursTableMap::COL_COLOUR, $colour['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ColoursTableMap::COL_COLOUR, $colour, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ColoursTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ColoursTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \Animals object
     *
     * @param \Animals|ObjectCollection $animals the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildColoursQuery The current query, for fluid interface
     */
    public function filterByAnimalsRelatedByFurcolourid($animals, $comparison = null)
    {
        if ($animals instanceof \Animals) {
            return $this
                ->addUsingAlias(ColoursTableMap::COL_COLOUR, $animals->getFurcolourid(), $comparison);
        } elseif ($animals instanceof ObjectCollection) {
            return $this
                ->useAnimalsRelatedByFurcolouridQuery()
                ->filterByPrimaryKeys($animals->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnimalsRelatedByFurcolourid() only accepts arguments of type \Animals or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AnimalsRelatedByFurcolourid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function joinAnimalsRelatedByFurcolourid($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AnimalsRelatedByFurcolourid');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AnimalsRelatedByFurcolourid');
        }

        return $this;
    }

    /**
     * Use the AnimalsRelatedByFurcolourid relation Animals object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AnimalsQuery A secondary query class using the current class as primary query
     */
    public function useAnimalsRelatedByFurcolouridQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnimalsRelatedByFurcolourid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AnimalsRelatedByFurcolourid', '\AnimalsQuery');
    }

    /**
     * Filter the query by a related \Animals object
     *
     * @param \Animals|ObjectCollection $animals the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildColoursQuery The current query, for fluid interface
     */
    public function filterByAnimalsRelatedByEyecolourid($animals, $comparison = null)
    {
        if ($animals instanceof \Animals) {
            return $this
                ->addUsingAlias(ColoursTableMap::COL_COLOUR, $animals->getEyecolourid(), $comparison);
        } elseif ($animals instanceof ObjectCollection) {
            return $this
                ->useAnimalsRelatedByEyecolouridQuery()
                ->filterByPrimaryKeys($animals->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnimalsRelatedByEyecolourid() only accepts arguments of type \Animals or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AnimalsRelatedByEyecolourid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function joinAnimalsRelatedByEyecolourid($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AnimalsRelatedByEyecolourid');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AnimalsRelatedByEyecolourid');
        }

        return $this;
    }

    /**
     * Use the AnimalsRelatedByEyecolourid relation Animals object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AnimalsQuery A secondary query class using the current class as primary query
     */
    public function useAnimalsRelatedByEyecolouridQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnimalsRelatedByEyecolourid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AnimalsRelatedByEyecolourid', '\AnimalsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildColours $colours Object to remove from the list of results
     *
     * @return $this|ChildColoursQuery The current query, for fluid interface
     */
    public function prune($colours = null)
    {
        if ($colours) {
            $this->addUsingAlias(ColoursTableMap::COL_COLOUR, $colours->getColour(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the colours table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ColoursTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ColoursTableMap::clearInstancePool();
            ColoursTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ColoursTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ColoursTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ColoursTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ColoursTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ColoursQuery

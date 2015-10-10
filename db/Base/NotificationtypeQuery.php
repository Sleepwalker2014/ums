<?php

namespace Base;

use \Notificationtype as ChildNotificationtype;
use \NotificationtypeQuery as ChildNotificationtypeQuery;
use \Exception;
use \PDO;
use Map\NotificationtypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'notificationType' table.
 *
 *
 *
 * @method     ChildNotificationtypeQuery orderByNotificationtype($order = Criteria::ASC) Order by the notificationType column
 * @method     ChildNotificationtypeQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildNotificationtypeQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildNotificationtypeQuery groupByNotificationtype() Group by the notificationType column
 * @method     ChildNotificationtypeQuery groupByCode() Group by the code column
 * @method     ChildNotificationtypeQuery groupByDescription() Group by the description column
 *
 * @method     ChildNotificationtypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNotificationtypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNotificationtypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNotificationtypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNotificationtypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNotificationtypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNotificationtypeQuery leftJoinNotifications($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notifications relation
 * @method     ChildNotificationtypeQuery rightJoinNotifications($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notifications relation
 * @method     ChildNotificationtypeQuery innerJoinNotifications($relationAlias = null) Adds a INNER JOIN clause to the query using the Notifications relation
 *
 * @method     ChildNotificationtypeQuery joinWithNotifications($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Notifications relation
 *
 * @method     ChildNotificationtypeQuery leftJoinWithNotifications() Adds a LEFT JOIN clause and with to the query using the Notifications relation
 * @method     ChildNotificationtypeQuery rightJoinWithNotifications() Adds a RIGHT JOIN clause and with to the query using the Notifications relation
 * @method     ChildNotificationtypeQuery innerJoinWithNotifications() Adds a INNER JOIN clause and with to the query using the Notifications relation
 *
 * @method     \NotificationsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNotificationtype findOne(ConnectionInterface $con = null) Return the first ChildNotificationtype matching the query
 * @method     ChildNotificationtype findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNotificationtype matching the query, or a new ChildNotificationtype object populated from the query conditions when no match is found
 *
 * @method     ChildNotificationtype findOneByNotificationtype(int $notificationType) Return the first ChildNotificationtype filtered by the notificationType column
 * @method     ChildNotificationtype findOneByCode(string $code) Return the first ChildNotificationtype filtered by the code column
 * @method     ChildNotificationtype findOneByDescription(string $description) Return the first ChildNotificationtype filtered by the description column *

 * @method     ChildNotificationtype requirePk($key, ConnectionInterface $con = null) Return the ChildNotificationtype by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationtype requireOne(ConnectionInterface $con = null) Return the first ChildNotificationtype matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotificationtype requireOneByNotificationtype(int $notificationType) Return the first ChildNotificationtype filtered by the notificationType column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationtype requireOneByCode(string $code) Return the first ChildNotificationtype filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationtype requireOneByDescription(string $description) Return the first ChildNotificationtype filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotificationtype[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNotificationtype objects based on current ModelCriteria
 * @method     ChildNotificationtype[]|ObjectCollection findByNotificationtype(int $notificationType) Return ChildNotificationtype objects filtered by the notificationType column
 * @method     ChildNotificationtype[]|ObjectCollection findByCode(string $code) Return ChildNotificationtype objects filtered by the code column
 * @method     ChildNotificationtype[]|ObjectCollection findByDescription(string $description) Return ChildNotificationtype objects filtered by the description column
 * @method     ChildNotificationtype[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NotificationtypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\NotificationtypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Notificationtype', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNotificationtypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNotificationtypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNotificationtypeQuery) {
            return $criteria;
        }
        $query = new ChildNotificationtypeQuery();
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
     * @return ChildNotificationtype|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = NotificationtypeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationtypeTableMap::DATABASE_NAME);
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
     * @return ChildNotificationtype A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT notificationType, code, description FROM notificationType WHERE notificationType = :p0';
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
            /** @var ChildNotificationtype $obj */
            $obj = new ChildNotificationtype();
            $obj->hydrate($row);
            NotificationtypeTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildNotificationtype|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNotificationtypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NotificationtypeTableMap::COL_NOTIFICATIONTYPE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNotificationtypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NotificationtypeTableMap::COL_NOTIFICATIONTYPE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the notificationType column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationtype(1234); // WHERE notificationType = 1234
     * $query->filterByNotificationtype(array(12, 34)); // WHERE notificationType IN (12, 34)
     * $query->filterByNotificationtype(array('min' => 12)); // WHERE notificationType > 12
     * </code>
     *
     * @param     mixed $notificationtype The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationtypeQuery The current query, for fluid interface
     */
    public function filterByNotificationtype($notificationtype = null, $comparison = null)
    {
        if (is_array($notificationtype)) {
            $useMinMax = false;
            if (isset($notificationtype['min'])) {
                $this->addUsingAlias(NotificationtypeTableMap::COL_NOTIFICATIONTYPE, $notificationtype['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notificationtype['max'])) {
                $this->addUsingAlias(NotificationtypeTableMap::COL_NOTIFICATIONTYPE, $notificationtype['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationtypeTableMap::COL_NOTIFICATIONTYPE, $notificationtype, $comparison);
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
     * @return $this|ChildNotificationtypeQuery The current query, for fluid interface
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

        return $this->addUsingAlias(NotificationtypeTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationtypeQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(NotificationtypeTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \Notifications object
     *
     * @param \Notifications|ObjectCollection $notifications the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildNotificationtypeQuery The current query, for fluid interface
     */
    public function filterByNotifications($notifications, $comparison = null)
    {
        if ($notifications instanceof \Notifications) {
            return $this
                ->addUsingAlias(NotificationtypeTableMap::COL_NOTIFICATIONTYPE, $notifications->getNotificationtypeid(), $comparison);
        } elseif ($notifications instanceof ObjectCollection) {
            return $this
                ->useNotificationsQuery()
                ->filterByPrimaryKeys($notifications->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNotifications() only accepts arguments of type \Notifications or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Notifications relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationtypeQuery The current query, for fluid interface
     */
    public function joinNotifications($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Notifications');

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
            $this->addJoinObject($join, 'Notifications');
        }

        return $this;
    }

    /**
     * Use the Notifications relation Notifications object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \NotificationsQuery A secondary query class using the current class as primary query
     */
    public function useNotificationsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNotifications($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notifications', '\NotificationsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNotificationtype $notificationtype Object to remove from the list of results
     *
     * @return $this|ChildNotificationtypeQuery The current query, for fluid interface
     */
    public function prune($notificationtype = null)
    {
        if ($notificationtype) {
            $this->addUsingAlias(NotificationtypeTableMap::COL_NOTIFICATIONTYPE, $notificationtype->getNotificationtype(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the notificationType table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationtypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NotificationtypeTableMap::clearInstancePool();
            NotificationtypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationtypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NotificationtypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NotificationtypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NotificationtypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NotificationtypeQuery

<?php

namespace Base;

use \Searchnotifications as ChildSearchnotifications;
use \SearchnotificationsQuery as ChildSearchnotificationsQuery;
use \Exception;
use \PDO;
use Map\SearchnotificationsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'searchNotifications' table.
 *
 *
 *
 * @method     ChildSearchnotificationsQuery orderBySearchnotification($order = Criteria::ASC) Order by the searchNotification column
 * @method     ChildSearchnotificationsQuery orderByNotification($order = Criteria::ASC) Order by the notification column
 * @method     ChildSearchnotificationsQuery orderByMissingdate($order = Criteria::ASC) Order by the missingDate column
 * @method     ChildSearchnotificationsQuery orderByAdditionalinformation($order = Criteria::ASC) Order by the additionalInformation column
 * @method     ChildSearchnotificationsQuery orderByReward($order = Criteria::ASC) Order by the reward column
 *
 * @method     ChildSearchnotificationsQuery groupBySearchnotification() Group by the searchNotification column
 * @method     ChildSearchnotificationsQuery groupByNotification() Group by the notification column
 * @method     ChildSearchnotificationsQuery groupByMissingdate() Group by the missingDate column
 * @method     ChildSearchnotificationsQuery groupByAdditionalinformation() Group by the additionalInformation column
 * @method     ChildSearchnotificationsQuery groupByReward() Group by the reward column
 *
 * @method     ChildSearchnotificationsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSearchnotificationsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSearchnotificationsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSearchnotificationsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSearchnotificationsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSearchnotificationsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSearchnotificationsQuery leftJoinNotifications($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notifications relation
 * @method     ChildSearchnotificationsQuery rightJoinNotifications($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notifications relation
 * @method     ChildSearchnotificationsQuery innerJoinNotifications($relationAlias = null) Adds a INNER JOIN clause to the query using the Notifications relation
 *
 * @method     ChildSearchnotificationsQuery joinWithNotifications($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Notifications relation
 *
 * @method     ChildSearchnotificationsQuery leftJoinWithNotifications() Adds a LEFT JOIN clause and with to the query using the Notifications relation
 * @method     ChildSearchnotificationsQuery rightJoinWithNotifications() Adds a RIGHT JOIN clause and with to the query using the Notifications relation
 * @method     ChildSearchnotificationsQuery innerJoinWithNotifications() Adds a INNER JOIN clause and with to the query using the Notifications relation
 *
 * @method     \NotificationsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSearchnotifications findOne(ConnectionInterface $con = null) Return the first ChildSearchnotifications matching the query
 * @method     ChildSearchnotifications findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSearchnotifications matching the query, or a new ChildSearchnotifications object populated from the query conditions when no match is found
 *
 * @method     ChildSearchnotifications findOneBySearchnotification(int $searchNotification) Return the first ChildSearchnotifications filtered by the searchNotification column
 * @method     ChildSearchnotifications findOneByNotification(int $notification) Return the first ChildSearchnotifications filtered by the notification column
 * @method     ChildSearchnotifications findOneByMissingdate(string $missingDate) Return the first ChildSearchnotifications filtered by the missingDate column
 * @method     ChildSearchnotifications findOneByAdditionalinformation(string $additionalInformation) Return the first ChildSearchnotifications filtered by the additionalInformation column
 * @method     ChildSearchnotifications findOneByReward(int $reward) Return the first ChildSearchnotifications filtered by the reward column *

 * @method     ChildSearchnotifications requirePk($key, ConnectionInterface $con = null) Return the ChildSearchnotifications by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSearchnotifications requireOne(ConnectionInterface $con = null) Return the first ChildSearchnotifications matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSearchnotifications requireOneBySearchnotification(int $searchNotification) Return the first ChildSearchnotifications filtered by the searchNotification column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSearchnotifications requireOneByNotification(int $notification) Return the first ChildSearchnotifications filtered by the notification column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSearchnotifications requireOneByMissingdate(string $missingDate) Return the first ChildSearchnotifications filtered by the missingDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSearchnotifications requireOneByAdditionalinformation(string $additionalInformation) Return the first ChildSearchnotifications filtered by the additionalInformation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSearchnotifications requireOneByReward(int $reward) Return the first ChildSearchnotifications filtered by the reward column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSearchnotifications[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSearchnotifications objects based on current ModelCriteria
 * @method     ChildSearchnotifications[]|ObjectCollection findBySearchnotification(int $searchNotification) Return ChildSearchnotifications objects filtered by the searchNotification column
 * @method     ChildSearchnotifications[]|ObjectCollection findByNotification(int $notification) Return ChildSearchnotifications objects filtered by the notification column
 * @method     ChildSearchnotifications[]|ObjectCollection findByMissingdate(string $missingDate) Return ChildSearchnotifications objects filtered by the missingDate column
 * @method     ChildSearchnotifications[]|ObjectCollection findByAdditionalinformation(string $additionalInformation) Return ChildSearchnotifications objects filtered by the additionalInformation column
 * @method     ChildSearchnotifications[]|ObjectCollection findByReward(int $reward) Return ChildSearchnotifications objects filtered by the reward column
 * @method     ChildSearchnotifications[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SearchnotificationsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SearchnotificationsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Searchnotifications', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSearchnotificationsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSearchnotificationsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSearchnotificationsQuery) {
            return $criteria;
        }
        $query = new ChildSearchnotificationsQuery();
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
     * @return ChildSearchnotifications|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SearchnotificationsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SearchnotificationsTableMap::DATABASE_NAME);
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
     * @return ChildSearchnotifications A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT searchNotification, notification, missingDate, additionalInformation, reward FROM searchNotifications WHERE searchNotification = :p0';
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
            /** @var ChildSearchnotifications $obj */
            $obj = new ChildSearchnotifications();
            $obj->hydrate($row);
            SearchnotificationsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSearchnotifications|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the searchNotification column
     *
     * Example usage:
     * <code>
     * $query->filterBySearchnotification(1234); // WHERE searchNotification = 1234
     * $query->filterBySearchnotification(array(12, 34)); // WHERE searchNotification IN (12, 34)
     * $query->filterBySearchnotification(array('min' => 12)); // WHERE searchNotification > 12
     * </code>
     *
     * @param     mixed $searchnotification The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterBySearchnotification($searchnotification = null, $comparison = null)
    {
        if (is_array($searchnotification)) {
            $useMinMax = false;
            if (isset($searchnotification['min'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, $searchnotification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($searchnotification['max'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, $searchnotification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, $searchnotification, $comparison);
    }

    /**
     * Filter the query on the notification column
     *
     * Example usage:
     * <code>
     * $query->filterByNotification(1234); // WHERE notification = 1234
     * $query->filterByNotification(array(12, 34)); // WHERE notification IN (12, 34)
     * $query->filterByNotification(array('min' => 12)); // WHERE notification > 12
     * </code>
     *
     * @see       filterByNotifications()
     *
     * @param     mixed $notification The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterByNotification($notification = null, $comparison = null)
    {
        if (is_array($notification)) {
            $useMinMax = false;
            if (isset($notification['min'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_NOTIFICATION, $notification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notification['max'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_NOTIFICATION, $notification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SearchnotificationsTableMap::COL_NOTIFICATION, $notification, $comparison);
    }

    /**
     * Filter the query on the missingDate column
     *
     * Example usage:
     * <code>
     * $query->filterByMissingdate('2011-03-14'); // WHERE missingDate = '2011-03-14'
     * $query->filterByMissingdate('now'); // WHERE missingDate = '2011-03-14'
     * $query->filterByMissingdate(array('max' => 'yesterday')); // WHERE missingDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $missingdate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterByMissingdate($missingdate = null, $comparison = null)
    {
        if (is_array($missingdate)) {
            $useMinMax = false;
            if (isset($missingdate['min'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_MISSINGDATE, $missingdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($missingdate['max'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_MISSINGDATE, $missingdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SearchnotificationsTableMap::COL_MISSINGDATE, $missingdate, $comparison);
    }

    /**
     * Filter the query on the additionalInformation column
     *
     * Example usage:
     * <code>
     * $query->filterByAdditionalinformation('fooValue');   // WHERE additionalInformation = 'fooValue'
     * $query->filterByAdditionalinformation('%fooValue%'); // WHERE additionalInformation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $additionalinformation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterByAdditionalinformation($additionalinformation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($additionalinformation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $additionalinformation)) {
                $additionalinformation = str_replace('*', '%', $additionalinformation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SearchnotificationsTableMap::COL_ADDITIONALINFORMATION, $additionalinformation, $comparison);
    }

    /**
     * Filter the query on the reward column
     *
     * Example usage:
     * <code>
     * $query->filterByReward(1234); // WHERE reward = 1234
     * $query->filterByReward(array(12, 34)); // WHERE reward IN (12, 34)
     * $query->filterByReward(array('min' => 12)); // WHERE reward > 12
     * </code>
     *
     * @param     mixed $reward The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterByReward($reward = null, $comparison = null)
    {
        if (is_array($reward)) {
            $useMinMax = false;
            if (isset($reward['min'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_REWARD, $reward['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reward['max'])) {
                $this->addUsingAlias(SearchnotificationsTableMap::COL_REWARD, $reward['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SearchnotificationsTableMap::COL_REWARD, $reward, $comparison);
    }

    /**
     * Filter the query by a related \Notifications object
     *
     * @param \Notifications|ObjectCollection $notifications The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function filterByNotifications($notifications, $comparison = null)
    {
        if ($notifications instanceof \Notifications) {
            return $this
                ->addUsingAlias(SearchnotificationsTableMap::COL_NOTIFICATION, $notifications->getNotification(), $comparison);
        } elseif ($notifications instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SearchnotificationsTableMap::COL_NOTIFICATION, $notifications->toKeyValue('PrimaryKey', 'Notification'), $comparison);
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
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
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
     * @param   ChildSearchnotifications $searchnotifications Object to remove from the list of results
     *
     * @return $this|ChildSearchnotificationsQuery The current query, for fluid interface
     */
    public function prune($searchnotifications = null)
    {
        if ($searchnotifications) {
            $this->addUsingAlias(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, $searchnotifications->getSearchnotification(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the searchNotifications table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SearchnotificationsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SearchnotificationsTableMap::clearInstancePool();
            SearchnotificationsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SearchnotificationsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SearchnotificationsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SearchnotificationsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SearchnotificationsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SearchnotificationsQuery

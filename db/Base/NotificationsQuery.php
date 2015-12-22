<?php

namespace Base;

use \Notifications as ChildNotifications;
use \NotificationsQuery as ChildNotificationsQuery;
use \Exception;
use \PDO;
use Map\NotificationsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'notifications' table.
 *
 *
 *
 * @method     ChildNotificationsQuery orderByNotification($order = Criteria::ASC) Order by the notification column
 * @method     ChildNotificationsQuery orderByLatitude($order = Criteria::ASC) Order by the latitude column
 * @method     ChildNotificationsQuery orderByNotificationtypeid($order = Criteria::ASC) Order by the notificationTypeId column
 * @method     ChildNotificationsQuery orderByCreationdate($order = Criteria::ASC) Order by the creationDate column
 * @method     ChildNotificationsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildNotificationsQuery orderByAnimalid($order = Criteria::ASC) Order by the animalId column
 * @method     ChildNotificationsQuery orderByLongitude($order = Criteria::ASC) Order by the longitude column
 *
 * @method     ChildNotificationsQuery groupByNotification() Group by the notification column
 * @method     ChildNotificationsQuery groupByLatitude() Group by the latitude column
 * @method     ChildNotificationsQuery groupByNotificationtypeid() Group by the notificationTypeId column
 * @method     ChildNotificationsQuery groupByCreationdate() Group by the creationDate column
 * @method     ChildNotificationsQuery groupByDescription() Group by the description column
 * @method     ChildNotificationsQuery groupByAnimalid() Group by the animalId column
 * @method     ChildNotificationsQuery groupByLongitude() Group by the longitude column
 *
 * @method     ChildNotificationsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNotificationsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNotificationsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNotificationsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNotificationsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNotificationsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNotificationsQuery leftJoinNotificationtype($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notificationtype relation
 * @method     ChildNotificationsQuery rightJoinNotificationtype($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notificationtype relation
 * @method     ChildNotificationsQuery innerJoinNotificationtype($relationAlias = null) Adds a INNER JOIN clause to the query using the Notificationtype relation
 *
 * @method     ChildNotificationsQuery joinWithNotificationtype($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Notificationtype relation
 *
 * @method     ChildNotificationsQuery leftJoinWithNotificationtype() Adds a LEFT JOIN clause and with to the query using the Notificationtype relation
 * @method     ChildNotificationsQuery rightJoinWithNotificationtype() Adds a RIGHT JOIN clause and with to the query using the Notificationtype relation
 * @method     ChildNotificationsQuery innerJoinWithNotificationtype() Adds a INNER JOIN clause and with to the query using the Notificationtype relation
 *
 * @method     ChildNotificationsQuery leftJoinAnimals($relationAlias = null) Adds a LEFT JOIN clause to the query using the Animals relation
 * @method     ChildNotificationsQuery rightJoinAnimals($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Animals relation
 * @method     ChildNotificationsQuery innerJoinAnimals($relationAlias = null) Adds a INNER JOIN clause to the query using the Animals relation
 *
 * @method     ChildNotificationsQuery joinWithAnimals($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Animals relation
 *
 * @method     ChildNotificationsQuery leftJoinWithAnimals() Adds a LEFT JOIN clause and with to the query using the Animals relation
 * @method     ChildNotificationsQuery rightJoinWithAnimals() Adds a RIGHT JOIN clause and with to the query using the Animals relation
 * @method     ChildNotificationsQuery innerJoinWithAnimals() Adds a INNER JOIN clause and with to the query using the Animals relation
 *
 * @method     ChildNotificationsQuery leftJoinSearchnotifications($relationAlias = null) Adds a LEFT JOIN clause to the query using the Searchnotifications relation
 * @method     ChildNotificationsQuery rightJoinSearchnotifications($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Searchnotifications relation
 * @method     ChildNotificationsQuery innerJoinSearchnotifications($relationAlias = null) Adds a INNER JOIN clause to the query using the Searchnotifications relation
 *
 * @method     ChildNotificationsQuery joinWithSearchnotifications($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Searchnotifications relation
 *
 * @method     ChildNotificationsQuery leftJoinWithSearchnotifications() Adds a LEFT JOIN clause and with to the query using the Searchnotifications relation
 * @method     ChildNotificationsQuery rightJoinWithSearchnotifications() Adds a RIGHT JOIN clause and with to the query using the Searchnotifications relation
 * @method     ChildNotificationsQuery innerJoinWithSearchnotifications() Adds a INNER JOIN clause and with to the query using the Searchnotifications relation
 *
 * @method     \NotificationtypeQuery|\AnimalsQuery|\SearchnotificationsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNotifications findOne(ConnectionInterface $con = null) Return the first ChildNotifications matching the query
 * @method     ChildNotifications findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNotifications matching the query, or a new ChildNotifications object populated from the query conditions when no match is found
 *
 * @method     ChildNotifications findOneByNotification(int $notification) Return the first ChildNotifications filtered by the notification column
 * @method     ChildNotifications findOneByLatitude(double $latitude) Return the first ChildNotifications filtered by the latitude column
 * @method     ChildNotifications findOneByNotificationtypeid(int $notificationTypeId) Return the first ChildNotifications filtered by the notificationTypeId column
 * @method     ChildNotifications findOneByCreationdate(string $creationDate) Return the first ChildNotifications filtered by the creationDate column
 * @method     ChildNotifications findOneByDescription(string $description) Return the first ChildNotifications filtered by the description column
 * @method     ChildNotifications findOneByAnimalid(int $animalId) Return the first ChildNotifications filtered by the animalId column
 * @method     ChildNotifications findOneByLongitude(double $longitude) Return the first ChildNotifications filtered by the longitude column *

 * @method     ChildNotifications requirePk($key, ConnectionInterface $con = null) Return the ChildNotifications by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotifications requireOne(ConnectionInterface $con = null) Return the first ChildNotifications matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotifications requireOneByNotification(int $notification) Return the first ChildNotifications filtered by the notification column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotifications requireOneByLatitude(double $latitude) Return the first ChildNotifications filtered by the latitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotifications requireOneByNotificationtypeid(int $notificationTypeId) Return the first ChildNotifications filtered by the notificationTypeId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotifications requireOneByCreationdate(string $creationDate) Return the first ChildNotifications filtered by the creationDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotifications requireOneByDescription(string $description) Return the first ChildNotifications filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotifications requireOneByAnimalid(int $animalId) Return the first ChildNotifications filtered by the animalId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotifications requireOneByLongitude(double $longitude) Return the first ChildNotifications filtered by the longitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotifications[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNotifications objects based on current ModelCriteria
 * @method     ChildNotifications[]|ObjectCollection findByNotification(int $notification) Return ChildNotifications objects filtered by the notification column
 * @method     ChildNotifications[]|ObjectCollection findByLatitude(double $latitude) Return ChildNotifications objects filtered by the latitude column
 * @method     ChildNotifications[]|ObjectCollection findByNotificationtypeid(int $notificationTypeId) Return ChildNotifications objects filtered by the notificationTypeId column
 * @method     ChildNotifications[]|ObjectCollection findByCreationdate(string $creationDate) Return ChildNotifications objects filtered by the creationDate column
 * @method     ChildNotifications[]|ObjectCollection findByDescription(string $description) Return ChildNotifications objects filtered by the description column
 * @method     ChildNotifications[]|ObjectCollection findByAnimalid(int $animalId) Return ChildNotifications objects filtered by the animalId column
 * @method     ChildNotifications[]|ObjectCollection findByLongitude(double $longitude) Return ChildNotifications objects filtered by the longitude column
 * @method     ChildNotifications[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NotificationsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\NotificationsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Notifications', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNotificationsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNotificationsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNotificationsQuery) {
            return $criteria;
        }
        $query = new ChildNotificationsQuery();
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
     * @return ChildNotifications|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = NotificationsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationsTableMap::DATABASE_NAME);
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
     * @return ChildNotifications A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT notification, latitude, notificationTypeId, creationDate, description, animalId, longitude FROM notifications WHERE notification = :p0';
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
            /** @var ChildNotifications $obj */
            $obj = new ChildNotifications();
            $obj->hydrate($row);
            NotificationsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildNotifications|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATION, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATION, $keys, Criteria::IN);
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
     * @param     mixed $notification The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByNotification($notification = null, $comparison = null)
    {
        if (is_array($notification)) {
            $useMinMax = false;
            if (isset($notification['min'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATION, $notification['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notification['max'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATION, $notification['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATION, $notification, $comparison);
    }

    /**
     * Filter the query on the latitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLatitude(1234); // WHERE latitude = 1234
     * $query->filterByLatitude(array(12, 34)); // WHERE latitude IN (12, 34)
     * $query->filterByLatitude(array('min' => 12)); // WHERE latitude > 12
     * </code>
     *
     * @param     mixed $latitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByLatitude($latitude = null, $comparison = null)
    {
        if (is_array($latitude)) {
            $useMinMax = false;
            if (isset($latitude['min'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_LATITUDE, $latitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latitude['max'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_LATITUDE, $latitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationsTableMap::COL_LATITUDE, $latitude, $comparison);
    }

    /**
     * Filter the query on the notificationTypeId column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationtypeid(1234); // WHERE notificationTypeId = 1234
     * $query->filterByNotificationtypeid(array(12, 34)); // WHERE notificationTypeId IN (12, 34)
     * $query->filterByNotificationtypeid(array('min' => 12)); // WHERE notificationTypeId > 12
     * </code>
     *
     * @see       filterByNotificationtype()
     *
     * @param     mixed $notificationtypeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByNotificationtypeid($notificationtypeid = null, $comparison = null)
    {
        if (is_array($notificationtypeid)) {
            $useMinMax = false;
            if (isset($notificationtypeid['min'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATIONTYPEID, $notificationtypeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notificationtypeid['max'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATIONTYPEID, $notificationtypeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATIONTYPEID, $notificationtypeid, $comparison);
    }

    /**
     * Filter the query on the creationDate column
     *
     * Example usage:
     * <code>
     * $query->filterByCreationdate('2011-03-14'); // WHERE creationDate = '2011-03-14'
     * $query->filterByCreationdate('now'); // WHERE creationDate = '2011-03-14'
     * $query->filterByCreationdate(array('max' => 'yesterday')); // WHERE creationDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $creationdate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByCreationdate($creationdate = null, $comparison = null)
    {
        if (is_array($creationdate)) {
            $useMinMax = false;
            if (isset($creationdate['min'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_CREATIONDATE, $creationdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creationdate['max'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_CREATIONDATE, $creationdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationsTableMap::COL_CREATIONDATE, $creationdate, $comparison);
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
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(NotificationsTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the animalId column
     *
     * Example usage:
     * <code>
     * $query->filterByAnimalid(1234); // WHERE animalId = 1234
     * $query->filterByAnimalid(array(12, 34)); // WHERE animalId IN (12, 34)
     * $query->filterByAnimalid(array('min' => 12)); // WHERE animalId > 12
     * </code>
     *
     * @see       filterByAnimals()
     *
     * @param     mixed $animalid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByAnimalid($animalid = null, $comparison = null)
    {
        if (is_array($animalid)) {
            $useMinMax = false;
            if (isset($animalid['min'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_ANIMALID, $animalid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($animalid['max'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_ANIMALID, $animalid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationsTableMap::COL_ANIMALID, $animalid, $comparison);
    }

    /**
     * Filter the query on the longitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLongitude(1234); // WHERE longitude = 1234
     * $query->filterByLongitude(array(12, 34)); // WHERE longitude IN (12, 34)
     * $query->filterByLongitude(array('min' => 12)); // WHERE longitude > 12
     * </code>
     *
     * @param     mixed $longitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByLongitude($longitude = null, $comparison = null)
    {
        if (is_array($longitude)) {
            $useMinMax = false;
            if (isset($longitude['min'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_LONGITUDE, $longitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($longitude['max'])) {
                $this->addUsingAlias(NotificationsTableMap::COL_LONGITUDE, $longitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationsTableMap::COL_LONGITUDE, $longitude, $comparison);
    }

    /**
     * Filter the query by a related \Notificationtype object
     *
     * @param \Notificationtype|ObjectCollection $notificationtype The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByNotificationtype($notificationtype, $comparison = null)
    {
        if ($notificationtype instanceof \Notificationtype) {
            return $this
                ->addUsingAlias(NotificationsTableMap::COL_NOTIFICATIONTYPEID, $notificationtype->getNotificationtype(), $comparison);
        } elseif ($notificationtype instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NotificationsTableMap::COL_NOTIFICATIONTYPEID, $notificationtype->toKeyValue('PrimaryKey', 'Notificationtype'), $comparison);
        } else {
            throw new PropelException('filterByNotificationtype() only accepts arguments of type \Notificationtype or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Notificationtype relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function joinNotificationtype($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Notificationtype');

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
            $this->addJoinObject($join, 'Notificationtype');
        }

        return $this;
    }

    /**
     * Use the Notificationtype relation Notificationtype object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \NotificationtypeQuery A secondary query class using the current class as primary query
     */
    public function useNotificationtypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNotificationtype($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notificationtype', '\NotificationtypeQuery');
    }

    /**
     * Filter the query by a related \Animals object
     *
     * @param \Animals|ObjectCollection $animals The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterByAnimals($animals, $comparison = null)
    {
        if ($animals instanceof \Animals) {
            return $this
                ->addUsingAlias(NotificationsTableMap::COL_ANIMALID, $animals->getAnimal(), $comparison);
        } elseif ($animals instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NotificationsTableMap::COL_ANIMALID, $animals->toKeyValue('PrimaryKey', 'Animal'), $comparison);
        } else {
            throw new PropelException('filterByAnimals() only accepts arguments of type \Animals or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Animals relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function joinAnimals($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Animals');

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
            $this->addJoinObject($join, 'Animals');
        }

        return $this;
    }

    /**
     * Use the Animals relation Animals object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AnimalsQuery A secondary query class using the current class as primary query
     */
    public function useAnimalsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnimals($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Animals', '\AnimalsQuery');
    }

    /**
     * Filter the query by a related \Searchnotifications object
     *
     * @param \Searchnotifications|ObjectCollection $searchnotifications the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildNotificationsQuery The current query, for fluid interface
     */
    public function filterBySearchnotifications($searchnotifications, $comparison = null)
    {
        if ($searchnotifications instanceof \Searchnotifications) {
            return $this
                ->addUsingAlias(NotificationsTableMap::COL_NOTIFICATION, $searchnotifications->getNotification(), $comparison);
        } elseif ($searchnotifications instanceof ObjectCollection) {
            return $this
                ->useSearchnotificationsQuery()
                ->filterByPrimaryKeys($searchnotifications->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySearchnotifications() only accepts arguments of type \Searchnotifications or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Searchnotifications relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function joinSearchnotifications($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Searchnotifications');

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
            $this->addJoinObject($join, 'Searchnotifications');
        }

        return $this;
    }

    /**
     * Use the Searchnotifications relation Searchnotifications object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SearchnotificationsQuery A secondary query class using the current class as primary query
     */
    public function useSearchnotificationsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSearchnotifications($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Searchnotifications', '\SearchnotificationsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNotifications $notifications Object to remove from the list of results
     *
     * @return $this|ChildNotificationsQuery The current query, for fluid interface
     */
    public function prune($notifications = null)
    {
        if ($notifications) {
            $this->addUsingAlias(NotificationsTableMap::COL_NOTIFICATION, $notifications->getNotification(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the notifications table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NotificationsTableMap::clearInstancePool();
            NotificationsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NotificationsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NotificationsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NotificationsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NotificationsQuery

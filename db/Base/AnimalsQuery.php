<?php

namespace Base;

use \Animals as ChildAnimals;
use \AnimalsQuery as ChildAnimalsQuery;
use \Exception;
use \PDO;
use Map\AnimalsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'animals' table.
 *
 *
 *
 * @method     ChildAnimalsQuery orderByAnimal($order = Criteria::ASC) Order by the animal column
 * @method     ChildAnimalsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildAnimalsQuery orderByBirthday($order = Criteria::ASC) Order by the birthDay column
 * @method     ChildAnimalsQuery orderBySexid($order = Criteria::ASC) Order by the sexId column
 * @method     ChildAnimalsQuery orderByFurcolourid($order = Criteria::ASC) Order by the furColourId column
 * @method     ChildAnimalsQuery orderByEyecolourid($order = Criteria::ASC) Order by the eyeColourId column
 * @method     ChildAnimalsQuery orderBySpeciesid($order = Criteria::ASC) Order by the speciesId column
 * @method     ChildAnimalsQuery orderBySize($order = Criteria::ASC) Order by the size column
 * @method     ChildAnimalsQuery orderBySpecification($order = Criteria::ASC) Order by the specification column
 * @method     ChildAnimalsQuery orderByRaceid($order = Criteria::ASC) Order by the raceId column
 *
 * @method     ChildAnimalsQuery groupByAnimal() Group by the animal column
 * @method     ChildAnimalsQuery groupByName() Group by the name column
 * @method     ChildAnimalsQuery groupByBirthday() Group by the birthDay column
 * @method     ChildAnimalsQuery groupBySexid() Group by the sexId column
 * @method     ChildAnimalsQuery groupByFurcolourid() Group by the furColourId column
 * @method     ChildAnimalsQuery groupByEyecolourid() Group by the eyeColourId column
 * @method     ChildAnimalsQuery groupBySpeciesid() Group by the speciesId column
 * @method     ChildAnimalsQuery groupBySize() Group by the size column
 * @method     ChildAnimalsQuery groupBySpecification() Group by the specification column
 * @method     ChildAnimalsQuery groupByRaceid() Group by the raceId column
 *
 * @method     ChildAnimalsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAnimalsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAnimalsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAnimalsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAnimalsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAnimalsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAnimalsQuery leftJoinRaces($relationAlias = null) Adds a LEFT JOIN clause to the query using the Races relation
 * @method     ChildAnimalsQuery rightJoinRaces($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Races relation
 * @method     ChildAnimalsQuery innerJoinRaces($relationAlias = null) Adds a INNER JOIN clause to the query using the Races relation
 *
 * @method     ChildAnimalsQuery joinWithRaces($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Races relation
 *
 * @method     ChildAnimalsQuery leftJoinWithRaces() Adds a LEFT JOIN clause and with to the query using the Races relation
 * @method     ChildAnimalsQuery rightJoinWithRaces() Adds a RIGHT JOIN clause and with to the query using the Races relation
 * @method     ChildAnimalsQuery innerJoinWithRaces() Adds a INNER JOIN clause and with to the query using the Races relation
 *
 * @method     ChildAnimalsQuery leftJoinSpecies($relationAlias = null) Adds a LEFT JOIN clause to the query using the Species relation
 * @method     ChildAnimalsQuery rightJoinSpecies($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Species relation
 * @method     ChildAnimalsQuery innerJoinSpecies($relationAlias = null) Adds a INNER JOIN clause to the query using the Species relation
 *
 * @method     ChildAnimalsQuery joinWithSpecies($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Species relation
 *
 * @method     ChildAnimalsQuery leftJoinWithSpecies() Adds a LEFT JOIN clause and with to the query using the Species relation
 * @method     ChildAnimalsQuery rightJoinWithSpecies() Adds a RIGHT JOIN clause and with to the query using the Species relation
 * @method     ChildAnimalsQuery innerJoinWithSpecies() Adds a INNER JOIN clause and with to the query using the Species relation
 *
 * @method     ChildAnimalsQuery leftJoinSexes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sexes relation
 * @method     ChildAnimalsQuery rightJoinSexes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sexes relation
 * @method     ChildAnimalsQuery innerJoinSexes($relationAlias = null) Adds a INNER JOIN clause to the query using the Sexes relation
 *
 * @method     ChildAnimalsQuery joinWithSexes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sexes relation
 *
 * @method     ChildAnimalsQuery leftJoinWithSexes() Adds a LEFT JOIN clause and with to the query using the Sexes relation
 * @method     ChildAnimalsQuery rightJoinWithSexes() Adds a RIGHT JOIN clause and with to the query using the Sexes relation
 * @method     ChildAnimalsQuery innerJoinWithSexes() Adds a INNER JOIN clause and with to the query using the Sexes relation
 *
 * @method     ChildAnimalsQuery leftJoinColoursRelatedByFurcolourid($relationAlias = null) Adds a LEFT JOIN clause to the query using the ColoursRelatedByFurcolourid relation
 * @method     ChildAnimalsQuery rightJoinColoursRelatedByFurcolourid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ColoursRelatedByFurcolourid relation
 * @method     ChildAnimalsQuery innerJoinColoursRelatedByFurcolourid($relationAlias = null) Adds a INNER JOIN clause to the query using the ColoursRelatedByFurcolourid relation
 *
 * @method     ChildAnimalsQuery joinWithColoursRelatedByFurcolourid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ColoursRelatedByFurcolourid relation
 *
 * @method     ChildAnimalsQuery leftJoinWithColoursRelatedByFurcolourid() Adds a LEFT JOIN clause and with to the query using the ColoursRelatedByFurcolourid relation
 * @method     ChildAnimalsQuery rightJoinWithColoursRelatedByFurcolourid() Adds a RIGHT JOIN clause and with to the query using the ColoursRelatedByFurcolourid relation
 * @method     ChildAnimalsQuery innerJoinWithColoursRelatedByFurcolourid() Adds a INNER JOIN clause and with to the query using the ColoursRelatedByFurcolourid relation
 *
 * @method     ChildAnimalsQuery leftJoinColoursRelatedByEyecolourid($relationAlias = null) Adds a LEFT JOIN clause to the query using the ColoursRelatedByEyecolourid relation
 * @method     ChildAnimalsQuery rightJoinColoursRelatedByEyecolourid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ColoursRelatedByEyecolourid relation
 * @method     ChildAnimalsQuery innerJoinColoursRelatedByEyecolourid($relationAlias = null) Adds a INNER JOIN clause to the query using the ColoursRelatedByEyecolourid relation
 *
 * @method     ChildAnimalsQuery joinWithColoursRelatedByEyecolourid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ColoursRelatedByEyecolourid relation
 *
 * @method     ChildAnimalsQuery leftJoinWithColoursRelatedByEyecolourid() Adds a LEFT JOIN clause and with to the query using the ColoursRelatedByEyecolourid relation
 * @method     ChildAnimalsQuery rightJoinWithColoursRelatedByEyecolourid() Adds a RIGHT JOIN clause and with to the query using the ColoursRelatedByEyecolourid relation
 * @method     ChildAnimalsQuery innerJoinWithColoursRelatedByEyecolourid() Adds a INNER JOIN clause and with to the query using the ColoursRelatedByEyecolourid relation
 *
 * @method     ChildAnimalsQuery leftJoinNotifications($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notifications relation
 * @method     ChildAnimalsQuery rightJoinNotifications($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notifications relation
 * @method     ChildAnimalsQuery innerJoinNotifications($relationAlias = null) Adds a INNER JOIN clause to the query using the Notifications relation
 *
 * @method     ChildAnimalsQuery joinWithNotifications($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Notifications relation
 *
 * @method     ChildAnimalsQuery leftJoinWithNotifications() Adds a LEFT JOIN clause and with to the query using the Notifications relation
 * @method     ChildAnimalsQuery rightJoinWithNotifications() Adds a RIGHT JOIN clause and with to the query using the Notifications relation
 * @method     ChildAnimalsQuery innerJoinWithNotifications() Adds a INNER JOIN clause and with to the query using the Notifications relation
 *
 * @method     \RacesQuery|\SpeciesQuery|\SexesQuery|\ColoursQuery|\NotificationsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAnimals findOne(ConnectionInterface $con = null) Return the first ChildAnimals matching the query
 * @method     ChildAnimals findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAnimals matching the query, or a new ChildAnimals object populated from the query conditions when no match is found
 *
 * @method     ChildAnimals findOneByAnimal(int $animal) Return the first ChildAnimals filtered by the animal column
 * @method     ChildAnimals findOneByName(string $name) Return the first ChildAnimals filtered by the name column
 * @method     ChildAnimals findOneByBirthday(string $birthDay) Return the first ChildAnimals filtered by the birthDay column
 * @method     ChildAnimals findOneBySexid(int $sexId) Return the first ChildAnimals filtered by the sexId column
 * @method     ChildAnimals findOneByFurcolourid(int $furColourId) Return the first ChildAnimals filtered by the furColourId column
 * @method     ChildAnimals findOneByEyecolourid(int $eyeColourId) Return the first ChildAnimals filtered by the eyeColourId column
 * @method     ChildAnimals findOneBySpeciesid(int $speciesId) Return the first ChildAnimals filtered by the speciesId column
 * @method     ChildAnimals findOneBySize(int $size) Return the first ChildAnimals filtered by the size column
 * @method     ChildAnimals findOneBySpecification(string $specification) Return the first ChildAnimals filtered by the specification column
 * @method     ChildAnimals findOneByRaceid(int $raceId) Return the first ChildAnimals filtered by the raceId column *

 * @method     ChildAnimals requirePk($key, ConnectionInterface $con = null) Return the ChildAnimals by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOne(ConnectionInterface $con = null) Return the first ChildAnimals matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnimals requireOneByAnimal(int $animal) Return the first ChildAnimals filtered by the animal column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneByName(string $name) Return the first ChildAnimals filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneByBirthday(string $birthDay) Return the first ChildAnimals filtered by the birthDay column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneBySexid(int $sexId) Return the first ChildAnimals filtered by the sexId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneByFurcolourid(int $furColourId) Return the first ChildAnimals filtered by the furColourId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneByEyecolourid(int $eyeColourId) Return the first ChildAnimals filtered by the eyeColourId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneBySpeciesid(int $speciesId) Return the first ChildAnimals filtered by the speciesId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneBySize(int $size) Return the first ChildAnimals filtered by the size column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneBySpecification(string $specification) Return the first ChildAnimals filtered by the specification column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimals requireOneByRaceid(int $raceId) Return the first ChildAnimals filtered by the raceId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnimals[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAnimals objects based on current ModelCriteria
 * @method     ChildAnimals[]|ObjectCollection findByAnimal(int $animal) Return ChildAnimals objects filtered by the animal column
 * @method     ChildAnimals[]|ObjectCollection findByName(string $name) Return ChildAnimals objects filtered by the name column
 * @method     ChildAnimals[]|ObjectCollection findByBirthday(string $birthDay) Return ChildAnimals objects filtered by the birthDay column
 * @method     ChildAnimals[]|ObjectCollection findBySexid(int $sexId) Return ChildAnimals objects filtered by the sexId column
 * @method     ChildAnimals[]|ObjectCollection findByFurcolourid(int $furColourId) Return ChildAnimals objects filtered by the furColourId column
 * @method     ChildAnimals[]|ObjectCollection findByEyecolourid(int $eyeColourId) Return ChildAnimals objects filtered by the eyeColourId column
 * @method     ChildAnimals[]|ObjectCollection findBySpeciesid(int $speciesId) Return ChildAnimals objects filtered by the speciesId column
 * @method     ChildAnimals[]|ObjectCollection findBySize(int $size) Return ChildAnimals objects filtered by the size column
 * @method     ChildAnimals[]|ObjectCollection findBySpecification(string $specification) Return ChildAnimals objects filtered by the specification column
 * @method     ChildAnimals[]|ObjectCollection findByRaceid(int $raceId) Return ChildAnimals objects filtered by the raceId column
 * @method     ChildAnimals[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AnimalsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AnimalsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Animals', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAnimalsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAnimalsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAnimalsQuery) {
            return $criteria;
        }
        $query = new ChildAnimalsQuery();
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
     * @return ChildAnimals|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AnimalsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AnimalsTableMap::DATABASE_NAME);
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
     * @return ChildAnimals A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT animal, name, birthDay, sexId, furColourId, eyeColourId, speciesId, size, specification, raceId FROM animals WHERE animal = :p0';
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
            /** @var ChildAnimals $obj */
            $obj = new ChildAnimals();
            $obj->hydrate($row);
            AnimalsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAnimals|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnimalsTableMap::COL_ANIMAL, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnimalsTableMap::COL_ANIMAL, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the animal column
     *
     * Example usage:
     * <code>
     * $query->filterByAnimal(1234); // WHERE animal = 1234
     * $query->filterByAnimal(array(12, 34)); // WHERE animal IN (12, 34)
     * $query->filterByAnimal(array('min' => 12)); // WHERE animal > 12
     * </code>
     *
     * @param     mixed $animal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByAnimal($animal = null, $comparison = null)
    {
        if (is_array($animal)) {
            $useMinMax = false;
            if (isset($animal['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_ANIMAL, $animal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($animal['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_ANIMAL, $animal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_ANIMAL, $animal, $comparison);
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
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AnimalsTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the birthDay column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthday('2011-03-14'); // WHERE birthDay = '2011-03-14'
     * $query->filterByBirthday('now'); // WHERE birthDay = '2011-03-14'
     * $query->filterByBirthday(array('max' => 'yesterday')); // WHERE birthDay > '2011-03-13'
     * </code>
     *
     * @param     mixed $birthday The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByBirthday($birthday = null, $comparison = null)
    {
        if (is_array($birthday)) {
            $useMinMax = false;
            if (isset($birthday['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_BIRTHDAY, $birthday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthday['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_BIRTHDAY, $birthday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_BIRTHDAY, $birthday, $comparison);
    }

    /**
     * Filter the query on the sexId column
     *
     * Example usage:
     * <code>
     * $query->filterBySexid(1234); // WHERE sexId = 1234
     * $query->filterBySexid(array(12, 34)); // WHERE sexId IN (12, 34)
     * $query->filterBySexid(array('min' => 12)); // WHERE sexId > 12
     * </code>
     *
     * @see       filterBySexes()
     *
     * @param     mixed $sexid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterBySexid($sexid = null, $comparison = null)
    {
        if (is_array($sexid)) {
            $useMinMax = false;
            if (isset($sexid['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_SEXID, $sexid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sexid['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_SEXID, $sexid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_SEXID, $sexid, $comparison);
    }

    /**
     * Filter the query on the furColourId column
     *
     * Example usage:
     * <code>
     * $query->filterByFurcolourid(1234); // WHERE furColourId = 1234
     * $query->filterByFurcolourid(array(12, 34)); // WHERE furColourId IN (12, 34)
     * $query->filterByFurcolourid(array('min' => 12)); // WHERE furColourId > 12
     * </code>
     *
     * @see       filterByColoursRelatedByFurcolourid()
     *
     * @param     mixed $furcolourid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByFurcolourid($furcolourid = null, $comparison = null)
    {
        if (is_array($furcolourid)) {
            $useMinMax = false;
            if (isset($furcolourid['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_FURCOLOURID, $furcolourid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($furcolourid['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_FURCOLOURID, $furcolourid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_FURCOLOURID, $furcolourid, $comparison);
    }

    /**
     * Filter the query on the eyeColourId column
     *
     * Example usage:
     * <code>
     * $query->filterByEyecolourid(1234); // WHERE eyeColourId = 1234
     * $query->filterByEyecolourid(array(12, 34)); // WHERE eyeColourId IN (12, 34)
     * $query->filterByEyecolourid(array('min' => 12)); // WHERE eyeColourId > 12
     * </code>
     *
     * @see       filterByColoursRelatedByEyecolourid()
     *
     * @param     mixed $eyecolourid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByEyecolourid($eyecolourid = null, $comparison = null)
    {
        if (is_array($eyecolourid)) {
            $useMinMax = false;
            if (isset($eyecolourid['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_EYECOLOURID, $eyecolourid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eyecolourid['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_EYECOLOURID, $eyecolourid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_EYECOLOURID, $eyecolourid, $comparison);
    }

    /**
     * Filter the query on the speciesId column
     *
     * Example usage:
     * <code>
     * $query->filterBySpeciesid(1234); // WHERE speciesId = 1234
     * $query->filterBySpeciesid(array(12, 34)); // WHERE speciesId IN (12, 34)
     * $query->filterBySpeciesid(array('min' => 12)); // WHERE speciesId > 12
     * </code>
     *
     * @see       filterBySpecies()
     *
     * @param     mixed $speciesid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterBySpeciesid($speciesid = null, $comparison = null)
    {
        if (is_array($speciesid)) {
            $useMinMax = false;
            if (isset($speciesid['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_SPECIESID, $speciesid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($speciesid['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_SPECIESID, $speciesid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_SPECIESID, $speciesid, $comparison);
    }

    /**
     * Filter the query on the size column
     *
     * Example usage:
     * <code>
     * $query->filterBySize(1234); // WHERE size = 1234
     * $query->filterBySize(array(12, 34)); // WHERE size IN (12, 34)
     * $query->filterBySize(array('min' => 12)); // WHERE size > 12
     * </code>
     *
     * @param     mixed $size The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterBySize($size = null, $comparison = null)
    {
        if (is_array($size)) {
            $useMinMax = false;
            if (isset($size['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_SIZE, $size['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($size['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_SIZE, $size['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_SIZE, $size, $comparison);
    }

    /**
     * Filter the query on the specification column
     *
     * Example usage:
     * <code>
     * $query->filterBySpecification('fooValue');   // WHERE specification = 'fooValue'
     * $query->filterBySpecification('%fooValue%'); // WHERE specification LIKE '%fooValue%'
     * </code>
     *
     * @param     string $specification The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterBySpecification($specification = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($specification)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $specification)) {
                $specification = str_replace('*', '%', $specification);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_SPECIFICATION, $specification, $comparison);
    }

    /**
     * Filter the query on the raceId column
     *
     * Example usage:
     * <code>
     * $query->filterByRaceid(1234); // WHERE raceId = 1234
     * $query->filterByRaceid(array(12, 34)); // WHERE raceId IN (12, 34)
     * $query->filterByRaceid(array('min' => 12)); // WHERE raceId > 12
     * </code>
     *
     * @see       filterByRaces()
     *
     * @param     mixed $raceid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByRaceid($raceid = null, $comparison = null)
    {
        if (is_array($raceid)) {
            $useMinMax = false;
            if (isset($raceid['min'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_RACEID, $raceid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($raceid['max'])) {
                $this->addUsingAlias(AnimalsTableMap::COL_RACEID, $raceid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimalsTableMap::COL_RACEID, $raceid, $comparison);
    }

    /**
     * Filter the query by a related \Races object
     *
     * @param \Races|ObjectCollection $races The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByRaces($races, $comparison = null)
    {
        if ($races instanceof \Races) {
            return $this
                ->addUsingAlias(AnimalsTableMap::COL_RACEID, $races->getRace(), $comparison);
        } elseif ($races instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnimalsTableMap::COL_RACEID, $races->toKeyValue('PrimaryKey', 'Race'), $comparison);
        } else {
            throw new PropelException('filterByRaces() only accepts arguments of type \Races or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Races relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function joinRaces($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Races');

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
            $this->addJoinObject($join, 'Races');
        }

        return $this;
    }

    /**
     * Use the Races relation Races object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RacesQuery A secondary query class using the current class as primary query
     */
    public function useRacesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRaces($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Races', '\RacesQuery');
    }

    /**
     * Filter the query by a related \Species object
     *
     * @param \Species|ObjectCollection $species The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterBySpecies($species, $comparison = null)
    {
        if ($species instanceof \Species) {
            return $this
                ->addUsingAlias(AnimalsTableMap::COL_SPECIESID, $species->getSpecies(), $comparison);
        } elseif ($species instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnimalsTableMap::COL_SPECIESID, $species->toKeyValue('PrimaryKey', 'Species'), $comparison);
        } else {
            throw new PropelException('filterBySpecies() only accepts arguments of type \Species or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Species relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function joinSpecies($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Species');

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
            $this->addJoinObject($join, 'Species');
        }

        return $this;
    }

    /**
     * Use the Species relation Species object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SpeciesQuery A secondary query class using the current class as primary query
     */
    public function useSpeciesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSpecies($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Species', '\SpeciesQuery');
    }

    /**
     * Filter the query by a related \Sexes object
     *
     * @param \Sexes|ObjectCollection $sexes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterBySexes($sexes, $comparison = null)
    {
        if ($sexes instanceof \Sexes) {
            return $this
                ->addUsingAlias(AnimalsTableMap::COL_SEXID, $sexes->getSex(), $comparison);
        } elseif ($sexes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnimalsTableMap::COL_SEXID, $sexes->toKeyValue('PrimaryKey', 'Sex'), $comparison);
        } else {
            throw new PropelException('filterBySexes() only accepts arguments of type \Sexes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sexes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function joinSexes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sexes');

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
            $this->addJoinObject($join, 'Sexes');
        }

        return $this;
    }

    /**
     * Use the Sexes relation Sexes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SexesQuery A secondary query class using the current class as primary query
     */
    public function useSexesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSexes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sexes', '\SexesQuery');
    }

    /**
     * Filter the query by a related \Colours object
     *
     * @param \Colours|ObjectCollection $colours The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByColoursRelatedByFurcolourid($colours, $comparison = null)
    {
        if ($colours instanceof \Colours) {
            return $this
                ->addUsingAlias(AnimalsTableMap::COL_FURCOLOURID, $colours->getColour(), $comparison);
        } elseif ($colours instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnimalsTableMap::COL_FURCOLOURID, $colours->toKeyValue('PrimaryKey', 'Colour'), $comparison);
        } else {
            throw new PropelException('filterByColoursRelatedByFurcolourid() only accepts arguments of type \Colours or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ColoursRelatedByFurcolourid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function joinColoursRelatedByFurcolourid($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ColoursRelatedByFurcolourid');

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
            $this->addJoinObject($join, 'ColoursRelatedByFurcolourid');
        }

        return $this;
    }

    /**
     * Use the ColoursRelatedByFurcolourid relation Colours object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ColoursQuery A secondary query class using the current class as primary query
     */
    public function useColoursRelatedByFurcolouridQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinColoursRelatedByFurcolourid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ColoursRelatedByFurcolourid', '\ColoursQuery');
    }

    /**
     * Filter the query by a related \Colours object
     *
     * @param \Colours|ObjectCollection $colours The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByColoursRelatedByEyecolourid($colours, $comparison = null)
    {
        if ($colours instanceof \Colours) {
            return $this
                ->addUsingAlias(AnimalsTableMap::COL_EYECOLOURID, $colours->getColour(), $comparison);
        } elseif ($colours instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnimalsTableMap::COL_EYECOLOURID, $colours->toKeyValue('PrimaryKey', 'Colour'), $comparison);
        } else {
            throw new PropelException('filterByColoursRelatedByEyecolourid() only accepts arguments of type \Colours or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ColoursRelatedByEyecolourid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function joinColoursRelatedByEyecolourid($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ColoursRelatedByEyecolourid');

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
            $this->addJoinObject($join, 'ColoursRelatedByEyecolourid');
        }

        return $this;
    }

    /**
     * Use the ColoursRelatedByEyecolourid relation Colours object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ColoursQuery A secondary query class using the current class as primary query
     */
    public function useColoursRelatedByEyecolouridQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinColoursRelatedByEyecolourid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ColoursRelatedByEyecolourid', '\ColoursQuery');
    }

    /**
     * Filter the query by a related \Notifications object
     *
     * @param \Notifications|ObjectCollection $notifications the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAnimalsQuery The current query, for fluid interface
     */
    public function filterByNotifications($notifications, $comparison = null)
    {
        if ($notifications instanceof \Notifications) {
            return $this
                ->addUsingAlias(AnimalsTableMap::COL_ANIMAL, $notifications->getAnimalid(), $comparison);
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
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
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
     * @param   ChildAnimals $animals Object to remove from the list of results
     *
     * @return $this|ChildAnimalsQuery The current query, for fluid interface
     */
    public function prune($animals = null)
    {
        if ($animals) {
            $this->addUsingAlias(AnimalsTableMap::COL_ANIMAL, $animals->getAnimal(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the animals table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AnimalsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AnimalsTableMap::clearInstancePool();
            AnimalsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AnimalsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AnimalsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AnimalsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AnimalsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AnimalsQuery

<?php

namespace Map;

use \Searchnotifications;
use \SearchnotificationsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'searchNotifications' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SearchnotificationsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SearchnotificationsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'searchNotifications';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Searchnotifications';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Searchnotifications';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the searchNotification field
     */
    const COL_SEARCHNOTIFICATION = 'searchNotifications.searchNotification';

    /**
     * the column name for the notification field
     */
    const COL_NOTIFICATION = 'searchNotifications.notification';

    /**
     * the column name for the missingDate field
     */
    const COL_MISSINGDATE = 'searchNotifications.missingDate';

    /**
     * the column name for the additionalInformation field
     */
    const COL_ADDITIONALINFORMATION = 'searchNotifications.additionalInformation';

    /**
     * the column name for the reward field
     */
    const COL_REWARD = 'searchNotifications.reward';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Searchnotification', 'Notification', 'Missingdate', 'Additionalinformation', 'Reward', ),
        self::TYPE_CAMELNAME     => array('searchnotification', 'notification', 'missingdate', 'additionalinformation', 'reward', ),
        self::TYPE_COLNAME       => array(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, SearchnotificationsTableMap::COL_NOTIFICATION, SearchnotificationsTableMap::COL_MISSINGDATE, SearchnotificationsTableMap::COL_ADDITIONALINFORMATION, SearchnotificationsTableMap::COL_REWARD, ),
        self::TYPE_FIELDNAME     => array('searchNotification', 'notification', 'missingDate', 'additionalInformation', 'reward', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Searchnotification' => 0, 'Notification' => 1, 'Missingdate' => 2, 'Additionalinformation' => 3, 'Reward' => 4, ),
        self::TYPE_CAMELNAME     => array('searchnotification' => 0, 'notification' => 1, 'missingdate' => 2, 'additionalinformation' => 3, 'reward' => 4, ),
        self::TYPE_COLNAME       => array(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION => 0, SearchnotificationsTableMap::COL_NOTIFICATION => 1, SearchnotificationsTableMap::COL_MISSINGDATE => 2, SearchnotificationsTableMap::COL_ADDITIONALINFORMATION => 3, SearchnotificationsTableMap::COL_REWARD => 4, ),
        self::TYPE_FIELDNAME     => array('searchNotification' => 0, 'notification' => 1, 'missingDate' => 2, 'additionalInformation' => 3, 'reward' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('searchNotifications');
        $this->setPhpName('Searchnotifications');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Searchnotifications');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('searchNotification', 'Searchnotification', 'INTEGER', true, 10, null);
        $this->addForeignKey('notification', 'Notification', 'INTEGER', 'notifications', 'notification', true, 10, null);
        $this->addColumn('missingDate', 'Missingdate', 'DATE', true, null, null);
        $this->addColumn('additionalInformation', 'Additionalinformation', 'VARCHAR', true, 1024, null);
        $this->addColumn('reward', 'Reward', 'INTEGER', true, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Notifications', '\\Notifications', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':notification',
    1 => ':notification',
  ),
), null, 'CASCADE', null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Searchnotification', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Searchnotification', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Searchnotification', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SearchnotificationsTableMap::CLASS_DEFAULT : SearchnotificationsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Searchnotifications object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SearchnotificationsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SearchnotificationsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SearchnotificationsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SearchnotificationsTableMap::OM_CLASS;
            /** @var Searchnotifications $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SearchnotificationsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SearchnotificationsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SearchnotificationsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Searchnotifications $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SearchnotificationsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION);
            $criteria->addSelectColumn(SearchnotificationsTableMap::COL_NOTIFICATION);
            $criteria->addSelectColumn(SearchnotificationsTableMap::COL_MISSINGDATE);
            $criteria->addSelectColumn(SearchnotificationsTableMap::COL_ADDITIONALINFORMATION);
            $criteria->addSelectColumn(SearchnotificationsTableMap::COL_REWARD);
        } else {
            $criteria->addSelectColumn($alias . '.searchNotification');
            $criteria->addSelectColumn($alias . '.notification');
            $criteria->addSelectColumn($alias . '.missingDate');
            $criteria->addSelectColumn($alias . '.additionalInformation');
            $criteria->addSelectColumn($alias . '.reward');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SearchnotificationsTableMap::DATABASE_NAME)->getTable(SearchnotificationsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SearchnotificationsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SearchnotificationsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SearchnotificationsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Searchnotifications or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Searchnotifications object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SearchnotificationsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Searchnotifications) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SearchnotificationsTableMap::DATABASE_NAME);
            $criteria->add(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION, (array) $values, Criteria::IN);
        }

        $query = SearchnotificationsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SearchnotificationsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SearchnotificationsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the searchNotifications table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SearchnotificationsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Searchnotifications or Criteria object.
     *
     * @param mixed               $criteria Criteria or Searchnotifications object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SearchnotificationsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Searchnotifications object
        }

        if ($criteria->containsKey(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION) && $criteria->keyContainsValue(SearchnotificationsTableMap::COL_SEARCHNOTIFICATION) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SearchnotificationsTableMap::COL_SEARCHNOTIFICATION.')');
        }


        // Set the correct dbName
        $query = SearchnotificationsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SearchnotificationsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SearchnotificationsTableMap::buildTableMap();

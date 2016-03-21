<?php

namespace Map;

use \Notifications;
use \NotificationsQuery;
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
 * This class defines the structure of the 'notifications' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class NotificationsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.NotificationsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'notifications';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Notifications';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Notifications';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the notification field
     */
    const COL_NOTIFICATION = 'notifications.notification';

    /**
     * the column name for the latitude field
     */
    const COL_LATITUDE = 'notifications.latitude';

    /**
     * the column name for the notificationTypeId field
     */
    const COL_NOTIFICATIONTYPEID = 'notifications.notificationTypeId';

    /**
     * the column name for the creationDate field
     */
    const COL_CREATIONDATE = 'notifications.creationDate';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'notifications.description';

    /**
     * the column name for the animalId field
     */
    const COL_ANIMALID = 'notifications.animalId';

    /**
     * the column name for the longitude field
     */
    const COL_LONGITUDE = 'notifications.longitude';

    /**
     * the column name for the location field
     */
    const COL_LOCATION = 'notifications.location';

    /**
     * the column name for the user field
     */
    const COL_USER = 'notifications.user';

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
        self::TYPE_PHPNAME       => array('Notification', 'Latitude', 'Notificationtypeid', 'Creationdate', 'Description', 'Animalid', 'Longitude', 'Location', 'User', ),
        self::TYPE_CAMELNAME     => array('notification', 'latitude', 'notificationtypeid', 'creationdate', 'description', 'animalid', 'longitude', 'location', 'user', ),
        self::TYPE_COLNAME       => array(NotificationsTableMap::COL_NOTIFICATION, NotificationsTableMap::COL_LATITUDE, NotificationsTableMap::COL_NOTIFICATIONTYPEID, NotificationsTableMap::COL_CREATIONDATE, NotificationsTableMap::COL_DESCRIPTION, NotificationsTableMap::COL_ANIMALID, NotificationsTableMap::COL_LONGITUDE, NotificationsTableMap::COL_LOCATION, NotificationsTableMap::COL_USER, ),
        self::TYPE_FIELDNAME     => array('notification', 'latitude', 'notificationTypeId', 'creationDate', 'description', 'animalId', 'longitude', 'location', 'user', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Notification' => 0, 'Latitude' => 1, 'Notificationtypeid' => 2, 'Creationdate' => 3, 'Description' => 4, 'Animalid' => 5, 'Longitude' => 6, 'Location' => 7, 'User' => 8, ),
        self::TYPE_CAMELNAME     => array('notification' => 0, 'latitude' => 1, 'notificationtypeid' => 2, 'creationdate' => 3, 'description' => 4, 'animalid' => 5, 'longitude' => 6, 'location' => 7, 'user' => 8, ),
        self::TYPE_COLNAME       => array(NotificationsTableMap::COL_NOTIFICATION => 0, NotificationsTableMap::COL_LATITUDE => 1, NotificationsTableMap::COL_NOTIFICATIONTYPEID => 2, NotificationsTableMap::COL_CREATIONDATE => 3, NotificationsTableMap::COL_DESCRIPTION => 4, NotificationsTableMap::COL_ANIMALID => 5, NotificationsTableMap::COL_LONGITUDE => 6, NotificationsTableMap::COL_LOCATION => 7, NotificationsTableMap::COL_USER => 8, ),
        self::TYPE_FIELDNAME     => array('notification' => 0, 'latitude' => 1, 'notificationTypeId' => 2, 'creationDate' => 3, 'description' => 4, 'animalId' => 5, 'longitude' => 6, 'location' => 7, 'user' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('notifications');
        $this->setPhpName('Notifications');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Notifications');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('notification', 'Notification', 'INTEGER', true, 10, null);
        $this->addColumn('latitude', 'Latitude', 'DOUBLE', true, null, null);
        $this->addForeignKey('notificationTypeId', 'Notificationtypeid', 'INTEGER', 'notificationType', 'notificationType', true, 10, null);
        $this->addColumn('creationDate', 'Creationdate', 'DATE', true, null, null);
        $this->addColumn('description', 'Description', 'VARCHAR', true, 2048, null);
        $this->addForeignKey('animalId', 'Animalid', 'INTEGER', 'animals', 'animal', true, null, null);
        $this->addColumn('longitude', 'Longitude', 'DOUBLE', true, null, null);
        $this->addColumn('location', 'Location', 'VARCHAR', true, 255, null);
        $this->addForeignKey('user', 'User', 'INTEGER', 'users', 'user', true, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Notificationtype', '\\Notificationtype', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':notificationTypeId',
    1 => ':notificationType',
  ),
), null, 'CASCADE', null, false);
        $this->addRelation('Animals', '\\Animals', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':animalId',
    1 => ':animal',
  ),
), null, 'CASCADE', null, false);
        $this->addRelation('Users', '\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user',
    1 => ':user',
  ),
), null, null, null, false);
        $this->addRelation('Searchnotifications', '\\Searchnotifications', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':notification',
    1 => ':notification',
  ),
), null, 'CASCADE', 'Searchnotificationss', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? NotificationsTableMap::CLASS_DEFAULT : NotificationsTableMap::OM_CLASS;
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
     * @return array           (Notifications object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = NotificationsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = NotificationsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + NotificationsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = NotificationsTableMap::OM_CLASS;
            /** @var Notifications $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            NotificationsTableMap::addInstanceToPool($obj, $key);
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
            $key = NotificationsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = NotificationsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Notifications $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                NotificationsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(NotificationsTableMap::COL_NOTIFICATION);
            $criteria->addSelectColumn(NotificationsTableMap::COL_LATITUDE);
            $criteria->addSelectColumn(NotificationsTableMap::COL_NOTIFICATIONTYPEID);
            $criteria->addSelectColumn(NotificationsTableMap::COL_CREATIONDATE);
            $criteria->addSelectColumn(NotificationsTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(NotificationsTableMap::COL_ANIMALID);
            $criteria->addSelectColumn(NotificationsTableMap::COL_LONGITUDE);
            $criteria->addSelectColumn(NotificationsTableMap::COL_LOCATION);
            $criteria->addSelectColumn(NotificationsTableMap::COL_USER);
        } else {
            $criteria->addSelectColumn($alias . '.notification');
            $criteria->addSelectColumn($alias . '.latitude');
            $criteria->addSelectColumn($alias . '.notificationTypeId');
            $criteria->addSelectColumn($alias . '.creationDate');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.animalId');
            $criteria->addSelectColumn($alias . '.longitude');
            $criteria->addSelectColumn($alias . '.location');
            $criteria->addSelectColumn($alias . '.user');
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
        return Propel::getServiceContainer()->getDatabaseMap(NotificationsTableMap::DATABASE_NAME)->getTable(NotificationsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(NotificationsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(NotificationsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new NotificationsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Notifications or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Notifications object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Notifications) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(NotificationsTableMap::DATABASE_NAME);
            $criteria->add(NotificationsTableMap::COL_NOTIFICATION, (array) $values, Criteria::IN);
        }

        $query = NotificationsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            NotificationsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                NotificationsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the notifications table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return NotificationsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Notifications or Criteria object.
     *
     * @param mixed               $criteria Criteria or Notifications object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Notifications object
        }

        if ($criteria->containsKey(NotificationsTableMap::COL_NOTIFICATION) && $criteria->keyContainsValue(NotificationsTableMap::COL_NOTIFICATION) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.NotificationsTableMap::COL_NOTIFICATION.')');
        }


        // Set the correct dbName
        $query = NotificationsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // NotificationsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
NotificationsTableMap::buildTableMap();

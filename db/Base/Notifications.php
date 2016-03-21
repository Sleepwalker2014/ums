<?php

namespace Base;

use \Animals as ChildAnimals;
use \AnimalsQuery as ChildAnimalsQuery;
use \Notifications as ChildNotifications;
use \NotificationsQuery as ChildNotificationsQuery;
use \Notificationtype as ChildNotificationtype;
use \NotificationtypeQuery as ChildNotificationtypeQuery;
use \Searchnotifications as ChildSearchnotifications;
use \SearchnotificationsQuery as ChildSearchnotificationsQuery;
use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\NotificationsTableMap;
use Map\SearchnotificationsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'notifications' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Notifications implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\NotificationsTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the notification field.
     *
     * @var        int
     */
    protected $notification;

    /**
     * The value for the latitude field.
     *
     * @var        double
     */
    protected $latitude;

    /**
     * The value for the notificationtypeid field.
     *
     * @var        int
     */
    protected $notificationtypeid;

    /**
     * The value for the creationdate field.
     *
     * @var        \DateTime
     */
    protected $creationdate;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the animalid field.
     *
     * @var        int
     */
    protected $animalid;

    /**
     * The value for the longitude field.
     *
     * @var        double
     */
    protected $longitude;

    /**
     * The value for the location field.
     *
     * @var        string
     */
    protected $location;

    /**
     * The value for the user field.
     *
     * @var        int
     */
    protected $user;

    /**
     * @var        ChildNotificationtype
     */
    protected $aNotificationtype;

    /**
     * @var        ChildAnimals
     */
    protected $aAnimals;

    /**
     * @var        ChildUsers
     */
    protected $aUsers;

    /**
     * @var        ObjectCollection|ChildSearchnotifications[] Collection to store aggregation of ChildSearchnotifications objects.
     */
    protected $collSearchnotificationss;
    protected $collSearchnotificationssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSearchnotifications[]
     */
    protected $searchnotificationssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Notifications object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Notifications</code> instance.  If
     * <code>obj</code> is an instance of <code>Notifications</code>, delegates to
     * <code>equals(Notifications)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Notifications The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [notification] column value.
     *
     * @return int
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Get the [latitude] column value.
     *
     * @return double
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Get the [notificationtypeid] column value.
     *
     * @return int
     */
    public function getNotificationtypeid()
    {
        return $this->notificationtypeid;
    }

    /**
     * Get the [optionally formatted] temporal [creationdate] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreationdate($format = NULL)
    {
        if ($format === null) {
            return $this->creationdate;
        } else {
            return $this->creationdate instanceof \DateTime ? $this->creationdate->format($format) : null;
        }
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [animalid] column value.
     *
     * @return int
     */
    public function getAnimalid()
    {
        return $this->animalid;
    }

    /**
     * Get the [longitude] column value.
     *
     * @return double
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Get the [location] column value.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get the [user] column value.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of [notification] column.
     *
     * @param int $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setNotification($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->notification !== $v) {
            $this->notification = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_NOTIFICATION] = true;
        }

        return $this;
    } // setNotification()

    /**
     * Set the value of [latitude] column.
     *
     * @param double $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setLatitude($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->latitude !== $v) {
            $this->latitude = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_LATITUDE] = true;
        }

        return $this;
    } // setLatitude()

    /**
     * Set the value of [notificationtypeid] column.
     *
     * @param int $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setNotificationtypeid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->notificationtypeid !== $v) {
            $this->notificationtypeid = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_NOTIFICATIONTYPEID] = true;
        }

        if ($this->aNotificationtype !== null && $this->aNotificationtype->getNotificationtype() !== $v) {
            $this->aNotificationtype = null;
        }

        return $this;
    } // setNotificationtypeid()

    /**
     * Sets the value of [creationdate] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setCreationdate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->creationdate !== null || $dt !== null) {
            if ($this->creationdate === null || $dt === null || $dt->format("Y-m-d") !== $this->creationdate->format("Y-m-d")) {
                $this->creationdate = $dt === null ? null : clone $dt;
                $this->modifiedColumns[NotificationsTableMap::COL_CREATIONDATE] = true;
            }
        } // if either are not null

        return $this;
    } // setCreationdate()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [animalid] column.
     *
     * @param int $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setAnimalid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->animalid !== $v) {
            $this->animalid = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_ANIMALID] = true;
        }

        if ($this->aAnimals !== null && $this->aAnimals->getAnimal() !== $v) {
            $this->aAnimals = null;
        }

        return $this;
    } // setAnimalid()

    /**
     * Set the value of [longitude] column.
     *
     * @param double $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setLongitude($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->longitude !== $v) {
            $this->longitude = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_LONGITUDE] = true;
        }

        return $this;
    } // setLongitude()

    /**
     * Set the value of [location] column.
     *
     * @param string $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setLocation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->location !== $v) {
            $this->location = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_LOCATION] = true;
        }

        return $this;
    } // setLocation()

    /**
     * Set the value of [user] column.
     *
     * @param int $v new value
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function setUser($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user !== $v) {
            $this->user = $v;
            $this->modifiedColumns[NotificationsTableMap::COL_USER] = true;
        }

        if ($this->aUsers !== null && $this->aUsers->getUser() !== $v) {
            $this->aUsers = null;
        }

        return $this;
    } // setUser()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : NotificationsTableMap::translateFieldName('Notification', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notification = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : NotificationsTableMap::translateFieldName('Latitude', TableMap::TYPE_PHPNAME, $indexType)];
            $this->latitude = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : NotificationsTableMap::translateFieldName('Notificationtypeid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notificationtypeid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : NotificationsTableMap::translateFieldName('Creationdate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->creationdate = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : NotificationsTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : NotificationsTableMap::translateFieldName('Animalid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->animalid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : NotificationsTableMap::translateFieldName('Longitude', TableMap::TYPE_PHPNAME, $indexType)];
            $this->longitude = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : NotificationsTableMap::translateFieldName('Location', TableMap::TYPE_PHPNAME, $indexType)];
            $this->location = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : NotificationsTableMap::translateFieldName('User', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = NotificationsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Notifications'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aNotificationtype !== null && $this->notificationtypeid !== $this->aNotificationtype->getNotificationtype()) {
            $this->aNotificationtype = null;
        }
        if ($this->aAnimals !== null && $this->animalid !== $this->aAnimals->getAnimal()) {
            $this->aAnimals = null;
        }
        if ($this->aUsers !== null && $this->user !== $this->aUsers->getUser()) {
            $this->aUsers = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildNotificationsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aNotificationtype = null;
            $this->aAnimals = null;
            $this->aUsers = null;
            $this->collSearchnotificationss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Notifications::setDeleted()
     * @see Notifications::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildNotificationsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                NotificationsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aNotificationtype !== null) {
                if ($this->aNotificationtype->isModified() || $this->aNotificationtype->isNew()) {
                    $affectedRows += $this->aNotificationtype->save($con);
                }
                $this->setNotificationtype($this->aNotificationtype);
            }

            if ($this->aAnimals !== null) {
                if ($this->aAnimals->isModified() || $this->aAnimals->isNew()) {
                    $affectedRows += $this->aAnimals->save($con);
                }
                $this->setAnimals($this->aAnimals);
            }

            if ($this->aUsers !== null) {
                if ($this->aUsers->isModified() || $this->aUsers->isNew()) {
                    $affectedRows += $this->aUsers->save($con);
                }
                $this->setUsers($this->aUsers);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->searchnotificationssScheduledForDeletion !== null) {
                if (!$this->searchnotificationssScheduledForDeletion->isEmpty()) {
                    \SearchnotificationsQuery::create()
                        ->filterByPrimaryKeys($this->searchnotificationssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->searchnotificationssScheduledForDeletion = null;
                }
            }

            if ($this->collSearchnotificationss !== null) {
                foreach ($this->collSearchnotificationss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[NotificationsTableMap::COL_NOTIFICATION] = true;
        if (null !== $this->notification) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . NotificationsTableMap::COL_NOTIFICATION . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(NotificationsTableMap::COL_NOTIFICATION)) {
            $modifiedColumns[':p' . $index++]  = 'notification';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_LATITUDE)) {
            $modifiedColumns[':p' . $index++]  = 'latitude';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_NOTIFICATIONTYPEID)) {
            $modifiedColumns[':p' . $index++]  = 'notificationTypeId';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_CREATIONDATE)) {
            $modifiedColumns[':p' . $index++]  = 'creationDate';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_ANIMALID)) {
            $modifiedColumns[':p' . $index++]  = 'animalId';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_LONGITUDE)) {
            $modifiedColumns[':p' . $index++]  = 'longitude';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_LOCATION)) {
            $modifiedColumns[':p' . $index++]  = 'location';
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_USER)) {
            $modifiedColumns[':p' . $index++]  = 'user';
        }

        $sql = sprintf(
            'INSERT INTO notifications (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'notification':
                        $stmt->bindValue($identifier, $this->notification, PDO::PARAM_INT);
                        break;
                    case 'latitude':
                        $stmt->bindValue($identifier, $this->latitude, PDO::PARAM_STR);
                        break;
                    case 'notificationTypeId':
                        $stmt->bindValue($identifier, $this->notificationtypeid, PDO::PARAM_INT);
                        break;
                    case 'creationDate':
                        $stmt->bindValue($identifier, $this->creationdate ? $this->creationdate->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'animalId':
                        $stmt->bindValue($identifier, $this->animalid, PDO::PARAM_INT);
                        break;
                    case 'longitude':
                        $stmt->bindValue($identifier, $this->longitude, PDO::PARAM_STR);
                        break;
                    case 'location':
                        $stmt->bindValue($identifier, $this->location, PDO::PARAM_STR);
                        break;
                    case 'user':
                        $stmt->bindValue($identifier, $this->user, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setNotification($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = NotificationsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getNotification();
                break;
            case 1:
                return $this->getLatitude();
                break;
            case 2:
                return $this->getNotificationtypeid();
                break;
            case 3:
                return $this->getCreationdate();
                break;
            case 4:
                return $this->getDescription();
                break;
            case 5:
                return $this->getAnimalid();
                break;
            case 6:
                return $this->getLongitude();
                break;
            case 7:
                return $this->getLocation();
                break;
            case 8:
                return $this->getUser();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Notifications'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Notifications'][$this->hashCode()] = true;
        $keys = NotificationsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getNotification(),
            $keys[1] => $this->getLatitude(),
            $keys[2] => $this->getNotificationtypeid(),
            $keys[3] => $this->getCreationdate(),
            $keys[4] => $this->getDescription(),
            $keys[5] => $this->getAnimalid(),
            $keys[6] => $this->getLongitude(),
            $keys[7] => $this->getLocation(),
            $keys[8] => $this->getUser(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aNotificationtype) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'notificationtype';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'notificationType';
                        break;
                    default:
                        $key = 'Notificationtype';
                }

                $result[$key] = $this->aNotificationtype->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAnimals) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'animals';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'animals';
                        break;
                    default:
                        $key = 'Animals';
                }

                $result[$key] = $this->aAnimals->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUsers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'Users';
                }

                $result[$key] = $this->aUsers->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSearchnotificationss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'searchnotificationss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'searchNotificationss';
                        break;
                    default:
                        $key = 'Searchnotificationss';
                }

                $result[$key] = $this->collSearchnotificationss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Notifications
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = NotificationsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Notifications
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setNotification($value);
                break;
            case 1:
                $this->setLatitude($value);
                break;
            case 2:
                $this->setNotificationtypeid($value);
                break;
            case 3:
                $this->setCreationdate($value);
                break;
            case 4:
                $this->setDescription($value);
                break;
            case 5:
                $this->setAnimalid($value);
                break;
            case 6:
                $this->setLongitude($value);
                break;
            case 7:
                $this->setLocation($value);
                break;
            case 8:
                $this->setUser($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = NotificationsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setNotification($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLatitude($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNotificationtypeid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreationdate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDescription($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAnimalid($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLongitude($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLocation($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUser($arr[$keys[8]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Notifications The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(NotificationsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(NotificationsTableMap::COL_NOTIFICATION)) {
            $criteria->add(NotificationsTableMap::COL_NOTIFICATION, $this->notification);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_LATITUDE)) {
            $criteria->add(NotificationsTableMap::COL_LATITUDE, $this->latitude);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_NOTIFICATIONTYPEID)) {
            $criteria->add(NotificationsTableMap::COL_NOTIFICATIONTYPEID, $this->notificationtypeid);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_CREATIONDATE)) {
            $criteria->add(NotificationsTableMap::COL_CREATIONDATE, $this->creationdate);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_DESCRIPTION)) {
            $criteria->add(NotificationsTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_ANIMALID)) {
            $criteria->add(NotificationsTableMap::COL_ANIMALID, $this->animalid);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_LONGITUDE)) {
            $criteria->add(NotificationsTableMap::COL_LONGITUDE, $this->longitude);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_LOCATION)) {
            $criteria->add(NotificationsTableMap::COL_LOCATION, $this->location);
        }
        if ($this->isColumnModified(NotificationsTableMap::COL_USER)) {
            $criteria->add(NotificationsTableMap::COL_USER, $this->user);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildNotificationsQuery::create();
        $criteria->add(NotificationsTableMap::COL_NOTIFICATION, $this->notification);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getNotification();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getNotification();
    }

    /**
     * Generic method to set the primary key (notification column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setNotification($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getNotification();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Notifications (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLatitude($this->getLatitude());
        $copyObj->setNotificationtypeid($this->getNotificationtypeid());
        $copyObj->setCreationdate($this->getCreationdate());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setAnimalid($this->getAnimalid());
        $copyObj->setLongitude($this->getLongitude());
        $copyObj->setLocation($this->getLocation());
        $copyObj->setUser($this->getUser());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSearchnotificationss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSearchnotifications($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setNotification(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Notifications Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildNotificationtype object.
     *
     * @param  ChildNotificationtype $v
     * @return $this|\Notifications The current object (for fluent API support)
     * @throws PropelException
     */
    public function setNotificationtype(ChildNotificationtype $v = null)
    {
        if ($v === null) {
            $this->setNotificationtypeid(NULL);
        } else {
            $this->setNotificationtypeid($v->getNotificationtype());
        }

        $this->aNotificationtype = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildNotificationtype object, it will not be re-added.
        if ($v !== null) {
            $v->addNotifications($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildNotificationtype object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildNotificationtype The associated ChildNotificationtype object.
     * @throws PropelException
     */
    public function getNotificationtype(ConnectionInterface $con = null)
    {
        if ($this->aNotificationtype === null && ($this->notificationtypeid !== null)) {
            $this->aNotificationtype = ChildNotificationtypeQuery::create()->findPk($this->notificationtypeid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aNotificationtype->addNotificationss($this);
             */
        }

        return $this->aNotificationtype;
    }

    /**
     * Declares an association between this object and a ChildAnimals object.
     *
     * @param  ChildAnimals $v
     * @return $this|\Notifications The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAnimals(ChildAnimals $v = null)
    {
        if ($v === null) {
            $this->setAnimalid(NULL);
        } else {
            $this->setAnimalid($v->getAnimal());
        }

        $this->aAnimals = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAnimals object, it will not be re-added.
        if ($v !== null) {
            $v->addNotifications($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAnimals object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAnimals The associated ChildAnimals object.
     * @throws PropelException
     */
    public function getAnimals(ConnectionInterface $con = null)
    {
        if ($this->aAnimals === null && ($this->animalid !== null)) {
            $this->aAnimals = ChildAnimalsQuery::create()->findPk($this->animalid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAnimals->addNotificationss($this);
             */
        }

        return $this->aAnimals;
    }

    /**
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\Notifications The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUsers(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setUser(NULL);
        } else {
            $this->setUser($v->getUser());
        }

        $this->aUsers = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addNotifications($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getUsers(ConnectionInterface $con = null)
    {
        if ($this->aUsers === null && ($this->user !== null)) {
            $this->aUsers = ChildUsersQuery::create()->findPk($this->user, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUsers->addNotificationss($this);
             */
        }

        return $this->aUsers;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Searchnotifications' == $relationName) {
            return $this->initSearchnotificationss();
        }
    }

    /**
     * Clears out the collSearchnotificationss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSearchnotificationss()
     */
    public function clearSearchnotificationss()
    {
        $this->collSearchnotificationss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSearchnotificationss collection loaded partially.
     */
    public function resetPartialSearchnotificationss($v = true)
    {
        $this->collSearchnotificationssPartial = $v;
    }

    /**
     * Initializes the collSearchnotificationss collection.
     *
     * By default this just sets the collSearchnotificationss collection to an empty array (like clearcollSearchnotificationss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSearchnotificationss($overrideExisting = true)
    {
        if (null !== $this->collSearchnotificationss && !$overrideExisting) {
            return;
        }

        $collectionClassName = SearchnotificationsTableMap::getTableMap()->getCollectionClassName();

        $this->collSearchnotificationss = new $collectionClassName;
        $this->collSearchnotificationss->setModel('\Searchnotifications');
    }

    /**
     * Gets an array of ChildSearchnotifications objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildNotifications is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSearchnotifications[] List of ChildSearchnotifications objects
     * @throws PropelException
     */
    public function getSearchnotificationss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSearchnotificationssPartial && !$this->isNew();
        if (null === $this->collSearchnotificationss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSearchnotificationss) {
                // return empty collection
                $this->initSearchnotificationss();
            } else {
                $collSearchnotificationss = ChildSearchnotificationsQuery::create(null, $criteria)
                    ->filterByNotifications($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSearchnotificationssPartial && count($collSearchnotificationss)) {
                        $this->initSearchnotificationss(false);

                        foreach ($collSearchnotificationss as $obj) {
                            if (false == $this->collSearchnotificationss->contains($obj)) {
                                $this->collSearchnotificationss->append($obj);
                            }
                        }

                        $this->collSearchnotificationssPartial = true;
                    }

                    return $collSearchnotificationss;
                }

                if ($partial && $this->collSearchnotificationss) {
                    foreach ($this->collSearchnotificationss as $obj) {
                        if ($obj->isNew()) {
                            $collSearchnotificationss[] = $obj;
                        }
                    }
                }

                $this->collSearchnotificationss = $collSearchnotificationss;
                $this->collSearchnotificationssPartial = false;
            }
        }

        return $this->collSearchnotificationss;
    }

    /**
     * Sets a collection of ChildSearchnotifications objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $searchnotificationss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildNotifications The current object (for fluent API support)
     */
    public function setSearchnotificationss(Collection $searchnotificationss, ConnectionInterface $con = null)
    {
        /** @var ChildSearchnotifications[] $searchnotificationssToDelete */
        $searchnotificationssToDelete = $this->getSearchnotificationss(new Criteria(), $con)->diff($searchnotificationss);


        $this->searchnotificationssScheduledForDeletion = $searchnotificationssToDelete;

        foreach ($searchnotificationssToDelete as $searchnotificationsRemoved) {
            $searchnotificationsRemoved->setNotifications(null);
        }

        $this->collSearchnotificationss = null;
        foreach ($searchnotificationss as $searchnotifications) {
            $this->addSearchnotifications($searchnotifications);
        }

        $this->collSearchnotificationss = $searchnotificationss;
        $this->collSearchnotificationssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Searchnotifications objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Searchnotifications objects.
     * @throws PropelException
     */
    public function countSearchnotificationss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSearchnotificationssPartial && !$this->isNew();
        if (null === $this->collSearchnotificationss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSearchnotificationss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSearchnotificationss());
            }

            $query = ChildSearchnotificationsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByNotifications($this)
                ->count($con);
        }

        return count($this->collSearchnotificationss);
    }

    /**
     * Method called to associate a ChildSearchnotifications object to this object
     * through the ChildSearchnotifications foreign key attribute.
     *
     * @param  ChildSearchnotifications $l ChildSearchnotifications
     * @return $this|\Notifications The current object (for fluent API support)
     */
    public function addSearchnotifications(ChildSearchnotifications $l)
    {
        if ($this->collSearchnotificationss === null) {
            $this->initSearchnotificationss();
            $this->collSearchnotificationssPartial = true;
        }

        if (!$this->collSearchnotificationss->contains($l)) {
            $this->doAddSearchnotifications($l);

            if ($this->searchnotificationssScheduledForDeletion and $this->searchnotificationssScheduledForDeletion->contains($l)) {
                $this->searchnotificationssScheduledForDeletion->remove($this->searchnotificationssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSearchnotifications $searchnotifications The ChildSearchnotifications object to add.
     */
    protected function doAddSearchnotifications(ChildSearchnotifications $searchnotifications)
    {
        $this->collSearchnotificationss[]= $searchnotifications;
        $searchnotifications->setNotifications($this);
    }

    /**
     * @param  ChildSearchnotifications $searchnotifications The ChildSearchnotifications object to remove.
     * @return $this|ChildNotifications The current object (for fluent API support)
     */
    public function removeSearchnotifications(ChildSearchnotifications $searchnotifications)
    {
        if ($this->getSearchnotificationss()->contains($searchnotifications)) {
            $pos = $this->collSearchnotificationss->search($searchnotifications);
            $this->collSearchnotificationss->remove($pos);
            if (null === $this->searchnotificationssScheduledForDeletion) {
                $this->searchnotificationssScheduledForDeletion = clone $this->collSearchnotificationss;
                $this->searchnotificationssScheduledForDeletion->clear();
            }
            $this->searchnotificationssScheduledForDeletion[]= clone $searchnotifications;
            $searchnotifications->setNotifications(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aNotificationtype) {
            $this->aNotificationtype->removeNotifications($this);
        }
        if (null !== $this->aAnimals) {
            $this->aAnimals->removeNotifications($this);
        }
        if (null !== $this->aUsers) {
            $this->aUsers->removeNotifications($this);
        }
        $this->notification = null;
        $this->latitude = null;
        $this->notificationtypeid = null;
        $this->creationdate = null;
        $this->description = null;
        $this->animalid = null;
        $this->longitude = null;
        $this->location = null;
        $this->user = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collSearchnotificationss) {
                foreach ($this->collSearchnotificationss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSearchnotificationss = null;
        $this->aNotificationtype = null;
        $this->aAnimals = null;
        $this->aUsers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(NotificationsTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

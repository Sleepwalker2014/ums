<?php

namespace Base;

use \Animals as ChildAnimals;
use \AnimalsQuery as ChildAnimalsQuery;
use \Colours as ChildColours;
use \ColoursQuery as ChildColoursQuery;
use \Notifications as ChildNotifications;
use \NotificationsQuery as ChildNotificationsQuery;
use \Races as ChildRaces;
use \RacesQuery as ChildRacesQuery;
use \Sexes as ChildSexes;
use \SexesQuery as ChildSexesQuery;
use \Species as ChildSpecies;
use \SpeciesQuery as ChildSpeciesQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\AnimalsTableMap;
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
 * Base class that represents a row from the 'animals' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Animals implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\AnimalsTableMap';


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
     * The value for the animal field.
     * @var        int
     */
    protected $animal;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the birthday field.
     * @var        \DateTime
     */
    protected $birthday;

    /**
     * The value for the sexid field.
     * @var        int
     */
    protected $sexid;

    /**
     * The value for the furcolourid field.
     * @var        int
     */
    protected $furcolourid;

    /**
     * The value for the eyecolourid field.
     * @var        int
     */
    protected $eyecolourid;

    /**
     * The value for the speciesid field.
     * @var        int
     */
    protected $speciesid;

    /**
     * The value for the size field.
     * @var        int
     */
    protected $size;

    /**
     * The value for the specification field.
     * @var        string
     */
    protected $specification;

    /**
     * The value for the raceid field.
     * @var        int
     */
    protected $raceid;

    /**
     * @var        ChildRaces
     */
    protected $aRaces;

    /**
     * @var        ChildSpecies
     */
    protected $aSpecies;

    /**
     * @var        ChildSexes
     */
    protected $aSexes;

    /**
     * @var        ChildColours
     */
    protected $aColoursRelatedByFurcolourid;

    /**
     * @var        ChildColours
     */
    protected $aColoursRelatedByEyecolourid;

    /**
     * @var        ObjectCollection|ChildNotifications[] Collection to store aggregation of ChildNotifications objects.
     */
    protected $collNotificationss;
    protected $collNotificationssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildNotifications[]
     */
    protected $notificationssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Animals object.
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
     * Compares this with another <code>Animals</code> instance.  If
     * <code>obj</code> is an instance of <code>Animals</code>, delegates to
     * <code>equals(Animals)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Animals The current object, for fluid interface
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

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [animal] column value.
     *
     * @return int
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [optionally formatted] temporal [birthday] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBirthday($format = NULL)
    {
        if ($format === null) {
            return $this->birthday;
        } else {
            return $this->birthday instanceof \DateTime ? $this->birthday->format($format) : null;
        }
    }

    /**
     * Get the [sexid] column value.
     *
     * @return int
     */
    public function getSexid()
    {
        return $this->sexid;
    }

    /**
     * Get the [furcolourid] column value.
     *
     * @return int
     */
    public function getFurcolourid()
    {
        return $this->furcolourid;
    }

    /**
     * Get the [eyecolourid] column value.
     *
     * @return int
     */
    public function getEyecolourid()
    {
        return $this->eyecolourid;
    }

    /**
     * Get the [speciesid] column value.
     *
     * @return int
     */
    public function getSpeciesid()
    {
        return $this->speciesid;
    }

    /**
     * Get the [size] column value.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get the [specification] column value.
     *
     * @return string
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * Get the [raceid] column value.
     *
     * @return int
     */
    public function getRaceid()
    {
        return $this->raceid;
    }

    /**
     * Set the value of [animal] column.
     *
     * @param int $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setAnimal($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->animal !== $v) {
            $this->animal = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_ANIMAL] = true;
        }

        return $this;
    } // setAnimal()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Sets the value of [birthday] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setBirthday($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->birthday !== null || $dt !== null) {
            if ($this->birthday === null || $dt === null || $dt->format("Y-m-d") !== $this->birthday->format("Y-m-d")) {
                $this->birthday = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AnimalsTableMap::COL_BIRTHDAY] = true;
            }
        } // if either are not null

        return $this;
    } // setBirthday()

    /**
     * Set the value of [sexid] column.
     *
     * @param int $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setSexid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sexid !== $v) {
            $this->sexid = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_SEXID] = true;
        }

        if ($this->aSexes !== null && $this->aSexes->getSex() !== $v) {
            $this->aSexes = null;
        }

        return $this;
    } // setSexid()

    /**
     * Set the value of [furcolourid] column.
     *
     * @param int $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setFurcolourid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->furcolourid !== $v) {
            $this->furcolourid = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_FURCOLOURID] = true;
        }

        if ($this->aColoursRelatedByFurcolourid !== null && $this->aColoursRelatedByFurcolourid->getColour() !== $v) {
            $this->aColoursRelatedByFurcolourid = null;
        }

        return $this;
    } // setFurcolourid()

    /**
     * Set the value of [eyecolourid] column.
     *
     * @param int $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setEyecolourid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->eyecolourid !== $v) {
            $this->eyecolourid = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_EYECOLOURID] = true;
        }

        if ($this->aColoursRelatedByEyecolourid !== null && $this->aColoursRelatedByEyecolourid->getColour() !== $v) {
            $this->aColoursRelatedByEyecolourid = null;
        }

        return $this;
    } // setEyecolourid()

    /**
     * Set the value of [speciesid] column.
     *
     * @param int $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setSpeciesid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->speciesid !== $v) {
            $this->speciesid = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_SPECIESID] = true;
        }

        if ($this->aSpecies !== null && $this->aSpecies->getSpecies() !== $v) {
            $this->aSpecies = null;
        }

        return $this;
    } // setSpeciesid()

    /**
     * Set the value of [size] column.
     *
     * @param int $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setSize($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->size !== $v) {
            $this->size = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_SIZE] = true;
        }

        return $this;
    } // setSize()

    /**
     * Set the value of [specification] column.
     *
     * @param string $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setSpecification($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->specification !== $v) {
            $this->specification = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_SPECIFICATION] = true;
        }

        return $this;
    } // setSpecification()

    /**
     * Set the value of [raceid] column.
     *
     * @param int $v new value
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function setRaceid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->raceid !== $v) {
            $this->raceid = $v;
            $this->modifiedColumns[AnimalsTableMap::COL_RACEID] = true;
        }

        if ($this->aRaces !== null && $this->aRaces->getRace() !== $v) {
            $this->aRaces = null;
        }

        return $this;
    } // setRaceid()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AnimalsTableMap::translateFieldName('Animal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->animal = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AnimalsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AnimalsTableMap::translateFieldName('Birthday', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->birthday = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AnimalsTableMap::translateFieldName('Sexid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sexid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AnimalsTableMap::translateFieldName('Furcolourid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->furcolourid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AnimalsTableMap::translateFieldName('Eyecolourid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->eyecolourid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AnimalsTableMap::translateFieldName('Speciesid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->speciesid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AnimalsTableMap::translateFieldName('Size', TableMap::TYPE_PHPNAME, $indexType)];
            $this->size = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AnimalsTableMap::translateFieldName('Specification', TableMap::TYPE_PHPNAME, $indexType)];
            $this->specification = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AnimalsTableMap::translateFieldName('Raceid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->raceid = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = AnimalsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Animals'), 0, $e);
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
        if ($this->aSexes !== null && $this->sexid !== $this->aSexes->getSex()) {
            $this->aSexes = null;
        }
        if ($this->aColoursRelatedByFurcolourid !== null && $this->furcolourid !== $this->aColoursRelatedByFurcolourid->getColour()) {
            $this->aColoursRelatedByFurcolourid = null;
        }
        if ($this->aColoursRelatedByEyecolourid !== null && $this->eyecolourid !== $this->aColoursRelatedByEyecolourid->getColour()) {
            $this->aColoursRelatedByEyecolourid = null;
        }
        if ($this->aSpecies !== null && $this->speciesid !== $this->aSpecies->getSpecies()) {
            $this->aSpecies = null;
        }
        if ($this->aRaces !== null && $this->raceid !== $this->aRaces->getRace()) {
            $this->aRaces = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AnimalsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAnimalsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRaces = null;
            $this->aSpecies = null;
            $this->aSexes = null;
            $this->aColoursRelatedByFurcolourid = null;
            $this->aColoursRelatedByEyecolourid = null;
            $this->collNotificationss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Animals::setDeleted()
     * @see Animals::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AnimalsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAnimalsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AnimalsTableMap::DATABASE_NAME);
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
                AnimalsTableMap::addInstanceToPool($this);
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

            if ($this->aRaces !== null) {
                if ($this->aRaces->isModified() || $this->aRaces->isNew()) {
                    $affectedRows += $this->aRaces->save($con);
                }
                $this->setRaces($this->aRaces);
            }

            if ($this->aSpecies !== null) {
                if ($this->aSpecies->isModified() || $this->aSpecies->isNew()) {
                    $affectedRows += $this->aSpecies->save($con);
                }
                $this->setSpecies($this->aSpecies);
            }

            if ($this->aSexes !== null) {
                if ($this->aSexes->isModified() || $this->aSexes->isNew()) {
                    $affectedRows += $this->aSexes->save($con);
                }
                $this->setSexes($this->aSexes);
            }

            if ($this->aColoursRelatedByFurcolourid !== null) {
                if ($this->aColoursRelatedByFurcolourid->isModified() || $this->aColoursRelatedByFurcolourid->isNew()) {
                    $affectedRows += $this->aColoursRelatedByFurcolourid->save($con);
                }
                $this->setColoursRelatedByFurcolourid($this->aColoursRelatedByFurcolourid);
            }

            if ($this->aColoursRelatedByEyecolourid !== null) {
                if ($this->aColoursRelatedByEyecolourid->isModified() || $this->aColoursRelatedByEyecolourid->isNew()) {
                    $affectedRows += $this->aColoursRelatedByEyecolourid->save($con);
                }
                $this->setColoursRelatedByEyecolourid($this->aColoursRelatedByEyecolourid);
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

            if ($this->notificationssScheduledForDeletion !== null) {
                if (!$this->notificationssScheduledForDeletion->isEmpty()) {
                    \NotificationsQuery::create()
                        ->filterByPrimaryKeys($this->notificationssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->notificationssScheduledForDeletion = null;
                }
            }

            if ($this->collNotificationss !== null) {
                foreach ($this->collNotificationss as $referrerFK) {
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

        $this->modifiedColumns[AnimalsTableMap::COL_ANIMAL] = true;
        if (null !== $this->animal) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AnimalsTableMap::COL_ANIMAL . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AnimalsTableMap::COL_ANIMAL)) {
            $modifiedColumns[':p' . $index++]  = 'animal';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_BIRTHDAY)) {
            $modifiedColumns[':p' . $index++]  = 'birthDay';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SEXID)) {
            $modifiedColumns[':p' . $index++]  = 'sexId';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_FURCOLOURID)) {
            $modifiedColumns[':p' . $index++]  = 'furColourId';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_EYECOLOURID)) {
            $modifiedColumns[':p' . $index++]  = 'eyeColourId';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SPECIESID)) {
            $modifiedColumns[':p' . $index++]  = 'speciesId';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SIZE)) {
            $modifiedColumns[':p' . $index++]  = 'size';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SPECIFICATION)) {
            $modifiedColumns[':p' . $index++]  = 'specification';
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_RACEID)) {
            $modifiedColumns[':p' . $index++]  = 'raceId';
        }

        $sql = sprintf(
            'INSERT INTO animals (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'animal':
                        $stmt->bindValue($identifier, $this->animal, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'birthDay':
                        $stmt->bindValue($identifier, $this->birthday ? $this->birthday->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'sexId':
                        $stmt->bindValue($identifier, $this->sexid, PDO::PARAM_INT);
                        break;
                    case 'furColourId':
                        $stmt->bindValue($identifier, $this->furcolourid, PDO::PARAM_INT);
                        break;
                    case 'eyeColourId':
                        $stmt->bindValue($identifier, $this->eyecolourid, PDO::PARAM_INT);
                        break;
                    case 'speciesId':
                        $stmt->bindValue($identifier, $this->speciesid, PDO::PARAM_INT);
                        break;
                    case 'size':
                        $stmt->bindValue($identifier, $this->size, PDO::PARAM_INT);
                        break;
                    case 'specification':
                        $stmt->bindValue($identifier, $this->specification, PDO::PARAM_STR);
                        break;
                    case 'raceId':
                        $stmt->bindValue($identifier, $this->raceid, PDO::PARAM_INT);
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
        $this->setAnimal($pk);

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
        $pos = AnimalsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAnimal();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getBirthday();
                break;
            case 3:
                return $this->getSexid();
                break;
            case 4:
                return $this->getFurcolourid();
                break;
            case 5:
                return $this->getEyecolourid();
                break;
            case 6:
                return $this->getSpeciesid();
                break;
            case 7:
                return $this->getSize();
                break;
            case 8:
                return $this->getSpecification();
                break;
            case 9:
                return $this->getRaceid();
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

        if (isset($alreadyDumpedObjects['Animals'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Animals'][$this->hashCode()] = true;
        $keys = AnimalsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAnimal(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getBirthday(),
            $keys[3] => $this->getSexid(),
            $keys[4] => $this->getFurcolourid(),
            $keys[5] => $this->getEyecolourid(),
            $keys[6] => $this->getSpeciesid(),
            $keys[7] => $this->getSize(),
            $keys[8] => $this->getSpecification(),
            $keys[9] => $this->getRaceid(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[2]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[2]];
            $result[$keys[2]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aRaces) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'races';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'races';
                        break;
                    default:
                        $key = 'Races';
                }

                $result[$key] = $this->aRaces->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSpecies) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'species';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'species';
                        break;
                    default:
                        $key = 'Species';
                }

                $result[$key] = $this->aSpecies->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSexes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sexes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sexes';
                        break;
                    default:
                        $key = 'Sexes';
                }

                $result[$key] = $this->aSexes->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aColoursRelatedByFurcolourid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'colours';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'colours';
                        break;
                    default:
                        $key = 'Colours';
                }

                $result[$key] = $this->aColoursRelatedByFurcolourid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aColoursRelatedByEyecolourid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'colours';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'colours';
                        break;
                    default:
                        $key = 'Colours';
                }

                $result[$key] = $this->aColoursRelatedByEyecolourid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collNotificationss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'notificationss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'notificationss';
                        break;
                    default:
                        $key = 'Notificationss';
                }

                $result[$key] = $this->collNotificationss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Animals
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AnimalsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Animals
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setAnimal($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setBirthday($value);
                break;
            case 3:
                $this->setSexid($value);
                break;
            case 4:
                $this->setFurcolourid($value);
                break;
            case 5:
                $this->setEyecolourid($value);
                break;
            case 6:
                $this->setSpeciesid($value);
                break;
            case 7:
                $this->setSize($value);
                break;
            case 8:
                $this->setSpecification($value);
                break;
            case 9:
                $this->setRaceid($value);
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
        $keys = AnimalsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setAnimal($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setBirthday($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSexid($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFurcolourid($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEyecolourid($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSpeciesid($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSize($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSpecification($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setRaceid($arr[$keys[9]]);
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
     * @return $this|\Animals The current object, for fluid interface
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
        $criteria = new Criteria(AnimalsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AnimalsTableMap::COL_ANIMAL)) {
            $criteria->add(AnimalsTableMap::COL_ANIMAL, $this->animal);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_NAME)) {
            $criteria->add(AnimalsTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_BIRTHDAY)) {
            $criteria->add(AnimalsTableMap::COL_BIRTHDAY, $this->birthday);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SEXID)) {
            $criteria->add(AnimalsTableMap::COL_SEXID, $this->sexid);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_FURCOLOURID)) {
            $criteria->add(AnimalsTableMap::COL_FURCOLOURID, $this->furcolourid);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_EYECOLOURID)) {
            $criteria->add(AnimalsTableMap::COL_EYECOLOURID, $this->eyecolourid);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SPECIESID)) {
            $criteria->add(AnimalsTableMap::COL_SPECIESID, $this->speciesid);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SIZE)) {
            $criteria->add(AnimalsTableMap::COL_SIZE, $this->size);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_SPECIFICATION)) {
            $criteria->add(AnimalsTableMap::COL_SPECIFICATION, $this->specification);
        }
        if ($this->isColumnModified(AnimalsTableMap::COL_RACEID)) {
            $criteria->add(AnimalsTableMap::COL_RACEID, $this->raceid);
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
        $criteria = ChildAnimalsQuery::create();
        $criteria->add(AnimalsTableMap::COL_ANIMAL, $this->animal);

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
        $validPk = null !== $this->getAnimal();

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
        return $this->getAnimal();
    }

    /**
     * Generic method to set the primary key (animal column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAnimal($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getAnimal();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Animals (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setBirthday($this->getBirthday());
        $copyObj->setSexid($this->getSexid());
        $copyObj->setFurcolourid($this->getFurcolourid());
        $copyObj->setEyecolourid($this->getEyecolourid());
        $copyObj->setSpeciesid($this->getSpeciesid());
        $copyObj->setSize($this->getSize());
        $copyObj->setSpecification($this->getSpecification());
        $copyObj->setRaceid($this->getRaceid());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getNotificationss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNotifications($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setAnimal(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Animals Clone of current object.
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
     * Declares an association between this object and a ChildRaces object.
     *
     * @param  ChildRaces $v
     * @return $this|\Animals The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRaces(ChildRaces $v = null)
    {
        if ($v === null) {
            $this->setRaceid(NULL);
        } else {
            $this->setRaceid($v->getRace());
        }

        $this->aRaces = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildRaces object, it will not be re-added.
        if ($v !== null) {
            $v->addAnimals($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildRaces object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildRaces The associated ChildRaces object.
     * @throws PropelException
     */
    public function getRaces(ConnectionInterface $con = null)
    {
        if ($this->aRaces === null && ($this->raceid !== null)) {
            $this->aRaces = ChildRacesQuery::create()->findPk($this->raceid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRaces->addAnimalss($this);
             */
        }

        return $this->aRaces;
    }

    /**
     * Declares an association between this object and a ChildSpecies object.
     *
     * @param  ChildSpecies $v
     * @return $this|\Animals The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSpecies(ChildSpecies $v = null)
    {
        if ($v === null) {
            $this->setSpeciesid(NULL);
        } else {
            $this->setSpeciesid($v->getSpecies());
        }

        $this->aSpecies = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSpecies object, it will not be re-added.
        if ($v !== null) {
            $v->addAnimals($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSpecies object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSpecies The associated ChildSpecies object.
     * @throws PropelException
     */
    public function getSpecies(ConnectionInterface $con = null)
    {
        if ($this->aSpecies === null && ($this->speciesid !== null)) {
            $this->aSpecies = ChildSpeciesQuery::create()->findPk($this->speciesid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSpecies->addAnimalss($this);
             */
        }

        return $this->aSpecies;
    }

    /**
     * Declares an association between this object and a ChildSexes object.
     *
     * @param  ChildSexes $v
     * @return $this|\Animals The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSexes(ChildSexes $v = null)
    {
        if ($v === null) {
            $this->setSexid(NULL);
        } else {
            $this->setSexid($v->getSex());
        }

        $this->aSexes = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSexes object, it will not be re-added.
        if ($v !== null) {
            $v->addAnimals($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSexes object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSexes The associated ChildSexes object.
     * @throws PropelException
     */
    public function getSexes(ConnectionInterface $con = null)
    {
        if ($this->aSexes === null && ($this->sexid !== null)) {
            $this->aSexes = ChildSexesQuery::create()->findPk($this->sexid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSexes->addAnimalss($this);
             */
        }

        return $this->aSexes;
    }

    /**
     * Declares an association between this object and a ChildColours object.
     *
     * @param  ChildColours $v
     * @return $this|\Animals The current object (for fluent API support)
     * @throws PropelException
     */
    public function setColoursRelatedByFurcolourid(ChildColours $v = null)
    {
        if ($v === null) {
            $this->setFurcolourid(NULL);
        } else {
            $this->setFurcolourid($v->getColour());
        }

        $this->aColoursRelatedByFurcolourid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildColours object, it will not be re-added.
        if ($v !== null) {
            $v->addAnimalsRelatedByFurcolourid($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildColours object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildColours The associated ChildColours object.
     * @throws PropelException
     */
    public function getColoursRelatedByFurcolourid(ConnectionInterface $con = null)
    {
        if ($this->aColoursRelatedByFurcolourid === null && ($this->furcolourid !== null)) {
            $this->aColoursRelatedByFurcolourid = ChildColoursQuery::create()->findPk($this->furcolourid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aColoursRelatedByFurcolourid->addAnimalssRelatedByFurcolourid($this);
             */
        }

        return $this->aColoursRelatedByFurcolourid;
    }

    /**
     * Declares an association between this object and a ChildColours object.
     *
     * @param  ChildColours $v
     * @return $this|\Animals The current object (for fluent API support)
     * @throws PropelException
     */
    public function setColoursRelatedByEyecolourid(ChildColours $v = null)
    {
        if ($v === null) {
            $this->setEyecolourid(NULL);
        } else {
            $this->setEyecolourid($v->getColour());
        }

        $this->aColoursRelatedByEyecolourid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildColours object, it will not be re-added.
        if ($v !== null) {
            $v->addAnimalsRelatedByEyecolourid($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildColours object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildColours The associated ChildColours object.
     * @throws PropelException
     */
    public function getColoursRelatedByEyecolourid(ConnectionInterface $con = null)
    {
        if ($this->aColoursRelatedByEyecolourid === null && ($this->eyecolourid !== null)) {
            $this->aColoursRelatedByEyecolourid = ChildColoursQuery::create()->findPk($this->eyecolourid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aColoursRelatedByEyecolourid->addAnimalssRelatedByEyecolourid($this);
             */
        }

        return $this->aColoursRelatedByEyecolourid;
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
        if ('Notifications' == $relationName) {
            return $this->initNotificationss();
        }
    }

    /**
     * Clears out the collNotificationss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addNotificationss()
     */
    public function clearNotificationss()
    {
        $this->collNotificationss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collNotificationss collection loaded partially.
     */
    public function resetPartialNotificationss($v = true)
    {
        $this->collNotificationssPartial = $v;
    }

    /**
     * Initializes the collNotificationss collection.
     *
     * By default this just sets the collNotificationss collection to an empty array (like clearcollNotificationss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNotificationss($overrideExisting = true)
    {
        if (null !== $this->collNotificationss && !$overrideExisting) {
            return;
        }
        $this->collNotificationss = new ObjectCollection();
        $this->collNotificationss->setModel('\Notifications');
    }

    /**
     * Gets an array of ChildNotifications objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAnimals is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildNotifications[] List of ChildNotifications objects
     * @throws PropelException
     */
    public function getNotificationss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collNotificationssPartial && !$this->isNew();
        if (null === $this->collNotificationss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collNotificationss) {
                // return empty collection
                $this->initNotificationss();
            } else {
                $collNotificationss = ChildNotificationsQuery::create(null, $criteria)
                    ->filterByAnimals($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collNotificationssPartial && count($collNotificationss)) {
                        $this->initNotificationss(false);

                        foreach ($collNotificationss as $obj) {
                            if (false == $this->collNotificationss->contains($obj)) {
                                $this->collNotificationss->append($obj);
                            }
                        }

                        $this->collNotificationssPartial = true;
                    }

                    return $collNotificationss;
                }

                if ($partial && $this->collNotificationss) {
                    foreach ($this->collNotificationss as $obj) {
                        if ($obj->isNew()) {
                            $collNotificationss[] = $obj;
                        }
                    }
                }

                $this->collNotificationss = $collNotificationss;
                $this->collNotificationssPartial = false;
            }
        }

        return $this->collNotificationss;
    }

    /**
     * Sets a collection of ChildNotifications objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $notificationss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAnimals The current object (for fluent API support)
     */
    public function setNotificationss(Collection $notificationss, ConnectionInterface $con = null)
    {
        /** @var ChildNotifications[] $notificationssToDelete */
        $notificationssToDelete = $this->getNotificationss(new Criteria(), $con)->diff($notificationss);


        $this->notificationssScheduledForDeletion = $notificationssToDelete;

        foreach ($notificationssToDelete as $notificationsRemoved) {
            $notificationsRemoved->setAnimals(null);
        }

        $this->collNotificationss = null;
        foreach ($notificationss as $notifications) {
            $this->addNotifications($notifications);
        }

        $this->collNotificationss = $notificationss;
        $this->collNotificationssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Notifications objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Notifications objects.
     * @throws PropelException
     */
    public function countNotificationss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collNotificationssPartial && !$this->isNew();
        if (null === $this->collNotificationss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collNotificationss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getNotificationss());
            }

            $query = ChildNotificationsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAnimals($this)
                ->count($con);
        }

        return count($this->collNotificationss);
    }

    /**
     * Method called to associate a ChildNotifications object to this object
     * through the ChildNotifications foreign key attribute.
     *
     * @param  ChildNotifications $l ChildNotifications
     * @return $this|\Animals The current object (for fluent API support)
     */
    public function addNotifications(ChildNotifications $l)
    {
        if ($this->collNotificationss === null) {
            $this->initNotificationss();
            $this->collNotificationssPartial = true;
        }

        if (!$this->collNotificationss->contains($l)) {
            $this->doAddNotifications($l);
        }

        return $this;
    }

    /**
     * @param ChildNotifications $notifications The ChildNotifications object to add.
     */
    protected function doAddNotifications(ChildNotifications $notifications)
    {
        $this->collNotificationss[]= $notifications;
        $notifications->setAnimals($this);
    }

    /**
     * @param  ChildNotifications $notifications The ChildNotifications object to remove.
     * @return $this|ChildAnimals The current object (for fluent API support)
     */
    public function removeNotifications(ChildNotifications $notifications)
    {
        if ($this->getNotificationss()->contains($notifications)) {
            $pos = $this->collNotificationss->search($notifications);
            $this->collNotificationss->remove($pos);
            if (null === $this->notificationssScheduledForDeletion) {
                $this->notificationssScheduledForDeletion = clone $this->collNotificationss;
                $this->notificationssScheduledForDeletion->clear();
            }
            $this->notificationssScheduledForDeletion[]= clone $notifications;
            $notifications->setAnimals(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Animals is new, it will return
     * an empty collection; or if this Animals has previously
     * been saved, it will retrieve related Notificationss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Animals.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildNotifications[] List of ChildNotifications objects
     */
    public function getNotificationssJoinNotificationtype(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildNotificationsQuery::create(null, $criteria);
        $query->joinWith('Notificationtype', $joinBehavior);

        return $this->getNotificationss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aRaces) {
            $this->aRaces->removeAnimals($this);
        }
        if (null !== $this->aSpecies) {
            $this->aSpecies->removeAnimals($this);
        }
        if (null !== $this->aSexes) {
            $this->aSexes->removeAnimals($this);
        }
        if (null !== $this->aColoursRelatedByFurcolourid) {
            $this->aColoursRelatedByFurcolourid->removeAnimalsRelatedByFurcolourid($this);
        }
        if (null !== $this->aColoursRelatedByEyecolourid) {
            $this->aColoursRelatedByEyecolourid->removeAnimalsRelatedByEyecolourid($this);
        }
        $this->animal = null;
        $this->name = null;
        $this->birthday = null;
        $this->sexid = null;
        $this->furcolourid = null;
        $this->eyecolourid = null;
        $this->speciesid = null;
        $this->size = null;
        $this->specification = null;
        $this->raceid = null;
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
            if ($this->collNotificationss) {
                foreach ($this->collNotificationss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collNotificationss = null;
        $this->aRaces = null;
        $this->aSpecies = null;
        $this->aSexes = null;
        $this->aColoursRelatedByFurcolourid = null;
        $this->aColoursRelatedByEyecolourid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AnimalsTableMap::DEFAULT_STRING_FORMAT);
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

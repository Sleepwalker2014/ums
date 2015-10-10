<?php

namespace Base;

use \Animals as ChildAnimals;
use \AnimalsQuery as ChildAnimalsQuery;
use \Colours as ChildColours;
use \ColoursQuery as ChildColoursQuery;
use \Exception;
use \PDO;
use Map\ColoursTableMap;
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

/**
 * Base class that represents a row from the 'colours' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Colours implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ColoursTableMap';


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
     * The value for the colour field.
     * @var        int
     */
    protected $colour;

    /**
     * The value for the code field.
     * @var        string
     */
    protected $code;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * @var        ObjectCollection|ChildAnimals[] Collection to store aggregation of ChildAnimals objects.
     */
    protected $collAnimalssRelatedByFurcolourid;
    protected $collAnimalssRelatedByFurcolouridPartial;

    /**
     * @var        ObjectCollection|ChildAnimals[] Collection to store aggregation of ChildAnimals objects.
     */
    protected $collAnimalssRelatedByEyecolourid;
    protected $collAnimalssRelatedByEyecolouridPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAnimals[]
     */
    protected $animalssRelatedByFurcolouridScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAnimals[]
     */
    protected $animalssRelatedByEyecolouridScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Colours object.
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
     * Compares this with another <code>Colours</code> instance.  If
     * <code>obj</code> is an instance of <code>Colours</code>, delegates to
     * <code>equals(Colours)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Colours The current object, for fluid interface
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
     * Get the [colour] column value.
     *
     * @return int
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
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
     * Set the value of [colour] column.
     *
     * @param int $v new value
     * @return $this|\Colours The current object (for fluent API support)
     */
    public function setColour($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->colour !== $v) {
            $this->colour = $v;
            $this->modifiedColumns[ColoursTableMap::COL_COLOUR] = true;
        }

        return $this;
    } // setColour()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\Colours The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[ColoursTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Colours The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ColoursTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ColoursTableMap::translateFieldName('Colour', TableMap::TYPE_PHPNAME, $indexType)];
            $this->colour = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ColoursTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ColoursTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = ColoursTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Colours'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ColoursTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildColoursQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAnimalssRelatedByFurcolourid = null;

            $this->collAnimalssRelatedByEyecolourid = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Colours::setDeleted()
     * @see Colours::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ColoursTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildColoursQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ColoursTableMap::DATABASE_NAME);
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
                ColoursTableMap::addInstanceToPool($this);
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

            if ($this->animalssRelatedByFurcolouridScheduledForDeletion !== null) {
                if (!$this->animalssRelatedByFurcolouridScheduledForDeletion->isEmpty()) {
                    \AnimalsQuery::create()
                        ->filterByPrimaryKeys($this->animalssRelatedByFurcolouridScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->animalssRelatedByFurcolouridScheduledForDeletion = null;
                }
            }

            if ($this->collAnimalssRelatedByFurcolourid !== null) {
                foreach ($this->collAnimalssRelatedByFurcolourid as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->animalssRelatedByEyecolouridScheduledForDeletion !== null) {
                if (!$this->animalssRelatedByEyecolouridScheduledForDeletion->isEmpty()) {
                    \AnimalsQuery::create()
                        ->filterByPrimaryKeys($this->animalssRelatedByEyecolouridScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->animalssRelatedByEyecolouridScheduledForDeletion = null;
                }
            }

            if ($this->collAnimalssRelatedByEyecolourid !== null) {
                foreach ($this->collAnimalssRelatedByEyecolourid as $referrerFK) {
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

        $this->modifiedColumns[ColoursTableMap::COL_COLOUR] = true;
        if (null !== $this->colour) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ColoursTableMap::COL_COLOUR . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ColoursTableMap::COL_COLOUR)) {
            $modifiedColumns[':p' . $index++]  = 'colour';
        }
        if ($this->isColumnModified(ColoursTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(ColoursTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }

        $sql = sprintf(
            'INSERT INTO colours (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'colour':
                        $stmt->bindValue($identifier, $this->colour, PDO::PARAM_INT);
                        break;
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
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
        $this->setColour($pk);

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
        $pos = ColoursTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getColour();
                break;
            case 1:
                return $this->getCode();
                break;
            case 2:
                return $this->getName();
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

        if (isset($alreadyDumpedObjects['Colours'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Colours'][$this->hashCode()] = true;
        $keys = ColoursTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getColour(),
            $keys[1] => $this->getCode(),
            $keys[2] => $this->getName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAnimalssRelatedByFurcolourid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'animalss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'animalss';
                        break;
                    default:
                        $key = 'Animalss';
                }

                $result[$key] = $this->collAnimalssRelatedByFurcolourid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAnimalssRelatedByEyecolourid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'animalss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'animalss';
                        break;
                    default:
                        $key = 'Animalss';
                }

                $result[$key] = $this->collAnimalssRelatedByEyecolourid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Colours
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ColoursTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Colours
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setColour($value);
                break;
            case 1:
                $this->setCode($value);
                break;
            case 2:
                $this->setName($value);
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
        $keys = ColoursTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setColour($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCode($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
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
     * @return $this|\Colours The current object, for fluid interface
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
        $criteria = new Criteria(ColoursTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ColoursTableMap::COL_COLOUR)) {
            $criteria->add(ColoursTableMap::COL_COLOUR, $this->colour);
        }
        if ($this->isColumnModified(ColoursTableMap::COL_CODE)) {
            $criteria->add(ColoursTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(ColoursTableMap::COL_NAME)) {
            $criteria->add(ColoursTableMap::COL_NAME, $this->name);
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
        $criteria = ChildColoursQuery::create();
        $criteria->add(ColoursTableMap::COL_COLOUR, $this->colour);

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
        $validPk = null !== $this->getColour();

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
        return $this->getColour();
    }

    /**
     * Generic method to set the primary key (colour column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setColour($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getColour();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Colours (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCode($this->getCode());
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAnimalssRelatedByFurcolourid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAnimalsRelatedByFurcolourid($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAnimalssRelatedByEyecolourid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAnimalsRelatedByEyecolourid($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setColour(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Colours Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('AnimalsRelatedByFurcolourid' == $relationName) {
            return $this->initAnimalssRelatedByFurcolourid();
        }
        if ('AnimalsRelatedByEyecolourid' == $relationName) {
            return $this->initAnimalssRelatedByEyecolourid();
        }
    }

    /**
     * Clears out the collAnimalssRelatedByFurcolourid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAnimalssRelatedByFurcolourid()
     */
    public function clearAnimalssRelatedByFurcolourid()
    {
        $this->collAnimalssRelatedByFurcolourid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAnimalssRelatedByFurcolourid collection loaded partially.
     */
    public function resetPartialAnimalssRelatedByFurcolourid($v = true)
    {
        $this->collAnimalssRelatedByFurcolouridPartial = $v;
    }

    /**
     * Initializes the collAnimalssRelatedByFurcolourid collection.
     *
     * By default this just sets the collAnimalssRelatedByFurcolourid collection to an empty array (like clearcollAnimalssRelatedByFurcolourid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAnimalssRelatedByFurcolourid($overrideExisting = true)
    {
        if (null !== $this->collAnimalssRelatedByFurcolourid && !$overrideExisting) {
            return;
        }
        $this->collAnimalssRelatedByFurcolourid = new ObjectCollection();
        $this->collAnimalssRelatedByFurcolourid->setModel('\Animals');
    }

    /**
     * Gets an array of ChildAnimals objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildColours is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     * @throws PropelException
     */
    public function getAnimalssRelatedByFurcolourid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAnimalssRelatedByFurcolouridPartial && !$this->isNew();
        if (null === $this->collAnimalssRelatedByFurcolourid || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAnimalssRelatedByFurcolourid) {
                // return empty collection
                $this->initAnimalssRelatedByFurcolourid();
            } else {
                $collAnimalssRelatedByFurcolourid = ChildAnimalsQuery::create(null, $criteria)
                    ->filterByColoursRelatedByFurcolourid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAnimalssRelatedByFurcolouridPartial && count($collAnimalssRelatedByFurcolourid)) {
                        $this->initAnimalssRelatedByFurcolourid(false);

                        foreach ($collAnimalssRelatedByFurcolourid as $obj) {
                            if (false == $this->collAnimalssRelatedByFurcolourid->contains($obj)) {
                                $this->collAnimalssRelatedByFurcolourid->append($obj);
                            }
                        }

                        $this->collAnimalssRelatedByFurcolouridPartial = true;
                    }

                    return $collAnimalssRelatedByFurcolourid;
                }

                if ($partial && $this->collAnimalssRelatedByFurcolourid) {
                    foreach ($this->collAnimalssRelatedByFurcolourid as $obj) {
                        if ($obj->isNew()) {
                            $collAnimalssRelatedByFurcolourid[] = $obj;
                        }
                    }
                }

                $this->collAnimalssRelatedByFurcolourid = $collAnimalssRelatedByFurcolourid;
                $this->collAnimalssRelatedByFurcolouridPartial = false;
            }
        }

        return $this->collAnimalssRelatedByFurcolourid;
    }

    /**
     * Sets a collection of ChildAnimals objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $animalssRelatedByFurcolourid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildColours The current object (for fluent API support)
     */
    public function setAnimalssRelatedByFurcolourid(Collection $animalssRelatedByFurcolourid, ConnectionInterface $con = null)
    {
        /** @var ChildAnimals[] $animalssRelatedByFurcolouridToDelete */
        $animalssRelatedByFurcolouridToDelete = $this->getAnimalssRelatedByFurcolourid(new Criteria(), $con)->diff($animalssRelatedByFurcolourid);


        $this->animalssRelatedByFurcolouridScheduledForDeletion = $animalssRelatedByFurcolouridToDelete;

        foreach ($animalssRelatedByFurcolouridToDelete as $animalsRelatedByFurcolouridRemoved) {
            $animalsRelatedByFurcolouridRemoved->setColoursRelatedByFurcolourid(null);
        }

        $this->collAnimalssRelatedByFurcolourid = null;
        foreach ($animalssRelatedByFurcolourid as $animalsRelatedByFurcolourid) {
            $this->addAnimalsRelatedByFurcolourid($animalsRelatedByFurcolourid);
        }

        $this->collAnimalssRelatedByFurcolourid = $animalssRelatedByFurcolourid;
        $this->collAnimalssRelatedByFurcolouridPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Animals objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Animals objects.
     * @throws PropelException
     */
    public function countAnimalssRelatedByFurcolourid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAnimalssRelatedByFurcolouridPartial && !$this->isNew();
        if (null === $this->collAnimalssRelatedByFurcolourid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAnimalssRelatedByFurcolourid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAnimalssRelatedByFurcolourid());
            }

            $query = ChildAnimalsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByColoursRelatedByFurcolourid($this)
                ->count($con);
        }

        return count($this->collAnimalssRelatedByFurcolourid);
    }

    /**
     * Method called to associate a ChildAnimals object to this object
     * through the ChildAnimals foreign key attribute.
     *
     * @param  ChildAnimals $l ChildAnimals
     * @return $this|\Colours The current object (for fluent API support)
     */
    public function addAnimalsRelatedByFurcolourid(ChildAnimals $l)
    {
        if ($this->collAnimalssRelatedByFurcolourid === null) {
            $this->initAnimalssRelatedByFurcolourid();
            $this->collAnimalssRelatedByFurcolouridPartial = true;
        }

        if (!$this->collAnimalssRelatedByFurcolourid->contains($l)) {
            $this->doAddAnimalsRelatedByFurcolourid($l);
        }

        return $this;
    }

    /**
     * @param ChildAnimals $animalsRelatedByFurcolourid The ChildAnimals object to add.
     */
    protected function doAddAnimalsRelatedByFurcolourid(ChildAnimals $animalsRelatedByFurcolourid)
    {
        $this->collAnimalssRelatedByFurcolourid[]= $animalsRelatedByFurcolourid;
        $animalsRelatedByFurcolourid->setColoursRelatedByFurcolourid($this);
    }

    /**
     * @param  ChildAnimals $animalsRelatedByFurcolourid The ChildAnimals object to remove.
     * @return $this|ChildColours The current object (for fluent API support)
     */
    public function removeAnimalsRelatedByFurcolourid(ChildAnimals $animalsRelatedByFurcolourid)
    {
        if ($this->getAnimalssRelatedByFurcolourid()->contains($animalsRelatedByFurcolourid)) {
            $pos = $this->collAnimalssRelatedByFurcolourid->search($animalsRelatedByFurcolourid);
            $this->collAnimalssRelatedByFurcolourid->remove($pos);
            if (null === $this->animalssRelatedByFurcolouridScheduledForDeletion) {
                $this->animalssRelatedByFurcolouridScheduledForDeletion = clone $this->collAnimalssRelatedByFurcolourid;
                $this->animalssRelatedByFurcolouridScheduledForDeletion->clear();
            }
            $this->animalssRelatedByFurcolouridScheduledForDeletion[]= clone $animalsRelatedByFurcolourid;
            $animalsRelatedByFurcolourid->setColoursRelatedByFurcolourid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Colours is new, it will return
     * an empty collection; or if this Colours has previously
     * been saved, it will retrieve related AnimalssRelatedByFurcolourid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Colours.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     */
    public function getAnimalssRelatedByFurcolouridJoinRaces(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAnimalsQuery::create(null, $criteria);
        $query->joinWith('Races', $joinBehavior);

        return $this->getAnimalssRelatedByFurcolourid($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Colours is new, it will return
     * an empty collection; or if this Colours has previously
     * been saved, it will retrieve related AnimalssRelatedByFurcolourid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Colours.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     */
    public function getAnimalssRelatedByFurcolouridJoinSpecies(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAnimalsQuery::create(null, $criteria);
        $query->joinWith('Species', $joinBehavior);

        return $this->getAnimalssRelatedByFurcolourid($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Colours is new, it will return
     * an empty collection; or if this Colours has previously
     * been saved, it will retrieve related AnimalssRelatedByFurcolourid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Colours.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     */
    public function getAnimalssRelatedByFurcolouridJoinSexes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAnimalsQuery::create(null, $criteria);
        $query->joinWith('Sexes', $joinBehavior);

        return $this->getAnimalssRelatedByFurcolourid($query, $con);
    }

    /**
     * Clears out the collAnimalssRelatedByEyecolourid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAnimalssRelatedByEyecolourid()
     */
    public function clearAnimalssRelatedByEyecolourid()
    {
        $this->collAnimalssRelatedByEyecolourid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAnimalssRelatedByEyecolourid collection loaded partially.
     */
    public function resetPartialAnimalssRelatedByEyecolourid($v = true)
    {
        $this->collAnimalssRelatedByEyecolouridPartial = $v;
    }

    /**
     * Initializes the collAnimalssRelatedByEyecolourid collection.
     *
     * By default this just sets the collAnimalssRelatedByEyecolourid collection to an empty array (like clearcollAnimalssRelatedByEyecolourid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAnimalssRelatedByEyecolourid($overrideExisting = true)
    {
        if (null !== $this->collAnimalssRelatedByEyecolourid && !$overrideExisting) {
            return;
        }
        $this->collAnimalssRelatedByEyecolourid = new ObjectCollection();
        $this->collAnimalssRelatedByEyecolourid->setModel('\Animals');
    }

    /**
     * Gets an array of ChildAnimals objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildColours is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     * @throws PropelException
     */
    public function getAnimalssRelatedByEyecolourid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAnimalssRelatedByEyecolouridPartial && !$this->isNew();
        if (null === $this->collAnimalssRelatedByEyecolourid || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAnimalssRelatedByEyecolourid) {
                // return empty collection
                $this->initAnimalssRelatedByEyecolourid();
            } else {
                $collAnimalssRelatedByEyecolourid = ChildAnimalsQuery::create(null, $criteria)
                    ->filterByColoursRelatedByEyecolourid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAnimalssRelatedByEyecolouridPartial && count($collAnimalssRelatedByEyecolourid)) {
                        $this->initAnimalssRelatedByEyecolourid(false);

                        foreach ($collAnimalssRelatedByEyecolourid as $obj) {
                            if (false == $this->collAnimalssRelatedByEyecolourid->contains($obj)) {
                                $this->collAnimalssRelatedByEyecolourid->append($obj);
                            }
                        }

                        $this->collAnimalssRelatedByEyecolouridPartial = true;
                    }

                    return $collAnimalssRelatedByEyecolourid;
                }

                if ($partial && $this->collAnimalssRelatedByEyecolourid) {
                    foreach ($this->collAnimalssRelatedByEyecolourid as $obj) {
                        if ($obj->isNew()) {
                            $collAnimalssRelatedByEyecolourid[] = $obj;
                        }
                    }
                }

                $this->collAnimalssRelatedByEyecolourid = $collAnimalssRelatedByEyecolourid;
                $this->collAnimalssRelatedByEyecolouridPartial = false;
            }
        }

        return $this->collAnimalssRelatedByEyecolourid;
    }

    /**
     * Sets a collection of ChildAnimals objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $animalssRelatedByEyecolourid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildColours The current object (for fluent API support)
     */
    public function setAnimalssRelatedByEyecolourid(Collection $animalssRelatedByEyecolourid, ConnectionInterface $con = null)
    {
        /** @var ChildAnimals[] $animalssRelatedByEyecolouridToDelete */
        $animalssRelatedByEyecolouridToDelete = $this->getAnimalssRelatedByEyecolourid(new Criteria(), $con)->diff($animalssRelatedByEyecolourid);


        $this->animalssRelatedByEyecolouridScheduledForDeletion = $animalssRelatedByEyecolouridToDelete;

        foreach ($animalssRelatedByEyecolouridToDelete as $animalsRelatedByEyecolouridRemoved) {
            $animalsRelatedByEyecolouridRemoved->setColoursRelatedByEyecolourid(null);
        }

        $this->collAnimalssRelatedByEyecolourid = null;
        foreach ($animalssRelatedByEyecolourid as $animalsRelatedByEyecolourid) {
            $this->addAnimalsRelatedByEyecolourid($animalsRelatedByEyecolourid);
        }

        $this->collAnimalssRelatedByEyecolourid = $animalssRelatedByEyecolourid;
        $this->collAnimalssRelatedByEyecolouridPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Animals objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Animals objects.
     * @throws PropelException
     */
    public function countAnimalssRelatedByEyecolourid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAnimalssRelatedByEyecolouridPartial && !$this->isNew();
        if (null === $this->collAnimalssRelatedByEyecolourid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAnimalssRelatedByEyecolourid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAnimalssRelatedByEyecolourid());
            }

            $query = ChildAnimalsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByColoursRelatedByEyecolourid($this)
                ->count($con);
        }

        return count($this->collAnimalssRelatedByEyecolourid);
    }

    /**
     * Method called to associate a ChildAnimals object to this object
     * through the ChildAnimals foreign key attribute.
     *
     * @param  ChildAnimals $l ChildAnimals
     * @return $this|\Colours The current object (for fluent API support)
     */
    public function addAnimalsRelatedByEyecolourid(ChildAnimals $l)
    {
        if ($this->collAnimalssRelatedByEyecolourid === null) {
            $this->initAnimalssRelatedByEyecolourid();
            $this->collAnimalssRelatedByEyecolouridPartial = true;
        }

        if (!$this->collAnimalssRelatedByEyecolourid->contains($l)) {
            $this->doAddAnimalsRelatedByEyecolourid($l);
        }

        return $this;
    }

    /**
     * @param ChildAnimals $animalsRelatedByEyecolourid The ChildAnimals object to add.
     */
    protected function doAddAnimalsRelatedByEyecolourid(ChildAnimals $animalsRelatedByEyecolourid)
    {
        $this->collAnimalssRelatedByEyecolourid[]= $animalsRelatedByEyecolourid;
        $animalsRelatedByEyecolourid->setColoursRelatedByEyecolourid($this);
    }

    /**
     * @param  ChildAnimals $animalsRelatedByEyecolourid The ChildAnimals object to remove.
     * @return $this|ChildColours The current object (for fluent API support)
     */
    public function removeAnimalsRelatedByEyecolourid(ChildAnimals $animalsRelatedByEyecolourid)
    {
        if ($this->getAnimalssRelatedByEyecolourid()->contains($animalsRelatedByEyecolourid)) {
            $pos = $this->collAnimalssRelatedByEyecolourid->search($animalsRelatedByEyecolourid);
            $this->collAnimalssRelatedByEyecolourid->remove($pos);
            if (null === $this->animalssRelatedByEyecolouridScheduledForDeletion) {
                $this->animalssRelatedByEyecolouridScheduledForDeletion = clone $this->collAnimalssRelatedByEyecolourid;
                $this->animalssRelatedByEyecolouridScheduledForDeletion->clear();
            }
            $this->animalssRelatedByEyecolouridScheduledForDeletion[]= clone $animalsRelatedByEyecolourid;
            $animalsRelatedByEyecolourid->setColoursRelatedByEyecolourid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Colours is new, it will return
     * an empty collection; or if this Colours has previously
     * been saved, it will retrieve related AnimalssRelatedByEyecolourid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Colours.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     */
    public function getAnimalssRelatedByEyecolouridJoinRaces(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAnimalsQuery::create(null, $criteria);
        $query->joinWith('Races', $joinBehavior);

        return $this->getAnimalssRelatedByEyecolourid($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Colours is new, it will return
     * an empty collection; or if this Colours has previously
     * been saved, it will retrieve related AnimalssRelatedByEyecolourid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Colours.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     */
    public function getAnimalssRelatedByEyecolouridJoinSpecies(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAnimalsQuery::create(null, $criteria);
        $query->joinWith('Species', $joinBehavior);

        return $this->getAnimalssRelatedByEyecolourid($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Colours is new, it will return
     * an empty collection; or if this Colours has previously
     * been saved, it will retrieve related AnimalssRelatedByEyecolourid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Colours.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAnimals[] List of ChildAnimals objects
     */
    public function getAnimalssRelatedByEyecolouridJoinSexes(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAnimalsQuery::create(null, $criteria);
        $query->joinWith('Sexes', $joinBehavior);

        return $this->getAnimalssRelatedByEyecolourid($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->colour = null;
        $this->code = null;
        $this->name = null;
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
            if ($this->collAnimalssRelatedByFurcolourid) {
                foreach ($this->collAnimalssRelatedByFurcolourid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAnimalssRelatedByEyecolourid) {
                foreach ($this->collAnimalssRelatedByEyecolourid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAnimalssRelatedByFurcolourid = null;
        $this->collAnimalssRelatedByEyecolourid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ColoursTableMap::DEFAULT_STRING_FORMAT);
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

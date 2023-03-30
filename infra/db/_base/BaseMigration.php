<?php

namespace infra\db\migrations;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ColumnSchemaBuilder;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\Migration;
use yii\db\Query;

/**
 * This class work correct only for PostgreSQL
 */
class BaseMigration extends Migration
{
    const DRIVER_PGSQL = 'pgsql';

    /** @var string */
    protected $tableName = null;

    /**
     * @param string $tableName
     *
     * @return boolean
     */
    public function isTableExist($tableName)
    {
        return ($this->db->schema->getTableSchema($tableName, true) !== null) ? true : false;
    }

    /**
     * @param string      $tableName
     * @param array       $columns
     * @param null|string $options
     *
     * @return boolean
     */
    public function addTableIfNotExist($tableName, $columns, $options = null)
    {
        if (!$this->isTableExist($tableName)) {
            $this->createTable($tableName, $columns, $options);

            return true;
        }

        return false;
    }

    /**
     * Удаляет таблицу, если та существует в БД.
     *
     * @param string  $tableName
     * @param boolean $cascade [false] - включать ли каскадное удаление зависимых сущностей
     *
     * @return boolean
     */
    public function dropTableIfExist($tableName, bool $cascade = false): bool
    {
        $tableName = $this->db->quoteTableName($tableName);
        if ($this->isTableExist($tableName)) {
            $time = $this->beginCommand("drop table $tableName");
            $this->getDb()->createCommand("DROP TABLE IF EXISTS $tableName" . ($cascade ? ' CASCADE' : ''))->execute();
            $this->endCommand($time);

            return true;
        }

        return false;
    }

    /**
     * @param $tableName
     * @param $fieldName
     *
     * @return bool
     * @throws NotSupportedException
     */
    public function isFieldExist($tableName, $fieldName)
    {
        $tableSchema = Yii::$app->db->getSchema()->getTableSchema($tableName);
        $columnNames = $tableSchema->getColumnNames();

        return in_array($fieldName, $columnNames) ? true : false;
    }

    /**
     * @param string $tableName
     * @param array  $fieldList
     * @param string $suffix
     *
     * @return string
     */
    public function getIndexName($tableName, array $fieldList, $suffix = 'idx')
    {
        $indexName = 'index_' . preg_replace('/[\{\%\}]/', '', $tableName);
        foreach ($fieldList as $item) {
            $indexName .= "_" . $item;
        }
        if ($suffix) {
            $indexName .= '_' . $suffix;
        }

        return substr($indexName, 0, 63);
    }

    /**
     * Realized only for PostgreSQL
     *
     * @param string $tableName
     * @param string $indexName
     *
     * @return boolean
     */
    public function isIndexExist($tableName, $indexName)
    {
        switch ($this->db->getDriverName()) {
            case static::DRIVER_PGSQL :
                $query = new Query;
                $query->from('pg_indexes');
                $query->where(['tablename' => $this->getTableNameClear($tableName)]);

                foreach ($query->all() as $index) {
                    if ($index['indexname'] == $indexName) {
                        return true;
                    }
                }
                break;
        }

        return false;
    }

    /**
     * @param string $tableName
     * @param string $columnName
     *
     * @return string
     */
    public function getConstraintName($tableName, $columnName, $suffix = 'key')
    {
        $constraintName = $tableName . '_' . $columnName;
        if ($suffix) {
            $constraintName .= '_' . $suffix;
        }

        return $constraintName;
    }

    /**
     * Realized only for PostgreSQL
     *
     * @param string $constraintName
     *
     * @return boolean
     */
    public function isConstraintExist($constraintName)
    {
        switch ($this->db->getDriverName()) {
            case static::DRIVER_PGSQL :
                $query = new Query;
                $query->from('pg_constraint');
                $query->where(['conname' => $constraintName]);

                return $query->exists();
        }

        return false;
    }

    /**
     * @param string       $tableName
     * @param array|string $fieldList
     * @param string       $suffix
     */
    public function addIndexIfNotExist($tableName, $fieldList, $suffix = null, $unique = false)
    {
        if (!is_array($fieldList)) {
            $fieldList = [$fieldList];
        }

        $indexName = $this->getIndexName($tableName, $fieldList, $suffix);
        if (!$this->isIndexExist($tableName, $indexName)) {
            $this->createIndex($indexName, $tableName, $fieldList, $unique);
        }
    }

    /**
     * @param string       $tableName
     * @param array|string $fieldList
     */
    public function dropIndexIfExist($tableName, $fieldList, $suffix = null)
    {
        if (!is_array($fieldList)) {
            $fieldList = [$fieldList];
        }

        $indexName = $this->getIndexName($tableName, $fieldList, $suffix);
        if ($this->isIndexExist($tableName, $indexName)) {
            $this->dropIndex($indexName, $tableName);
        }
    }

    /**
     * Конструирует по имени таблицы и поля имя для внешнего ключа.
     *
     * @param $tableName
     * @param $fieldName
     *
     * @return bool|string
     */
    public function getForeignKeyName($tableName, $fieldName)
    {
        $name = "fk_" . static::getTableNameClear($tableName) . "__" . $fieldName;

        return substr($name, 0, 63);
    }

    /**
     * @param $tableName
     * @param $fieldName
     *
     * @return bool
     * @throws NotSupportedException
     */
    public function isForeignKeyExist($tableName, $fieldName)
    {
        $fkName = $this->getForeignKeyName($tableName, $fieldName);
        $tableSchema = Yii::$app->db->getSchema()->getTableSchema($tableName);
        if (isset($tableSchema->foreignKeys[$fkName])) {
            return true;
        }

        return false;
    }

    /**
     * @param      $tableName
     * @param      $tableTo
     * @param      $fieldName
     * @param      $refField
     * @param null $delete
     * @param null $update
     *
     * @return bool
     * @throws NotSupportedException
     */
    public function addForeignKeyIfNotExist($tableName, $tableTo, $fieldName, $refField, $delete = null, $update = null)
    {
        $fkName = $this->getForeignKeyName($tableName, $fieldName);
        if (!$this->isForeignKeyExist($tableName, $fieldName)) {
            $this->addForeignKey($fkName, $tableName, $fieldName, $tableTo, $refField, $delete, $update);

            return true;
        }

        return false;
    }

    /**
     * @param $tableName
     * @param $fieldName
     *
     * @return bool
     * @throws NotSupportedException
     */
    public function dropForeignKeyIfExists($tableName, $fieldName)
    {
        $fkName = $this->getForeignKeyName($tableName, $fieldName);
        if ($this->isForeignKeyExist($tableName, $fieldName)) {
            $this->dropForeignKey($fkName, $tableName);

            return true;
        }

        return false;
    }

    /**
     * @param $table
     * @param $column
     */
    public function setColumnNull($table, $column)
    {
        $this->alterColumn($table, $column, 'DROP NOT NULL');
    }

    /**
     * @param $table
     * @param $column
     */
    public function setColumnNotNull($table, $column)
    {
        $this->alterColumn($table, $column, 'SET NOT NULL');
    }

    /**
     * @param $tableName
     */
    public function vacuumTable($tableName)
    {
        $this->execute("VACUUM FULL {$tableName}");
    }

    /**
     * @param $table
     * @param $column
     * @param $default
     */
    public function setColumnDefault($table, $column, $default)
    {
        $this->execute("ALTER TABLE {$table} ALTER COLUMN {$column} SET DEFAULT {$default}");
    }

    /**
     * @param null $precision
     *
     * @return ColumnSchemaBuilder
     * @throws NotSupportedException
     */
    public function timestampWithTimeZone($precision = null)
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('timestamp with time zone', $precision);
    }

    /**
     * @param      $tableName
     * @param      $sequenceFieldName
     * @param null $precision
     *
     * @return ColumnSchemaBuilder
     * @throws NotSupportedException
     */
    public function bigIntegerSequenceField($tableName, $sequenceFieldName, $precision = null)
    {

        $this->execute('CREATE SEQUENCE "' . $this->getTableNameClear($tableName) . '_' . $sequenceFieldName . '_seq"
            INCREMENT 1
            START 1
            MINVALUE -2147483648
            MAXVALUE 2147483647
            CACHE 1;');

        return $this
            ->getDb()
            ->getSchema()
            ->createColumnSchemaBuilder('bigint', $precision)
            ->unique()
            ->defaultExpression("nextval('\"" . $this->getTableNameClear($tableName) . "_" . $sequenceFieldName . "_seq\"'::regclass)");
    }

    /**
     * @param $tableName
     * @param $sequenceFieldName
     */
    public function dropSequence($tableName, $sequenceFieldName)
    {
        $this->execute('DROP SEQUENCE "' . $this->getTableNameClear($tableName) . "_" . $sequenceFieldName . '_seq"');
    }

    /**
     * Возвращает имя таблицы очищенное от дополнительных символов фреймворка и кавычек.
     *
     * @param $tableName
     *
     * @return null|string|string[]
     */
    public function getTableNameClear($tableName)
    {
        return preg_replace('/[^A-Za-z0-9\-_]+/', '', $tableName);
    }

    /**
     * @param $default
     *
     * @return $this
     */
    public function defaultExpression($default)
    {
        $this->default = new Expression($default);

        return $this;
    }

    /**
     * Расширенная версия создания индекса с возможностью более тонкой настройки.
     *
     * @param string $name
     * @param string $table
     * @param string $column
     * @param string $type - тип (метод) индекса (btree, hash, gist, spgist, gin и brin)
     * @param string $classOps
     * @param string $condition [''] - условие where для создания partial index
     *
     * @throws Exception - при ошибке запуска команды на сервере БД
     */
    public function createCustomIndex(string $name, string $table, string $column, string $type, string $classOps, string $condition = ''): void
    {
        $command = 'CREATE INDEX '
            . $this->db->quoteTableName($name) . ' ON '
            . $this->db->quoteTableName($table)
            . ' USING ' . $type . ' (' . $this->db->getQueryBuilder()->buildColumns($column) . ' ' . $classOps . ')'
            . (trim($condition) !== '' ? ' WHERE ' . $condition : '');

        $time = $this->beginCommand($command);
        $this->db->createCommand($command)->execute();
        $this->endCommand($time);
    }

    /**
     * Создает индекс для полей типа inet и cidr с методом GIN и классом операций inet_ops.
     *
     * @param string      $table
     * @param string      $column
     * @param string|null $suffix
     *
     * @throws Exception
     */
    public function createInetIndex($table, $column, ?string $suffix = null): void
    {
        $indexName = $this->getIndexName($table, [$column], $suffix);
        $this->createCustomIndex($indexName, $table, $column, 'GIST', 'inet_ops');
    }
}

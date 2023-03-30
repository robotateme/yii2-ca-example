<?php

namespace infra\db\_base;

use domain\scenarios\_interfaces\DbRepositoryInterface;
use RuntimeException;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Transaction;

/**
 * Class BaseRepository
 *
 * @package landing\useCases
 */
abstract class BaseDbRepository implements DbRepositoryInterface
{
    /**
     * @var int|null Для предоставления доступа пользователю только к его данным
     */
    protected $userId;

    /**
     * @var Transaction|null В данный момент НЕ поддерживается вложенность
     */
    private $transaction;

    /**
     * BaseRepository constructor.
     *
     * @param int|null $userId
     */
    public function __construct(?int $userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction(): void
    {
        if ($this->inTransaction()) {
            throw new RuntimeException('Transaction already created.');
        }

        $this->transaction = $this->getModel()::getDb()->beginTransaction();
    }

    /**
     * @return bool
     */
    public function inTransaction(): bool
    {
        return $this->transaction !== null && $this->transaction->isActive;
    }

    /**
     * @return string
     */
    abstract protected static function getModelClass(): string;

    /**
     * @return ActiveRecord
     */
    private function getModel(): ActiveRecord
    {
        $modelClass = static::getModelClass();

        return new $modelClass;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function commitTransaction(): void
    {
        $this->transaction->commit();
    }

    /**
     * @inheritDoc
     */
    public function rollbackTransaction(): void
    {
        $this->transaction->rollBack();
    }
}
<?php

declare(strict_types=1);

namespace common\base;

use mootensai\behaviors\UUIDBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

/**
 * Base ActiveRecord for all application models.
 *
 * Features:
 * - TimestampBehavior
 * - BlameableBehavior
 * - UUIDBehavior
 * - Optimistic Lock
 * - Soft Delete / Restore
 * - Hybrid RelationTrait support
 * - Soft delete support
 * - Hybrid load/save/delete for RelationTrait models
 * - Consistent API for generated and non-generated models
 *
 * Models using softDelete() should provide the following columns:
 * - is_deleted
 * - deleted_at
 * - deleted_by
 */
abstract class BaseActiveRecord extends ActiveRecord
{
    private ?bool $_hasManagedRelations = null;

    /**
     * Common behaviors
     * @inheritdoc
     * @return array mixed
     *
     */
    public function behaviors(): array
    {
        return [

            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => static fn() => date('Y-m-d H:i:s')
            ],

            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => static fn() => Yii::$app->user->id ?? null,
            ],

            'uuid' => [
                'class' => UUIDBehavior::class,
                'column' => 'uuid',
            ],

        ];
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock(): string
    {
        return 'verlock';
    }

    /**
     * Attributes used for soft delete.
     */
    protected function softDeleteAttributes(): array
    {
        return [
            'is_deleted' => 1,
            'deleted_at' => new Expression('NOW()'),
            'deleted_by' => Yii::$app->user->id ?? null,
        ];
    }

    /**
     * Attributes used for restore.
     */
    protected function restoreAttributes(): array
    {
        return [
            'is_deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null,
        ];
    }

    /**
     * Soft delete the current model.
     */
    public function softDelete(): bool
    {
        return $this->updateAttributes(
                $this->softDeleteAttributes()
            ) > 0;
    }

    /**
     * Restore current model.
     */
    public function restore(): bool
    {
        return $this->updateAttributes(
                $this->restoreAttributes()
            ) > 0;
    }

    /**
     * Detect RelationTrait only once.
     */
    protected function hasManagedRelations(): bool
    {
        if ($this->_hasManagedRelations !== null) {
            return $this->_hasManagedRelations;
        }

        $this->_hasManagedRelations =
            method_exists($this, 'loadAll')
            && method_exists($this, 'saveAll')
            && method_exists($this, 'relationNames')
            && !empty($this->relationNames());

        return $this->_hasManagedRelations;
    }

    /**
     * Hybrid load().
     */
    public function loadSafely(array $data): bool
    {
        if ($this->hasManagedRelations()) {
            return $this->loadAll($data);
        }

        return $this->load($data);
    }

    /**
     * Hybrid save().
     *
     * @throws Exception
     */
    public function saveSafely(): bool
    {
        if ($this->hasManagedRelations()) {
            return $this->saveAll();
        }

        return $this->save();
    }

    /**
     * Hybrid delete().
     */
    public function deleteSafely(): bool
    {
        try {

            if ($this->hasManagedRelations()
                && method_exists($this, 'deleteWithRelated')) {

                return (bool)$this->deleteWithRelated();
            }

            return (bool)$this->delete();

        } catch (StaleObjectException|\Throwable $e) {

            Yii::error($e, static::class);

            return false;
        }
    }
}
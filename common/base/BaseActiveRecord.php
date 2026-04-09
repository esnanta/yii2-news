<?php

namespace common\base;

use mootensai\relation\RelationTrait;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\StaleObjectException;

abstract class BaseActiveRecord extends ActiveRecord
{
    /**
     * Hybrid loader.
     */
    public function loadSafely(array $data, ?string $formName = null): bool
    {
        if ($this->hasManagedRelations() && method_exists($this, 'loadAll')) {
            return $this->loadAll($data, $formName);
        }

        return $this->load($data, $formName);
    }

    /**
     * Hybrid saver.
     *
     * @throws Exception
     */
    public function saveSafely(): bool
    {
        if ($this->hasManagedRelations() && method_exists($this, 'saveAll')) {
            return $this->saveAll();
        }

        return $this->save();
    }

    /**
     * Hybrid delete.
     */
    public function deleteSafely(): bool
    {
        try {
            if ($this->hasManagedRelations() && method_exists($this, 'deleteWithRelated')) {
                return (bool) $this->deleteWithRelated();
            }

            return (bool) $this->delete();
        } catch (StaleObjectException|\Throwable $e) {
            return false;
        }
    }

    protected function hasManagedRelations(): bool
    {
        if (in_array(RelationTrait::class, class_uses($this), true)
            && method_exists($this, 'relationNames')
        ) {
            return !empty($this->relationNames());
        }

        return false;
    }
}

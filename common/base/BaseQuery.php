<?php

declare(strict_types=1);

namespace common\base;

use yii\db\ActiveQuery;

abstract class BaseQuery extends ActiveQuery
{
    /**
     * Returns a fully qualified column name.
     *
     * Prefixes the given column with the primary table name to prevent
     * ambiguous column references when the query contains JOIN clauses.
     *
     * Example:
     * - qualify('id')   => t_area.id
     * - qualify('uuid') => t_area.uuid
     *
     * @param string $column Column name without a table prefix.
     * @return string Fully qualified column name.
     */
    protected function qualify(string $column): string
    {
        return $this->getPrimaryTableName() . '.' . $column;
    }

    /**
     * Restricts the query to active (non-deleted) records.
     */
    public function active(): static
    {
        return $this->andWhere([
            $this->qualify('is_deleted') => 0,
        ]);
    }

    /**
     * Restricts the query to soft-deleted records.
     */
    public function deleted(): static
    {
        return $this->andWhere([
            $this->qualify('is_deleted') => 1,
        ]);
    }

    /**
     * Filters the query by the primary key.
     *
     * @param int|string $id Primary key value.
     */
    public function byId(int|string $id): static
    {
        return $this->andWhere([
            $this->qualify('id') => $id,
        ]);
    }

    /**
     * Filters the query by UUID.
     *
     * @param string $uuid UUID value.
     */
    public function byUuid(string $uuid): static
    {
        return $this->andWhere([
            $this->qualify('uuid') => $uuid,
        ]);
    }
}
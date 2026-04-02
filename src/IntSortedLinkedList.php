<?php declare(strict_types = 1);

namespace App\SortedLinkedList;

use App\SortedLinkedList\Internal\AbstractSortedLinkedList;
use LogicException;
use Traversable;
use function is_int;

/**
 * Sorted linked list for integer values.
 *
 * @extends AbstractSortedLinkedList<int>
 *
 * @method int count()
 * @method bool isEmpty()
 * @method list<int> toArray()
 * @method Traversable<int, int> getIterator()
 */
final class IntSortedLinkedList extends AbstractSortedLinkedList
{

    protected function compare(
        int|string $left,
        int|string $right,
    ): int
    {
        if (!is_int($left) || !is_int($right)) {
            throw new LogicException('IntSortedLinkedList can only compare integers.');
        }

        return $left <=> $right;
    }

    public function insert(int $value): void
    {
        $this->doInsert($value);
    }

    public function remove(int $value): bool
    {
        return $this->doRemove($value);
    }

    public function contains(int $value): bool
    {
        return $this->doContains($value);
    }

}

<?php declare(strict_types = 1);

namespace App\SortedLinkedList;

use App\SortedLinkedList\Internal\AbstractSortedLinkedList;
use LogicException;
use Traversable;
use function is_string;
use function strcmp;

/**
 * Sorted linked list for string values.
 *
 * @extends AbstractSortedLinkedList<string>
 *
 * @method int count()
 * @method bool isEmpty()
 * @method list<string> toArray()
 * @method Traversable<int, string> getIterator()
 */
final class StringSortedLinkedList extends AbstractSortedLinkedList
{

    protected function compare(
        int|string $left,
        int|string $right,
    ): int
    {
        if (!is_string($left) || !is_string($right)) {
            throw new LogicException('StringSortedLinkedList can only compare strings.');
        }

        return strcmp($left, $right);
    }

    public function insert(string $value): void
    {
        $this->doInsert($value);
    }

    public function remove(string $value): bool
    {
        return $this->doRemove($value);
    }

    public function contains(string $value): bool
    {
        return $this->doContains($value);
    }

}

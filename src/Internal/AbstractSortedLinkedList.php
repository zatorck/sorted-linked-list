<?php declare(strict_types = 1);

namespace App\SortedLinkedList\Internal;

use Countable;
use IteratorAggregate;
use Traversable;
use function assert;

/**
 * @template TValue of int|string
 * @implements IteratorAggregate<int, TValue>
 *
 * @internal
 */
abstract class AbstractSortedLinkedList implements Countable, IteratorAggregate
{

    /**
     * @var ?Node<TValue>
     */
    protected ?Node $head = null;

    /**
     * @var int<0, max>
     */
    protected int $count = 0;

    /**
     * @param TValue $left
     * @param TValue $right
     */
    abstract protected function compare(
        int|string $left,
        int|string $right,
    ): int;

    /**
     * @param TValue $value
     */
    protected function doInsert(int|string $value): void
    {
        /** @var Node<TValue> $node */
        $node = new Node($value);

        if ($this->head === null) {
            $this->head = $node;
            $this->count++;

            return;
        }

        if ($this->compare($value, $this->head->getValue()) < 0) {
            $node->setNext($this->head);
            $this->head = $node;
            $this->count++;

            return;
        }

        $current = $this->head;

        while (
            $current->getNext() !== null
            && $this->compare($current->getNext()->getValue(), $value) <= 0
        ) {
            $current = $current->getNext();
        }

        $node->setNext($current->getNext());
        $current->setNext($node);
        $this->count++;
    }

    /**
     * @param TValue $value
     */
    protected function doRemove(int|string $value): bool
    {
        if ($this->head === null) {
            return false;
        }

        if ($this->compare($this->head->getValue(), $value) === 0) {
            assert($this->count > 0);
            $this->head = $this->head->getNext();
            $this->count--;

            return true;
        }

        $current = $this->head;

        while (
            $current->getNext() !== null
            && $this->compare($current->getNext()->getValue(), $value) < 0
        ) {
            $current = $current->getNext();
        }

        if ($current->getNext() === null || $this->compare($current->getNext()->getValue(), $value) !== 0) {
            return false;
        }

        $next = $current->getNext();
        assert($this->count > 0);
        $current->setNext($next->getNext());
        $this->count--;

        return true;
    }

    /**
     * @param TValue $value
     */
    protected function doContains(int|string $value): bool
    {
        $current = $this->head;

        while ($current !== null) {
            $comparison = $this->compare($current->getValue(), $value);

            if ($comparison === 0) {
                return true;
            }

            if ($comparison > 0) {
                return false;
            }

            $current = $current->getNext();
        }

        return false;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function isEmpty(): bool
    {
        return $this->count === 0;
    }

    /**
     * @return list<TValue>
     */
    public function toArray(): array
    {
        $values = [];
        $current = $this->head;

        while ($current !== null) {
            $values[] = $current->getValue();
            $current = $current->getNext();
        }

        /** @var list<TValue> $values */
        return $values;
    }

    public function getIterator(): Traversable
    {
        $current = $this->head;

        while ($current !== null) {
            yield $current->getValue();
            $current = $current->getNext();
        }
    }

}

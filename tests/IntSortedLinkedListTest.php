<?php declare(strict_types = 1);

namespace App\SortedLinkedList\Tests;

use App\SortedLinkedList\IntSortedLinkedList;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use function iterator_to_array;
use const PHP_INT_MAX;
use const PHP_INT_MIN;

final class IntSortedLinkedListTest extends TestCase
{

    #[Test]
    public function itIsEmptyByDefault(): void
    {
        $list = new IntSortedLinkedList();

        self::assertTrue($list->isEmpty());
        self::assertSame(0, $list->count());
        self::assertSame([], $list->toArray());
        self::assertSame([], iterator_to_array($list, false));
    }

    #[Test]
    public function itKeepsInsertedValuesSorted(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(10);
        $list->insert(3);
        $list->insert(7);
        $list->insert(7);
        $list->insert(1);

        self::assertSame([1, 3, 7, 7, 10], $list->toArray());
        self::assertCount(5, $list);
        self::assertFalse($list->isEmpty());
    }

    #[Test]
    public function itChecksWhetherValueExists(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(2);
        $list->insert(5);
        $list->insert(9);

        self::assertTrue($list->contains(5));
        self::assertFalse($list->contains(7));
    }

    #[Test]
    public function itReturnsFalseWhenCheckingContainsOnEmptyList(): void
    {
        $list = new IntSortedLinkedList();

        self::assertFalse($list->contains(1));
    }

    #[Test]
    public function itRemovesOnlyTheFirstMatchingOccurrence(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(4);
        $list->insert(2);
        $list->insert(4);
        $list->insert(1);

        self::assertTrue($list->remove(4));
        self::assertSame([1, 2, 4], $list->toArray());
        self::assertCount(3, $list);
    }

    #[Test]
    public function itReturnsFalseWhenRemovingMissingValue(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(1);
        $list->insert(3);

        self::assertFalse($list->remove(2));
        self::assertSame([1, 3], $list->toArray());
    }

    #[Test]
    public function itReturnsFalseWhenRemovingFromEmptyList(): void
    {
        $list = new IntSortedLinkedList();

        self::assertFalse($list->remove(123));
        self::assertSame([], $list->toArray());
    }

    #[Test]
    public function itRemovesHeadElement(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(5);
        $list->insert(1);
        $list->insert(9);

        self::assertTrue($list->remove(1));
        self::assertSame([5, 9], $list->toArray());
        self::assertCount(2, $list);
    }

    #[Test]
    public function itRemovesTailElement(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(5);
        $list->insert(1);
        $list->insert(9);

        self::assertTrue($list->remove(9));
        self::assertSame([1, 5], $list->toArray());
        self::assertCount(2, $list);
    }

    #[Test]
    public function itRemovesTheOnlyElement(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(42);

        self::assertTrue($list->remove(42));
        self::assertTrue($list->isEmpty());
        self::assertSame([], $list->toArray());
        self::assertCount(0, $list);
    }

    #[Test]
    public function itHandlesAlreadySortedInput(): void
    {
        $list = new IntSortedLinkedList();

        foreach ([1, 2, 3, 4, 5] as $value) {
            $list->insert($value);
        }

        self::assertSame([1, 2, 3, 4, 5], $list->toArray());
    }

    #[Test]
    public function itHandlesReverseSortedInput(): void
    {
        $list = new IntSortedLinkedList();

        foreach ([5, 4, 3, 2, 1] as $value) {
            $list->insert($value);
        }

        self::assertSame([1, 2, 3, 4, 5], $list->toArray());
    }

    #[Test]
    public function itHandlesExtremeIntegerValues(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(PHP_INT_MAX);
        $list->insert(0);
        $list->insert(PHP_INT_MIN);

        self::assertSame([PHP_INT_MIN, 0, PHP_INT_MAX], $list->toArray());
    }

    #[Test]
    public function itPreservesAllDuplicateValues(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(2);
        $list->insert(2);
        $list->insert(2);

        self::assertSame([2, 2, 2], $list->toArray());
        self::assertTrue($list->remove(2));
        self::assertSame([2, 2], $list->toArray());
    }

    #[Test]
    public function itCanBeIterated(): void
    {
        $list = new IntSortedLinkedList();

        $list->insert(8);
        $list->insert(1);
        $list->insert(5);

        self::assertSame([1, 5, 8], iterator_to_array($list, false));
    }

}

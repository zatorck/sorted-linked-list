<?php declare(strict_types = 1);

namespace App\SortedLinkedList\Tests;

use App\SortedLinkedList\StringSortedLinkedList;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class StringSortedLinkedListTest extends TestCase
{

    #[Test]
    public function itKeepsStringsSortedLexicographically(): void
    {
        $list = new StringSortedLinkedList();

        $list->insert('pear');
        $list->insert('apple');
        $list->insert('banana');
        $list->insert('banana');

        self::assertSame(['apple', 'banana', 'banana', 'pear'], $list->toArray());
        self::assertCount(4, $list);
    }

    #[Test]
    public function itTreatsUppercaseAndLowercaseAsDistinctValues(): void
    {
        $list = new StringSortedLinkedList();

        $list->insert('Banana');
        $list->insert('apple');
        $list->insert('Apple');

        self::assertSame(['Apple', 'Banana', 'apple'], $list->toArray());
    }

    #[Test]
    public function itSupportsEmptyStrings(): void
    {
        $list = new StringSortedLinkedList();

        $list->insert('zeta');
        $list->insert('');
        $list->insert('alpha');

        self::assertSame(['', 'alpha', 'zeta'], $list->toArray());
        self::assertTrue($list->contains(''));
        self::assertTrue($list->remove(''));
        self::assertSame(['alpha', 'zeta'], $list->toArray());
    }

    #[Test]
    public function itSupportsContainsAndRemoval(): void
    {
        $list = new StringSortedLinkedList();

        $list->insert('delta');
        $list->insert('beta');
        $list->insert('gamma');

        self::assertTrue($list->contains('beta'));
        self::assertFalse($list->contains('alpha'));
        self::assertTrue($list->remove('beta'));
        self::assertSame(['delta', 'gamma'], $list->toArray());
    }

    #[Test]
    public function itIsEmptyByDefault(): void
    {
        $list = new StringSortedLinkedList();

        self::assertTrue($list->isEmpty());
        self::assertSame([], $list->toArray());
    }

    #[Test]
    public function itReturnsFalseForMissingStringOperationsOnEmptyList(): void
    {
        $list = new StringSortedLinkedList();

        self::assertFalse($list->contains('missing'));
        self::assertFalse($list->remove('missing'));
    }

    #[Test]
    public function itRemovesTheOnlyStringElement(): void
    {
        $list = new StringSortedLinkedList();

        $list->insert('only');

        self::assertTrue($list->remove('only'));
        self::assertTrue($list->isEmpty());
        self::assertSame([], $list->toArray());
    }

}

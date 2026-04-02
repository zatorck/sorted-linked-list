# Sorted Linked List

A small PHP library providing sorted linked lists for either `int` or `string` values.

The library exposes two strongly typed list implementations:

- `App\SortedLinkedList\IntSortedLinkedList`
- `App\SortedLinkedList\StringSortedLinkedList`

Each list keeps its elements sorted automatically during insertion and does not allow mixing value types.

## Requirements

- PHP `^8.5`

## Quick Start

```php
<?php

declare(strict_types=1);

use App\SortedLinkedList\IntSortedLinkedList;

$list = new IntSortedLinkedList();
$list->insert(10);
$list->insert(3);
$list->insert(7);
$list->insert(7);
$list->insert(1);

var_dump($list->toArray());   // [1, 3, 7, 7, 10]
var_dump($list->contains(7)); // true
var_dump($list->remove(7));   // true
var_dump($list->toArray());   // [1, 3, 7, 10]

foreach ($list as $value) {
    echo $value . PHP_EOL;
}
```

## Public API

Both public classes expose the same API shape, but with different value types:

### `IntSortedLinkedList`

```php
insert(int $value): void
remove(int $value): bool
contains(int $value): bool
count(): int
isEmpty(): bool
toArray(): array
getIterator(): Traversable
```

### `StringSortedLinkedList`

```php
insert(string $value): void
remove(string $value): bool
contains(string $value): bool
count(): int
isEmpty(): bool
toArray(): array
getIterator(): Traversable
```

## Behavior

### Sorting

- Values are kept in ascending order at all times.
- `IntSortedLinkedList` uses numeric ordering.
- `StringSortedLinkedList` uses lexicographical ordering via `strcmp()`.

### Duplicates

- Duplicate values are allowed.
- New duplicates are inserted after existing equal values.

Example:

```php
$list = new IntSortedLinkedList();
$list->insert(4);
$list->insert(2);
$list->insert(4);

$list->toArray(); // [2, 4, 4]
```

### Removal Semantics

- `remove()` removes the first matching occurrence.
- If the value is not present, `remove()` returns `false`.
- Removing from an empty list also returns `false`.

### Iteration

- The lists implement `IteratorAggregate`.
- Iteration yields stored values, not internal nodes.

Example:

```php
$list = new StringSortedLinkedList();
$list->insert('pear');
$list->insert('apple');
$list->insert('banana');

foreach ($list as $value) {
    echo $value . PHP_EOL;
}

// apple
// banana
// pear
```

## Complexity

This implementation is based on a singly linked list.

- `insert()` is `O(n)`
- `remove()` is `O(n)`
- `contains()` is `O(n)`
- `count()` is `O(1)`
- `isEmpty()` is `O(1)`
- `toArray()` is `O(n)`
- iteration is `O(n)`

## Design Decisions

- Two separate public classes are provided instead of a single mixed-type list.
  This keeps the API explicit and type-safe in PHP.
- The implementation is intentionally singly linked.
  A `prev` pointer was not added because the current public API does not require backward traversal.
- Internal node objects are hidden from consumers of the library.
  Users interact with values rather than implementation details.
- The library favors a small, predictable API over additional low-level operations.

## Edge Cases Covered by Tests

The test suite covers:

- empty lists
- sorted and reverse-sorted input
- duplicate values
- removing head, tail, and the only element
- missing values
- integer boundary values
- empty strings
- case-sensitive string ordering
- iteration and array conversion

## Development

Run the test suite with:

```bash
composer test
```

Check coding style with:

```bash
composer cs
```

Automatically fix style issues that are fixable by PHPCS with:

```bash
composer cs-fix
```

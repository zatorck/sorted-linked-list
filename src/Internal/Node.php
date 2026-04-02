<?php declare(strict_types = 1);

namespace App\SortedLinkedList\Internal;

/**
 * @template TValue of int|string
 *
 * @internal
 */
final class Node
{

    /**
     * @var TValue
     */
    private int|string $value;

    /**
     * @var ?self<TValue>
     */
    private ?self $next;

    /**
     * @param TValue $value
     * @param ?self<TValue> $next
     */
    public function __construct(
        int|string $value,
        ?self $next = null,
    )
    {
        $this->value = $value;
        $this->next = $next;
    }

    /**
     * @return TValue
     */
    public function getValue(): int|string
    {
        return $this->value;
    }

    /**
     * @return ?self<TValue>
     */
    public function getNext(): ?self
    {
        return $this->next;
    }

    /**
     * @param ?self<TValue> $next
     */
    public function setNext(?self $next): void
    {
        $this->next = $next;
    }

}

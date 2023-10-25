<?php
//
//namespace BlogApiSlim\Models;
//use Assert\Assertion;
//use Assert\AssertionFailedException;
//class actors
//{
//    /**
//     * @throws AssertionFailedException
//     */
//    public function __construct(private readonly string $actors)
//    {
//        Assertion::minLength($this->actors, 2, 'The actor name must be minimum 2 characters.');
//        Assertion::string($this->actors, "actor name must be a string.");
//    }
//
//    public function toString(): string
//    {
//        return $this->actors;
//    }
//
//    public function __toString(): string
//    {
//        return $this->toString();
//    }
//}
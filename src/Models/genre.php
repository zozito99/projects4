<?php
//
//namespace BlogApiSlim\Models;
//use Assert\Assertion;
//use Assert\AssertionFailedException;
//class genre
//{
//    /**
//     * @throws AssertionFailedException
//     */
//    public function __construct(private readonly string $genre)
//    {
//        Assertion::minLength($this->genre, 5, 'The title must be minimum 5 characters.');
//        Assertion::string($this->genre, "Title must be a string.");
//    }
//
//    public function toString(): string
//    {
//        return $this->genre;
//    }
//
//    public function __toString(): string
//    {
//        return $this->toString();
//    }
//}
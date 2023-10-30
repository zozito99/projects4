<?php
//
//namespace BlogApiSlim\Models;
//use Assert\Assertion;
//use Assert\AssertionFailedException;
//class director
//{
//    /**
//     * @throws AssertionFailedException
//     */
//    public function __construct(private readonly string $director)
//    {
//        Assertion::minLength($this->director, 2, 'The director name must be minimum 2 characters.');
//        Assertion::string($this->director, "Title must be a string.");
//    }
//
//    public function toString(): string
//    {
//        return $this->director;
//    }
//
//    public function __toString(): string
//    {
//        return $this->toString();
//    }
//}
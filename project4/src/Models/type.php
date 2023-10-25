<?php
//
//namespace BlogApiSlim\Models;
//use Assert\Assertion;
//use Assert\AssertionFailedException;
//class type
//{
//    /**
//     * @throws AssertionFailedException
//     */
//    public function __construct(private readonly string $type)
//    {
//        Assertion::minLength($this->type, 3, 'The type must be minimum 3 characters.');
//        Assertion::string($this->type, "Type must be a string.");
//    }
//
//    public function toString(): string
//    {
//        return $this->type;
//    }
//
//    public function __toString(): string
//    {
//        return $this->toString();
//    }
//}
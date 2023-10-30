<?php
//
//namespace BlogApiSlim\Models;
//use Assert\Assertion;
//use Assert\AssertionFailedException;
//class country
//{
//    /**
//     * @throws AssertionFailedException
//     */
//    public function __construct(private readonly string $country)
//    {
//        Assertion::minLength($this->country, 3, 'The country name must be minimum 3 characters.');
//        Assertion::string($this->country, "country must be a string.");
//    }
//
//    public function toString(): string
//    {
//        return $this->country;
//    }
//
//    public function __toString(): string
//    {
//        return $this->toString();
//    }
//}
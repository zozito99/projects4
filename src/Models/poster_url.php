<?php
//
//namespace BlogApiSlim\Models;
//use Assert\Assertion;
//use Assert\AssertionFailedException;
//class poster_url
//{
//
//    /**
//     * @throws AssertionFailedException
//     */
//    public function __construct(private readonly string $image)
//    {
//        Assertion::notEmpty($this->image, 'The image can\'t be empty');
//        Assertion::url($this->image, 'The image must be an URL');
//    }
//
//    public function toString(): string
//    {
//        return $this->image;
//    }
//
//    public function __toString(): string
//    {
//        return $this->toString();
//    }
//}
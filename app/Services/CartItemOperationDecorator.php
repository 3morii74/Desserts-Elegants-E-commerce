<?php
namespace App\Services;

abstract class CartItemOperationDecorator implements CartItemOperation
{
    protected $cartItemOperation;

    public function __construct(CartItemOperation $cartItemOperation)
    {
        $this->cartItemOperation = $cartItemOperation;
    }

    abstract public function updateItem($item);
}

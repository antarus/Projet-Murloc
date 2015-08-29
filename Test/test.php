<?php

class MoneyTest extends PHPUnit_Framework_TestCase {

    // ...

    public function testCanBeNegated() {
        // Arrange
        $a = new Battlenet();

        // Act
        $b = $a->negate();

        // Assert
        $this->assertEquals(-1, $b->getAmount());
    }

    // ...
}

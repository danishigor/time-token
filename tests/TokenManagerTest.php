<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DanishIgor\TimeToken\TokenManager;

final class TokenManagerTest extends TestCase
{
    public function testExceptionTypeLifetime()
    {
        $this->expectException(InvalidArgumentException::class);

        new TokenManager("100");
    }

    public function testExceptionValueLifetime()
    {
        $this->expectException(RangeException::class);

        new TokenManager(0);
    }

    public function testExceptionTypeLength()
    {
        $this->expectException(InvalidArgumentException::class);

        new TokenManager(100, "32");
    }

    public function testExceptionValueLength()
    {
        $this->expectException(RangeException::class);

        new TokenManager(100, 5);
    }

    public function testExceptionTypeCharacters()
    {
        $this->expectException(InvalidArgumentException::class);

        new TokenManager(100, 100, "characters");
    }

    public function testExceptionValueCharacters()
    {
        $this->expectException(RangeException::class);

        new TokenManager(100, 100, []);
    }

    public function testTokenGeneratedLifetime(): void
    {
        $tokenManager = new TokenManager(5);
        $this->assertEquals(
            true,
            $tokenManager->check($tokenManager->generate()),
            'The token did not live the specified 5 seconds.'
        );

        $tokenManager = new TokenManager(1);
        $token = $tokenManager->generate();
        sleep(2);
        $this->assertEquals(
            false,
            $tokenManager->check($token),
            'The token lived for more than the specified second.'
        );
    }

    public function testTokenGeneratedLength(): void
    {
        $this->assertEquals(32, strlen((new TokenManager())->generate()));
        $this->assertEquals(100, strlen((new TokenManager(3600, 100))->generate()));
    }
}

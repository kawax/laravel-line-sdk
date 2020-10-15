<?php

namespace Tests\Socialite;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;
use Revolution\Line\Socialite\LineNotifyProvider;
use Tests\TestCase;

class LineNotifyProviderTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        m::close();
    }

    public function testInstance()
    {
        $provider = Socialite::driver('line-notify');

        $this->assertInstanceOf(LineNotifyProvider::class, $provider);
    }

    public function testRedirect()
    {
        $request = m::mock(Request::class);

        $provider = new LineNotifyProvider($request, 'client_id', 'client_secret', 'redirect');
        $provider->stateless();
        $response = $provider->redirect();

        $this->assertStringStartsWith('https://notify-bot.line.me', $response->getTargetUrl());
    }

    public function testUser()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('input')
            ->with('code')
            ->andReturn('fake-code');

        $accessTokenResponse = m::mock(ResponseInterface::class);
        $accessTokenResponse->shouldReceive('getBody')
            ->andReturn(json_encode(['access_token' => 'fake-token']));

        $guzzle = m::mock(Client::class);
        $guzzle->shouldReceive('post')->once()->andReturn($accessTokenResponse);

        $provider = new LineNotifyProvider($request, 'client_id', 'client_secret', 'redirect');
        $provider->stateless();
        $provider->setHttpClient($guzzle);

        $user = $provider->user();

        $this->assertSame('fake-token', $user->token);
    }
}

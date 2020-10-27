<?php

namespace Tests\Socialite;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;
use LINE\LINEBot;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;
use Revolution\Line\Socialite\LineLoginProvider;
use Tests\TestCase;

class LineLoginProviderTest extends TestCase
{
    public function testInstance()
    {
        $provider = Socialite::driver('line-login');

        $this->assertInstanceOf(LineLoginProvider::class, $provider);
    }

    public function testRedirect()
    {
        $request = m::mock(Request::class);

        $provider = new LineLoginProvider($request, 'client_id', 'client_secret', 'redirect');
        $provider->stateless();
        $response = $provider->redirect();

        $this->assertStringStartsWith('https://access.line.me', $response->getTargetUrl());
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

        $basicProfileResponse = m::mock(ResponseInterface::class);
        $basicProfileResponse->shouldReceive('getBody')
            ->andReturn(json_encode([
                'userId' => $userId = 'test',
                'displayName' => 'displayName',
                'pictureUrl' => 'pictureUrl',
            ]));

        $guzzle = m::mock(Client::class);
        $guzzle->shouldReceive('post')->once()->andReturn($accessTokenResponse);
        $guzzle->shouldReceive('get')
            ->with(LINEBot::DEFAULT_ENDPOINT_BASE.'/v2/profile', [
                'headers' => [
                    'Authorization' => 'Bearer fake-token',
                ],
            ])->andReturn($basicProfileResponse);

        $provider = new LineLoginProvider($request, 'client_id', 'client_secret', 'redirect');
        $provider->stateless();
        $provider->setHttpClient($guzzle);

        $user = $provider->user();

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($userId, $user->getId());
    }
}

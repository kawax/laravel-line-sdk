<?php

namespace Revolution\Line\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class LineNotifyProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * @var string
     */
    protected $endpoint = 'https: //notify-bot.line.me';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [
        'notify',
    ];

    /**
     * The separating character for the requested scopes.
     *
     * @var string
     */
    protected $scopeSeparator = ' ';

    /**
     * The type of the encoding in the query.
     *
     * @var int Can be either PHP_QUERY_RFC3986 or PHP_QUERY_RFC1738.
     */
    protected $encodingType = PHP_QUERY_RFC3986;

    /**
     * @inheritdoc
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->endpoint.'/oauth/authorize', $state);
    }

    /**
     * @inheritdoc
     */
    protected function getTokenUrl()
    {
        return $this->endpoint.'/oauth2/token';
    }

    /**
     * @inheritdoc
     */
    public function getAccessTokenResponse($code)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $form_params = $this->getTokenFields($code);
        $form_params['grant_type'] = 'authorization_code';

        $response = $this->getHttpClient()->post(
            $this->getTokenUrl(),
            compact('headers', 'form_params')
        );

        return json_decode($response->getBody(), true);
    }

    /**
     * @inheritdoc
     */
    protected function getUserByToken($token)
    {
        return [
            'token' => $token,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user);
    }
}

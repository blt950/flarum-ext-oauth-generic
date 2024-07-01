<?php

/*
 * This file is part of blt950/oauth-generic.
 *
 * Copyright (c) Blt950.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace blt950\OauthGeneric\Providers;

use Flarum\Forum\Auth\Registration;
use Flarum\Foundation\Application;
use FoF\OAuth\Provider;
use League\OAuth2\Client\Provider\AbstractProvider;

class Generic extends Provider
{
    /**
     * @var GenericProvider
     */
    protected $provider;

    public function icon(): string
    {
        return 'fas fa-key';
    }

    public function name(): string
    {
        return 'generic';
    }

    public function link(): string
    {
        return 'heya';
    }

    public function fields(): array
    {
        return [
            'client_id'     => 'required',
            'client_secret' => 'required',
            'scopes' => '',
            'authorization_endpoint' => 'required',
            'token_endpoint' => 'required',
            'user_information_endpoint' => 'required',
            'id_parameter' => 'required',
            'display_name_parameter' => 'required',
            'email_address_parameter' => 'required',
            'force_userid' => 'required|boolean',
            'force_name' => 'required|boolean',
            'force_email' => 'required|boolean',
        ];
    }

    public function provider(string $redirectUri): AbstractProvider
    {
        return $this->provider = new GenericProvider([
            'clientId'     => $this->getSetting('client_id'),
            'clientSecret' => $this->getSetting('client_secret'),
            'scopes'       => $this->getSetting('scopes'),
            'urlAuthorize' => $this->getSetting('authorization_endpoint'),
            'urlAccessToken' => $this->getSetting('token_endpoint'),
            'urlResourceOwnerDetails' => $this->getSetting('user_information_endpoint'),
            'userId' => $this->getSetting('id_parameter'),
            'userDisplayName' => $this->getSetting('display_name_parameter'),
            'userEmailAddress' => $this->getSetting('email_address_parameter'),
            'redirectUri'  => $redirectUri,
            'userAgent'     => 'Flarum:FoF-OAuth:'.Application::VERSION.' (by /u/Background_Stress252)',
        ]);
    }

    public function suggestions(Registration $registration, $user, string $token)
    {
        /** @var GenericResourceOwner $user */

        $registrationBuilder = $registration;

        if($this->getSetting('force_userid')) {
            $registrationBuilder->provide('username', $user->getId());
        } else {
            $registrationBuilder->suggest('username', $user->getId());
        }

        if($this->getSetting('force_name')) {
            $registrationBuilder->provide('nickname', $user->getName());
        } else {
            $registrationBuilder->suggest('nickname', $user->getName());
        }

        if($this->getSetting('force_email')) {
            $registrationBuilder->provideTrustedEmail($user->getEmail());
        } else {
            $registrationBuilder->suggest('email', $user->getEmail());
        }

        $registrationBuilder->setPayload($user->toArray());
    }
}

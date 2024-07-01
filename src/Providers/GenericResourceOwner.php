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

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class GenericResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Creates new resource owner.
     *
     * @param array $response
     */
    public function __construct(array $response, string $userId, string $userName, string $userEmail)
    {
        $this->response = $response;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
    }

    /**
     * @var array
     * The decoded resource owner response.
     */

    // Thanks to Moodle for this snippet
    // https://github.com/moodle/moodle/blob/48ad73619f870e4fd87240bd3c74202a300da6b2/lib/classes/oauth2/client.php#L255
    public static function getOAuthProperty($property, $data)
    {
        // Convert to object
        $data = json_decode(json_encode($data));
        
        // Recursive function to get property
        $getfunc = function ($obj, $prop) use (&$getfunc) {
            $proplist = explode('-', $prop, 2);
            if (! isset($proplist[0]) || ! isset($obj->{$proplist[0]})) {
                return null;
            }
            $obj = $obj->{$proplist[0]};

            if (count($proplist) > 1) {
                return $getfunc($obj, $proplist[1]);
            }

            return $obj;
        };

        // Get property
        $resolved = $getfunc($data, $property);
        if (isset($resolved) && $resolved != '') {
            return $resolved;
        }

        return null;
    }

    /**
     * Get resource owner id.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this::getOAuthProperty($this->userId, $this->response);
    }

    /**
     * Get resource owner name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this::getOAuthProperty($this->userName, $this->response);
    }

    /**
     * Get resource owner email address.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this::getOAuthProperty($this->userEmail, $this->response);
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}

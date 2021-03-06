<?php

/**
 * Copyright 2017 American Express Travel Related Services Company, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

declare(strict_types=1);

namespace AmericanExpress\HyperledgerFabricClient\Config;

use AmericanExpress\HyperledgerFabricClient\Exception\BadMethodCallException;
use AmericanExpress\HyperledgerFabricClient\Exception\InvalidArgumentException;
use AmericanExpress\HyperledgerFabricClient\HashAlgorithm;
use AmericanExpress\HyperledgerFabricClient\Organization\OrganizationOptions;
use AmericanExpress\HyperledgerFabricClient\Organization\OrganizationOptionsInterface;
use function igorw\get_in;

final class ClientConfig implements ClientConfigInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * ClientConfig constructor.
     * @param array $config
     * @throws InvalidArgumentException
     */
    public function __construct(array $config)
    {
        $this->config = array_merge(
            [
                'timeout' => 5000,
                'epoch' => 0,
                'crypto-hash-algo' => 'sha256',
                'nonce-size'  => 24,
                'organizations' => [],
            ],
            $config
        );

        $hash = $this->getIn(['crypto-hash-algo']);

        if (!$hash instanceof HashAlgorithm) {
            try {
                $this->config['crypto-hash-algo'] = new HashAlgorithm((string) $hash);
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException(
                    "Unable to create ClientConfig; Invalid 'crypto-hash-algo' supplied",
                    $e->getCode(),
                    $e
                );
            }
        }

        $this->config['organizations'] = array_map(function (array $data) {
            try {
                return new OrganizationOptions($data);
            } catch (BadMethodCallException $e) {
                throw new InvalidArgumentException('Cannot create ClientConfig; invalid organizations key', 0, $e);
            }
        }, $this->config['organizations']);
    }

    /**
     * @param string[] $keys
     * @param mixed $default
     * @return mixed|null
     */
    public function getIn(array $keys = [], $default = null)
    {
        return get_in($this->config, $keys, $default);
    }

    /**
     * @return int
     */
    public function getNonceSize(): int
    {
        return (int) $this->getIn(['nonce-size']);
    }

    /**
     * @return HashAlgorithm
     */
    public function getHashAlgorithm(): HashAlgorithm
    {
        return $this->getIn(['crypto-hash-algo']);
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return (int) $this->getIn(['timeout']);
    }

    /**
     * @return int
     */
    public function getEpoch(): int
    {
        return (int) $this->getIn(['epoch']);
    }

    /**
     * @param string $name
     * @return OrganizationOptionsInterface|null
     * @throws \AmericanExpress\HyperledgerFabricClient\Exception\BadMethodCallException
     */
    public function getOrganizationByName(string $name): ?OrganizationOptionsInterface
    {
        $organizations = array_filter(
            $this->getIn(['organizations'], []),
            function (OrganizationOptionsInterface $organization) use ($name) {
                return $organization->getName() === $name;
            }
        );

        return \count($organizations) > 0 ? \reset($organizations) : null;
    }

    /**
     * @return OrganizationOptionsInterface
     */
    public function getDefaultOrganization(): OrganizationOptionsInterface
    {
        $organizations = $this->getIn(['organizations']);

        return \reset($organizations);
    }
}

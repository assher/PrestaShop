<?php

/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
declare(strict_types=1);

namespace PrestaShopBundle\Translation\DTO;

class MessageTranslation
{
    /**
     * @var string
     */
    private $defaultTranslation;

    /**
     * @var string|null
     */
    private $fileTranslation;

    /**
     * @var string|null
     */
    private $userTranslation;

    public function __construct(string $defaultTranslation)
    {
        $this->defaultTranslation = $defaultTranslation;
    }

    public function getKey(): string
    {
        return $this->defaultTranslation;
    }

    public function setFileTranslation(string $fileTranslation): self
    {
        $this->fileTranslation = $fileTranslation;

        return $this;
    }

    public function setUserTranslation(string $userTranslation): self
    {
        $this->userTranslation = $userTranslation;

        return $this;
    }

    /**
     * Returns whether a message is translated or not.
     * It's TRUE if one of fileTranslation or userTranslation is not null
     */
    public function isTranslated(): bool
    {
        return null !== $this->fileTranslation || null !== $this->userTranslation;
    }

    /**
     * Check if data contains search word.
     *
     * @param array $search
     *
     * @return bool
     */
    public function contains(array $search): bool
    {
        $contains = true;
        foreach ($search as $s) {
            $s = strtolower($s);
            $contains &= false !== strpos(strtolower($this->defaultTranslation), $s)
                || (null !== $this->fileTranslation && false !== strpos(strtolower($this->fileTranslation), $s))
                || (null !== $this->userTranslation && false !== strpos(strtolower($this->userTranslation), $s));
        }

        return (bool) $contains;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'default' => $this->defaultTranslation,
            'xliff' => $this->fileTranslation,
            'database' => $this->userTranslation,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Provider;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Eloquent Provider.
 *
 * @package App\Provider
 */
class Eloquent extends Capsule
{
    /**
     * Database manager constructor.
     *
     * @param array<string> $settings
     */
    public function __construct(array $settings = [])
    {
        parent::__construct();

        $this->addConnection($settings);

        // Make this Capsule instance available globally via static methods
        $this->setAsGlobal();

        // Setup the Eloquent ORM
        $this->bootEloquent();
    }

    /**
     * Return capsule instance.
     *
     * @return self
     */
    public function getCapsule(): Eloquent
    {
        return $this;
    }
}

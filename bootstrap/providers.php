<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Modules\Core\Providers\CoreServiceProvider::class,
    App\Modules\Identity\Providers\IdentityServiceProvider::class,
    App\Modules\Products\Providers\ProductsServiceProvider::class,
    App\Modules\ProjectProgress\Providers\ProjectProgressServiceProvider::class,
    App\Modules\Website\Providers\WebsiteServiceProvider::class,
];
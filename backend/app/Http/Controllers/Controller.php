<?php

namespace App\Http\Controllers;

use App\Helpers\Response\HandleJsonResponses;
use App\Providers\AuthServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HandleJsonResponses;

    protected $user = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            return $next($request);
        });
    }

    /**
     * Check authorize a given action.
     *
     * @param string $ability
     * @param array|mixed $arguments
     * @return void
     *
     * @throws AuthorizationException
     */
    protected function authorize(string $ability, $arguments = []): void
    {
        $arguments = Arr::wrap($arguments);

        if (Str::contains($ability, '.')) {
            list($policyAlias, $method) = explode('.', $ability, 2);
        } else {
            $policyAlias = $ability;
            $method = debug_backtrace()[1]['function'];
        }
        $result = app(AuthServiceProvider::$gateDefines[$policyAlias])
            ->{$method}($this->user, ...$arguments);
        if (!$result) {
            throw new AuthorizationException('This action is unauthorized.');
        }
    }
}

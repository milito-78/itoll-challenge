<?php

namespace App\Http\Middleware;

use App\Domains\Enums\AccessTokenTypeEnum;
use App\Repositories\Schemas\Company;
use App\Services\AuthService;
use App\Services\CompanyService;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateCompanyMiddleware
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly CompanyService $companyService
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token)
            throw new AuthenticationException();

        $found = $this->authService->verifyToken($token,AccessTokenTypeEnum::Transporter);
        if (!$found)
            throw new AuthenticationException();
        $transporter = $this->companyService->details($found->user_id);
        if (!$transporter)
            throw new AuthenticationException();

        auth("company-api")->setUser(Company::fromDomain($transporter));

        return $next($request);
    }
}

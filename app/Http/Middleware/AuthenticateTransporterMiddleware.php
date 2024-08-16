<?php

namespace App\Http\Middleware;

use App\Domains\Enums\AccessTokenTypeEnum;
use App\Repositories\Schemas\Transporter;
use App\Services\AuthService;
use App\Services\TransporterService;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateTransporterMiddleware
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly TransporterService $transporterService
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token)
            throw new AuthenticationException();

        $found = $this->authService->verifyToken($token,AccessTokenTypeEnum::Transporter);
        if (!$found)
            throw new AuthenticationException();
        $transporter = $this->transporterService->details($found->user_id);
        if (!$transporter)
            throw new AuthenticationException();

        auth("transporter-api")->setUser(Transporter::fromDomain($transporter));

        return $next($request);
    }
}

<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
    
    use Config;

    class JwtMiddleware extends BaseMiddleware
    {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            try {
                $user = JWTAuth::parseToken()->authenticate();
                
                //echo $user->current_login_token.'<br>';print_r($request->bearerToken());exit;
                //
                //if password change from one device then logout from another device
                if($user->current_login_token != $request->bearerToken()) {
                    return response()->json(['status' => Config::get('app.status_codes.NP_INVALID_TOKEN'), 'message' => 'Token mismatch, please login again' ]);
                }
                
                if(!$user->id) {
                    return response()->json(['status' => Config::get('app.status_codes.NP_INVALID_TOKEN'), 'message' => 'Token Expired' ]);
                } elseif($user->suspended == 1) {
                    return response()->json(['status' => Config::get('app.status_codes.NP_INVALID_TOKEN'), 'message' => 'Account suspended' ]);
                } elseif(!$user->status) {
                    return response()->json(['status' => Config::get('app.status_codes.NP_INVALID_TOKEN'), 'message' => 'Account inactive' ]);
                    
                }
                
            } catch (Exception $e) {
                
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['status' => Config::get('app.status_codes.NP_INVALID_TOKEN'), 'message' => 'Invalid token' ]);
                    //return response()->json(['status' => 'Token is Invalid']);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    //return response()->json(['status' => 'Token is Expired']);
                    return response()->json(['status' => Config::get('app.status_codes.NP_INVALID_TOKEN'), 'message' => 'Token expired']);
                }else{
                    //return response()->json(['status' => 'Authorization Token not found']);
                    return response()->json(['status' => Config::get('app.status_codes.NP_INVALID_TOKEN'), 'message' => 'Token not found' ]);
                }
            }
            return $next($request);
        }
    }
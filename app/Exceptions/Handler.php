<?php

namespace App\Exceptions;

use Config;
use Auth;
use Exception;
use ErrorException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


class Handler extends ExceptionHandler
{

     /**

     * A list of the exception types that should not be reported.

     *

     * @var array

     */

    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        QueryException::class,
        ValidationException::class,
        TokenMismatchException::class,
        FatalErrorException::class,
    ];


     /**

     * Report or log an exception.

     *

     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.

     *

     * @param  \Exception  $e

     * @return void

     */

    public function report(Exception $e)
    {
        parent::report($e);
    }


     /**

     * Render an exception into an HTTP response.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Exception  $e

     * @return \Illuminate\Http\Response

     */

    public function render($request, Exception $e)
    {
        $debug = Config::get('app.debug');

        if($this->isHttpException($e)){
            if (view()->exists('errors.'.app()->getLocale().'.'.$e->getStatusCode()))
            {
                //return response()->view('errors.'.app()->getLocale().'.'.$e->getStatusCode(), [], $e->getStatusCode());
                if (auth()->guard('admin')->check()) {
                    //return response()->view('errors.'.app()->getLocale().'.404');
                    return redirect('/dashboard');
                } else {
                   //return response()->view('errors.'.app()->getLocale().'.loginerror');
                   return redirect('/login'); 
                }
            }
        }

        if ($e instanceof TokenMismatchException) {
            return redirect('/logout');
        }

        if ($debug==false) {
            if ($e instanceof QueryException || $e instanceof FatalErrorException || $e instanceof NotFoundHttpException || $e instanceof ErrorException || $e instanceof ValidationException) {
                if (auth()->guard('admin')->check()) {
                    return response()->view('errors.'.app()->getLocale().'.error');
                } else {
                   return response()->view('errors.'.app()->getLocale().'.loginerror'); 
                }
            }
        }

        /*if ($e instanceof FatalErrorException) {
            if (auth()->guard('admin')->check()) {
                return response()->view('errors.'.app()->getLocale().'.error');
            } else {
               return response()->view('errors.'.app()->getLocale().'.loginerror'); 
            }
        }

        if ($e instanceof NotFoundHttpException) {
            if (auth()->guard('admin')->check()) {
                return response()->view('errors.'.app()->getLocale().'.error');
            } else {
               return response()->view('errors.'.app()->getLocale().'.loginerror'); 
            }
        }

        if ($e instanceof ErrorException) {
            if (auth()->guard('admin')->check()) {
                return response()->view('errors.'.app()->getLocale().'.error');
            } else {
               return response()->view('errors.'.app()->getLocale().'.loginerror'); 
            }
        }

        if ($e instanceof ValidationException) {
            if (auth()->guard('admin')->check()) {
                return response()->view('errors.'.app()->getLocale().'.error');
            } else {
               return response()->view('errors.'.app()->getLocale().'.loginerror'); 
            }
        }*/

        return parent::render($request, $e);

        //return response()->view('errors.503');

    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

}







?>
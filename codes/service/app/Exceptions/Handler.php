<?php

namespace App\Exceptions;

use App\Helpers\Jump;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use Jump;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // 如果config配置debug为true ==>debug模式的话让laravel自行处理
        /*if(config('app.debug')){
            return parent::render($request, $exception);
        }*/
        return $this->handle($request, $exception);
    }

    /**
     * 新添加的handle函数
     * @param $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Exception $exception){
        //  只处理自定义的APIException异常


        if($exception instanceof ValidatorException) {
            return $this->error($exception->getMessage(), $exception->getData(), $exception->getJumpUrl(), $exception->getWaitTime(), $exception->getHttpStatus());
        } else if($exception instanceof ApiException) {
            return $this->error($exception->getMessage(), $exception->getData(), $exception->getJumpUrl(), $exception->getWaitTime(), $exception->getHttpStatus());
        } else if ($exception instanceof QueryException) {
            return $this->error('系统错误，请稍后再试！'.$exception->getMessage());
        } else if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return $this->error('请先登录！', '', '', 2, 200, [], ValidatorException::NO_LOGIN);
        }

        return parent::render($request, $exception);
    }

}

<?php
/**
 * 后端api接口签名认证中间件
 * User: fengyan
 * Date: 18-9-13
 * Time: 下午5:03
 */

namespace App\Http\Middleware;

use App\Exceptions\ValidatorException;
use Closure;
use App\Http\Request\Manage\ValidateSignRequest;
use Illuminate\Http\Request;

class ValidateSignManage
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/manage/login'
    ];


    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ValidatorException
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->all('basicData');

        $data = empty($data) ? [] : $data;

        if (empty($data['signature'])) {
            throw new ValidatorException('签名值不能为空');
        }

        if ($this->inExceptArray($request) || $this->createValiidateSign($data, env('APP_KEY')) === $data['signature']){
            return $next($request);
        }

        throw new ValidatorException('签名验证失败');
    }

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 签名规则
     * @param array $data
     * @param $signKey
     * @return string
     */
    private function createValiidateSign(array $data, $signKey)
    {
        unset($data['signature']);
        ksort($data);
        $sourceString = "";
        $idx = 1;
        $len = count($data);
        foreach ($data as $key => $value) {
            $sourceString = $sourceString . $key . "=";
            if (is_array($value))
                $sourceString = $sourceString . json_encode($value);
            else
                $sourceString = $sourceString . $value;

            if ($idx != $len) {
                $sourceString = $sourceString . "&";
            }

            $idx++;
        }

        $sign = md5(base64_encode($sourceString . $signKey));

        return $sign;
    }
}
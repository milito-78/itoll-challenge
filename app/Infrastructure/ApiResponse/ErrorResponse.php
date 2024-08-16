<?php

namespace App\Infrastructure\ApiResponse;

use App\Infrastructure\ApiResponse\Entities\ValidationErrorEntity;

class ErrorResponse extends DataResponse
{

    public static $statusLabelTexts = [
        400 => 'bad-request',
        401 => 'unauthorized',
        402 => 'payment-required',
        403 => 'forbidden',
        404 => 'not-found',
        405 => 'method-not-allowed',
        406 => 'not-acceptable',
        407 => 'proxy-authentication-required',
        408 => 'request-timeout',
        409 => 'conflict',
        410 => 'gone',
        411 => 'length-required',
        412 => 'precondition-failed',
        413 => 'content-too-large',                                           // RFC-ietf-httpbis-semantics
        414 => 'uri-too-long',
        415 => 'unsupported-media-type',
        416 => 'range-not-satisfiable',
        417 => 'expectation-failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'misdirected-request',                                         // RFC7540
        422 => 'unprocessable-content',                                       // RFC-ietf-httpbis-semantics
        423 => 'locked',                                                      // RFC4918
        424 => 'failed-dependency',                                           // RFC4918
        425 => 'too-early',                                                   // RFC-ietf-httpbis-replay-04
        426 => 'upgrade-required',                                            // RFC2817
        428 => 'precondition-required',                                       // RFC6585
        429 => 'too-many-requests',                                           // RFC6585
        431 => 'request-header-fields-too-large',                             // RFC6585
        451 => 'unavailable-for-legal-reasons',                               // RFC7725
        500 => 'internal-server-error',
        501 => 'not-implemented',
        502 => 'bad-gateway',
        503 => 'service-unavailable',
        504 => 'gateway-timeout',
        505 => 'http-version-not-supported',
        506 => 'variant-also-negotiates',                                     // RFC2295
        507 => 'insufficient-storage',                                        // RFC4918
        508 => 'loop-detected',                                               // RFC5842
        510 => 'not-extended',                                                // RFC2774
        511 => 'network-authentication-required',                             // RFC6585
    ];

    const INTERNAL_SERVER_ERROR_LABEL = "internal-server-error";


    protected string $message;
    protected string $error;
    protected array $errors;
    protected int $code;

    /**
     * @param string|null $message
     * @param string|null $error
     * @param int $code
     * @param array $errors
     * @param mixed $data
     */
    public function __construct(
        ?string $message = null,
        ?string $error = self::INTERNAL_SERVER_ERROR_LABEL,
        int $code = 400,
        array $errors = [],
        mixed $data = null
    )
    {
        parent::__construct(
            message: $message,
            code: $code,
            data: $data,
        );
        $this->setError($error??self::INTERNAL_SERVER_ERROR_LABEL);
        $this->setErrors($errors);
    }

    public function setError(string $error) : self
    {
        $this->error = $error;
        return $this;
    }

    public function setErrors(array $errors) : self
    {
        $temp = [];
        foreach ($errors as $error){
            if (key_exists("id",$error) && key_exists("messages",$error)) {
                if (!is_array($error["messages"]))
                    $messages = [$error["messages"]];
                else
                    $messages = $error["messages"];

                $temp[] = new ValidationErrorEntity($error["id"],$messages);
            }elseif (!array_is_list($error)){
                $temp[] = new ValidationErrorEntity("_all",$error);
            }
        }

        $this->errors = $temp;
        return $this;
    }

    public function toArray():array
    {
        $array = parent::toArray();
        $array["error"] = $this->error;
        if ($this->errors){
            $array["errors"] = $this->errors;
        }

        if ($this->data){
            $array["data"] = $this->data;
        }elseif(is_null($this->data)){
            unset($array["data"]);
        }
        return $array;
    }


    public function trans($label) : string
    {
        return __("response.labels." . $label);
    }
}

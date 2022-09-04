<?php

namespace App\Helpers;

class CustomRenderHelper
{
    public static function renderError($errorArray, $field)
    {
        if ($errorMessage = $errorArray->first($field)) {
            echo "<div class='text-danger mt-1'>$errorMessage</div>";
        }
    }

    public static function renderHTTPResponseMessage()
    {

        $class = 'alert-danger';
        $header = 'Error';
        $message = '';

        if ($isResponseFound = session()->has('response')) {
            $response = session()->get('response');
            if ($response->type == 'success') {
                $header = 'Success';
                $class = 'alert-success';
            }
            $message = $response->message;
        }

        $returnMessage = "
            <div class='row m-1'>
                <div class='col-12'>
                <div class='alert $class alert-dismissible fade show' role='alert'>
                    <strong>$header</strong> $message
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    </div>
                </div>
            </div>
        ";

        echo $isResponseFound ? $returnMessage : null;
    }
}

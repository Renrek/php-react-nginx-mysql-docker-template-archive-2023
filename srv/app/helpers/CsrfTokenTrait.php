<?php declare(strict_types=1);

namespace App\Helpers;

trait CsrfTokenTrait {

    private function generateCsrfToken(): string {
        return \bin2hex(\random_bytes(64));
    }

    protected function getCsrfToken(): string {
        if (!isset($_SESSION['csrfToken'])) {
            $_SESSION["csrfToken"] = $this->generateCsrfToken();
        }
        return $_SESSION["csrfToken"];
    }

    protected function generateCsrfFormElement(): string {
        return '<input name="csrfToken" type="hidden" value="'
            .$this->getCsrfToken().'" />';
    }
}
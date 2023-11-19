<?php declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\Controllers\BaseViewController;
use App\Config\ResponseConst;

class NotFoundController extends BaseViewController {

    public function index(): void {
        http_response_code(ResponseConst::NOT_FOUND);
        $this->render('notFound/index');
    }
}
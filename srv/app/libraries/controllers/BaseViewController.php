<?php declare(strict_types=1);

    namespace App\Libraries\Controllers;

    use App\Helpers\RedirectHelper;
    use App\Exceptions\ViewNotFoundException;
    use App\Libraries\Controllers\ControllerTrait;
    use App\Libraries\Injection\ContainerTrait;
    use App\Helpers\CsrfTokenTrait;

    class BaseViewController
    {
        use CsrfTokenTrait;
        use ControllerTrait;
        use ContainerTrait;

        protected string $header = 'header.php';
        protected string $footer = 'footer.php';
        
        public function render(
            string $view, 
            object|null $data = null, 
            string $title = SITE_NAME 
        ) : void {          
            if(file_exists('../app/views/pages/'. $view . '.php')){
                $headerPath = APP_ROOT . '/views/include/'.$this->header;
                $footerPath = APP_ROOT . '/views/include/'.$this->footer;
                [$scripts, $styles] = $this->lookupAssets();
                require_once '/srv/app/views/layout.php';
            } else {
                throw new ViewNotFoundException();
            }
        }

        // If load times ever get passed 500ms this will be a good candidate for 
        // including within a build-step
        private function lookupAssets(): array {
            $scripts = '';
            $styles = '';
            $files = scandir('/srv/public/assets');
            foreach ($files as $file){
                if(str_starts_with($file, 'main.') && str_ends_with($file, '.css')){
                    $styles .= '<link rel="stylesheet" href="/assets/'.$file.'">';
                }
                if(str_starts_with($file, 'main.') && str_ends_with($file, '.js')){
                    $scripts .= '<script src="/assets/'.$file.'"></script>';
                }
            }
            return [$scripts, $styles];
        }
    }
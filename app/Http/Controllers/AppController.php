<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AppController extends BackendController
{
    /*
    private function render($path){
        $renderer_source = File::get(base_path('node_modules/vue-server-renderer/basic.js'));
        $app_source = File::get(public_path('../resources/js/entry-server.js'));

        $v8 = new V8Js();
        ob_start();
        $js =
        <<<EOT
        var process = {env:{VUE_ENV:"server",NODE_ENV:"development"}};
        this.global = {process:process};
        var url = "$path";
        EOT;



        $v8->executeString($js);
        $v8->executeString($renderer_source);
        $v8->executeString($app_source);
        dd($v8);

        return ob_get_clean();
    }

    public function get(Request $request)
    {
        $ssr = $this->render($request->path());
        // $ssr="";

        return view('spa-index',['ssr'=>$ssr]);
    }
    */

    public function get()
    {
        $app_ssr = true;

        return view('spa-index', compact('app_ssr'));
    }
}
